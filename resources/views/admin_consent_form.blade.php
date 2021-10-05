@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (Auth::user()->authorized && Gate::allows('manage-data'))
                <div class="card">
                    <div class="card-header">
                        <div class="float-left"><h2>Consent Form</h2></div>
                        {{-- <div class="float-right">
                            <a href="{{ route ('consent_forms.destroy-get', $consent_form->id) }}" class="btn btn-info" title="Delete submission" onclick="return confirm('Are you sure you wish to delete this submission? This cannot be undone!')"><i class="fas fa-trash-alt"></i></a>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                         @endif

                        <table width="100%">
                            <tr><th>ID</th><td>{{ $consent_form->id }}</td></tr>
                            <tr><th>Email for map</th><td>{{ $consent_form->email_for_map }}</td></tr>
                            <tr><th>Email for gift</th><td>{{ $consent_form->email_for_gift }}</td></tr>
                            <tr><th>Language</th><td>{{ $consent_form->language }}</td></tr>
                            @if(config('app.wlar_request_consent_publication'))
                            <tr><th>Publication Permission</th><td>{{ $consent_form->public ? "granted" : "withheld" }}</td></tr>
                            @endif
                            <tr><th>Date</th><td>{{ $consent_form->created_at }}</td></tr>
                        </table>
                    </div>
                </div>
                <br/>
                @foreach ($demographic_questionnaires as $demographic_questionnaire)
                    <div class="card">
                    <div class="card-header"><div class="float-left"><h2>Questionnaire (ID#: {{ $demographic_questionnaire->id }})</h2></div>
                    <div class="float-right"><a href="{{ route ('demographic_questionnaires.destroy-get', $demographic_questionnaire->id) }}" class="btn btn-info" title="Delete this questionnaire" onclick="return confirm('Are you sure you wish to delete this questionnaire? This cannot be undone!')"><i class="fas fa-trash-alt"></i></a></div>
                    </div>
                        <div class="card-body">
                            <table style="width:100%;">
                                @foreach ($demographic_questionnaire->toArray() as $key => $demo)
                                    @if ($key != "id" && $key != "consent_form_id" && $key != "updated_at" && $key != "created_at")
                                    <tr><th>{{ $key }}</th><td>{{ $demo }}</td></tr>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <br/>
                @endforeach
                <div class="card">
                    <div class="card-header"><h1>Recordings</h1>
                    </div>
                        <div class="card-body">
                            @if (!$recordings->isEmpty())
                            <table style="width:100%;">
                                <tr><th>ID</th><th>Player</th><th>Actions</th></tr>
                            @endif
                                @forelse ($recordings as $recording)
                                    {{-- @if ($key != "consent_form_id" && $key != "updated_at" && $key != "created_at") --}}
                                    {{-- <tr><th>{{ $key }}</th><td>{{ $rec }}</td></tr>  --}}
                                    <tr><td>{{ $recording->id }}</td><td><audio controls preload="metadata" style=" width:500px;">
                                        <source src="{{ Storage::url('audio/' . $recording->consent_form_id . '/' . $recording->recording_filename) }}" type="audio/wav">
                                        Your browser does not support the audio element.
                                    </audio><br /></td><td><a href="{{ Storage::url('audio/' . $recording->consent_form_id . '/' . $recording->recording_filename) }}" class="btn btn-info" title="Download"><i class="fas fa-download"></i></a> <a href="{{ route ('recordings.destroy-get', $recording->id) }}" class="btn btn-info" title="Delete recording" onclick="return confirm('Are you sure you wish to delete this recording? This cannot be undone!')"><i class="fas fa-trash-alt"></i></a></td></tr>
                                    {{-- @endif --}}
                                    @empty
                                    No recordings have been submitted under this consent form.
                                @endforelse
                            @if (!$recordings->isEmpty())
                                </table>
                            @endif
                        </div>
                    </div>
                    <br/>
            @endif
        </div>
    </div>
</div>
@endsection
