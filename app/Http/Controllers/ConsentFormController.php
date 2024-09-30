<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Recording;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use App\ConsentForm;
use App\Exports\ConsentFormsExport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class ConsentFormController extends Controller
{
    /**
     * Create a new consent form instance so that user can submit
     */
    public function create()
    {
        return view('consent_form',
            [ 'locale' => \App::getLocale() ]);
    }

    /**
     * Save the user's consent form
     */
    //TODO: rewrite
    public function store(Request $request)
    {
        // define variables and set to empty values
        //$name = $email = $code = "";

        //$public = false;
        $email_for_map = $request->email_map;
        $email_for_gift = $request->email_gift;
        //$name = $request->user_name;
        //$email = $request->user_email;
        //if ($request->share_box == "on") {
        //    $public = true;
        //};
        $language = \App::getLocale();

        $testModel = ConsentForm::create([
            'email_for_map' => $email_for_map,
            'email_for_gift' => $email_for_gift,
            //'public' => $public,
            'language' => $language
        ]);

        $request->session()->put('user_id', $testModel->getKey());

        return redirect()->route('demographic_questionnaires.create');
    }

    // delete the consent form
    public function destroy($id)
    {
        if (Gate::allows('manage-data')) {
            $consent_form = app(\App\ConsentForm::class)->find($id);
            if (is_null($consent_form)) {
                // User could not be found
                return back()->with('error', 'Delete failed - this submission could not be found!');
            };
            if ((app(\App\DemographicQuestionnaire::class)->where('consent_form_id',$id)->get()->count() > 0 ) || (app(\App\Recording::class)->where('consent_form_id',$id)->get()->count() > 0 ))  {
                return back()->with('error', 'This submission cannot be deleted - submission includes questionnaire and/or recording. View the submission details and delete the recording and/or questionnaire first.');
            }
            $consent_form->delete();
            return back()->with('status', 'Submission for ' . $consent_form->name . ' (ID: ' . $consent_form->id . ') has been successfully deleted!');
        }

        return redirect('admin')->with('error', 'You are not currently authorized to manage submissions!');
    }

    // show the consent form
    public function show($id)
    {
        if (Gate::allows('manage-data')) {
            $consent_form = app(\App\ConsentForm::class)->find($id);
            if (is_null($consent_form)) {
                // User could not be found
                return back()->with('error', 'View failed - this submission could not be found!');
            };
            $demographic_questionnaires = app(\App\DemographicQuestionnaire::class)->where('consent_form_id',$id)->get();
            $recordings = app(\App\Recording::class)->where('consent_form_id',$id)->get();
            return view('admin_consent_form',
            [ 'consent_form' => $consent_form,
              'demographic_questionnaires' => $demographic_questionnaires,
              'recordings' => $recordings ]);

        }

        return redirect('admin')->with('error', 'You are not currently authorized to manage submissions!');
    }

    public function index()
    {
        $consentForms = [];
        foreach (ConsentForm::all()->sortByDesc("created_at") as $consentForm) {
                $consentForm->has_demographic_questionnaire = true;
                if (app(\App\DemographicQuestionnaire::class)->where('consent_form_id',$consentForm->id)->get()->count() == 0) {
                    $consentForm->has_demographic_questionnaire = false;
                }
                $consentForm->has_recording = true;
                if (app(\App\Recording::class)->where('consent_form_id',$consentForm->id)->get()->count() == 0) {
                    $consentForm->has_recording = false;
                }
                $consentForms[] = $consentForm;
        }
        //Log::info("Consent forms content is " . json_encode($consentForms));

        return view('consent_forms_list',
            [ 'consent_forms' => $consentForms ]);
    }

    public function export()
    {
        if (Gate::allows('manage-data')) {
            return Excel::download(new ConsentFormsExport, 'submissions.csv');
        }
        return redirect('admin')->with('error', 'You are not currently authorized to manage submissions!');
    }

    public function download_all_recordings() {
        if (Gate::allows('manage-data')) {
            $zip = new \ZipArchive();
            $fileName = 'frenchDRAWL_recordings.zip';
            $recordings = Recording::all();
            if ($zip->open(public_path($fileName), \ZipArchive::CREATE) === true) {
                foreach ($recordings as $recording) {
                    $zip->addFile(
                        storage_path('app/audio/' . $recording->consent_form_id . '/' . $recording->recording_filename),
                        'audio/' . $recording->consent_form_id . '/' . $recording->recording_filename
                    );
                }
                $zip->close();
            }

            return response()->download(public_path($fileName))->deleteFileAfterSend(true);
        }
        return redirect('admin')->with('error', 'You are not currently authorized to manage submissions!');
    }

    public function download_recording($id) {
        if (Gate::allows('manage-data')) {
            $zip = new \ZipArchive();
            $fileName = 'frenchDRAWL_recording_'.$id.'.zip';
            $recordings = app(\App\Recording::class)->where('consent_form_id', $id)->get();

            if ($recordings->count() === 0) {
                return back()->with('error', 'This submission does not have recordings.');
            }

            if ($zip->open(public_path($fileName), \ZipArchive::CREATE) === true) {
                foreach ($recordings as $recording) {
                    $zip->addFile(
                        storage_path('app/audio/'.$recording->consent_form_id.'/'.$recording->recording_filename),
                        'audio/'.$recording->consent_form_id.'/'.$recording->recording_filename
                    );
                }
                $zip->close();
            }

            return response()->download(public_path($fileName))->deleteFileAfterSend(true);
        }
        return redirect('admin')->with('error', 'You are not currently authorized to manage submissions!');
    }
}
