<?php

namespace Tests\Feature;

use App\ConsentForm;
use App\User;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Google\Client as GoogleClient;
use Google\Service\Sheets as GoogleSheets;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Revolution\Google\Sheets\Contracts\Factory as SheetsFactory;
use Revolution\Google\Sheets\SheetsClient;
use Tests\TestCase;

class WlarTest extends TestCase
{
    use RefreshDatabase;

    private string $jsonDir = 'framework/testing/json';

    protected function setUp(): void
    {
        parent::setUp();

        // keep the JSON-backed models out of the real storage/app/json folder
        config(['model-json-storage.storage_path' => $this->jsonDir]);
        File::deleteDirectory(storage_path($this->jsonDir));
        File::makeDirectory(storage_path($this->jsonDir), 0775, true);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory(storage_path($this->jsonDir));

        parent::tearDown();
    }

    public function test_public_pages_render(): void
    {
        $this->get('/')->assertOk();
        $this->get('/welcome/fr')->assertOk();
        $this->get('/consent_forms/create')->assertOk();
        $this->get('/demographic_questionnaires/create')->assertOk();
        $this->get('/recordings/create')->assertOk();
        $this->get('/map')->assertOk();
        $this->get('/login')->assertOk();
        $this->get('/register')->assertOk();
    }

    public function test_guests_are_sent_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/login');
        $this->get('/consent_forms')->assertRedirect('/login');
    }

    public function test_user_can_register_and_is_sent_to_admin(): void
    {
        $this->post('/register', [
            'name' => 'someone',
            'email' => 'someone@example.com',
            'password' => 'a-long-password-1',
            'password_confirmation' => 'a-long-password-1',
        ])->assertRedirect('/admin');

        $this->assertAuthenticated();
        $this->get('/admin')->assertOk();
    }

    public function test_user_can_log_in_and_logged_in_user_is_redirected_from_login(): void
    {
        $user = User::factory()->create(['authorized' => true]);

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/admin');

        $this->get('/login')->assertRedirect('/admin');
    }

    public function test_gates_depend_only_on_the_authorized_flag(): void
    {
        $authorized = User::factory()->create(['authorized' => true]);
        $unauthorized = User::factory()->create(['authorized' => false]);

        $this->actingAs($authorized)->get('/admin_users')->assertOk();
        $this->actingAs($unauthorized)->get('/admin_users')->assertRedirect('admin');
        $this->actingAs($unauthorized)->get('/export/consent_forms')->assertRedirect('admin');
    }

    public function test_consent_form_is_stored_as_json_and_session_is_set(): void
    {
        $this->post('/consent_forms', [
            'email_map' => 'map@example.com',
            'email_gift' => 'gift@example.com',
        ])->assertRedirect(route('demographic_questionnaires.create'));

        $form = ConsentForm::all()->first();
        $this->assertSame('map@example.com', $form->email_for_map);
        $this->assertSame('gift@example.com', $form->email_for_gift);
        $this->assertSame($form->id, session('user_id'));
    }

    /**
     * Sends a real Revolution\Google\Sheets request through the Google API client,
    * with only the HTTP transport faked, and checks what would be sent to Google.
    */
    public function test_questionnaire_is_appended_to_the_google_sheet_and_saved(): void
    {
        config([
            'sheets.post_spreadsheet_id' => 'SPREADSHEET123',
            'sheets.post_sheet_id' => 'Responses',
        ]);

        $history = [];
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode([
                'spreadsheetId' => 'SPREADSHEET123',
                'updates' => ['updatedRows' => 1],
            ])),
        ]);
        $stack = HandlerStack::create($mock);
        $stack->push(Middleware::history($history));

        $google = new GoogleClient();
        $google->setAccessToken(['access_token' => 'fake-token', 'expires_in' => 3600, 'created' => time()]);
        $google->setHttpClient(new GuzzleClient(['handler' => $stack]));

        $this->app->instance(
            SheetsFactory::class,
            (new SheetsClient())->setService(new GoogleSheets($google))
        );

        $this->withSession(['user_id' => 7])->post('/demographic_questionnaires', [
            'Current_location' => 'Montreal',
            'Grown-up_city' => 'Quebec',
            'Age' => '30',
            'Gender' => 'F',
            'Years_in_current_location' => '5',
            'Accent' => 'Quebecois',
            'Other_languages' => 'English',
        ])->assertRedirect(route('recordings.create'));

        $this->assertCount(1, $history);

        $request = $history[0]['request'];
        $this->assertSame('POST', $request->getMethod());
        $this->assertStringContainsString('/v4/spreadsheets/SPREADSHEET123/values/Responses:append', (string) $request->getUri());

        $body = json_decode((string) $request->getBody(), true);
        $this->assertSame(
            [[7, 'Montreal', 'Quebec', '30', 'F', '5', 'Quebecois', '', 'English']],
            $body['values']
        );

        // and the questionnaire itself is saved
        $saved = app(\App\DemographicQuestionnaire::class)->where('consent_form_id', 7)->get();
        $this->assertCount(1, $saved);
        $this->assertSame('Montreal', $saved->first()->Current_location);
    }

    public function test_google_config_builds_a_client_with_the_sheets_scopes(): void
    {
        $client = app(\Revolution\Google\Client\GoogleApiClient::class)->getClient();

        $this->assertContains(GoogleSheets::SPREADSHEETS, $client->getScopes());
        $this->assertContains(GoogleSheets::DRIVE, $client->getScopes());
    }

    public function test_authorized_user_can_export_consent_forms_as_csv(): void
    {
        ConsentForm::create([
            'email_for_map' => 'map@example.com',
            'email_for_gift' => 'gift@example.com',
            'language' => 'fr',
        ]);

        $user = User::factory()->create(['authorized' => true]);

        $response = $this->actingAs($user)->get('/export/consent_forms');

        $response->assertOk();
        $this->assertStringContainsString('csv', (string) $response->headers->get('content-disposition'));
    }
}