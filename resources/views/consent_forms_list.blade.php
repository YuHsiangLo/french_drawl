@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (Auth::user()->authorized && Gate::allows('manage-data'))
            <div class="card">
                <div class="card-header">All Submissions</div>
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
                    @if ($consent_forms)
                    <table style="width:100%;">
                        <tr><th>ID</th><th>Email for map</th><th>Email for gift</th><th>Date</th><th><i class="fas fa-clipboard-list" title="Was questionnaire received?"></i></th><th><i class="fas fa-microphone" title="Was recording received?"></i></th><th>Actions</th></tr>
                        @foreach ($consent_forms as $consent_form)
                            <tr><td>{{ $consent_form->id }}</td><td>{{ $consent_form->email_for_map }}</td><td>{{ $consent_form->email_for_gift }}</td><td>{{ $consent_form->created_at }}</td><td>{!! $consent_form->has_demographic_questionnaire ? '<i class="far fa-check-square" title="Questionnaire Received"></i>' : '<i class="far fa-square" title="Questionnaire NOT Received"></i>' !!}</td><td>{!! $consent_form->has_recording ? '<i class="far fa-check-square" title="Recording Received"></i>' : '<i class="far fa-square" title="Recording NOT Received"></i> ' !!}</td><td><a href="{{ route ('consent_forms.show', $consent_form->id) }}" class="btn btn-info" title="View submission"><i class="fas fa-eye"></i></a> <a href="{{ route ('consent_forms.download_recording', $consent_form->id) }}" class="btn btn-info" title="Download recording"><i class="fas fa-download"></i></a> <a href="{{ route ('consent_forms.destroy-get', $consent_form->id) }}" class="btn btn-info" title="Delete submission" onclick="return confirm('Are you sure you wish to delete this submission? This cannot be undone!')"><i class="fas fa-trash-alt"></i></a></td></tr>
                        @endforeach
                    </table>
                    @else
                    There are no submissions in the database.
                    <br/>
                    @endif
                    <br/>
                        <a href="{{ route('consent_forms.export') }}">Export All Submissions to .CSV</a> |
                        <a href="{{ route('admin') }}">Go Back to the Admin Dashboard</a>
                </div>
            </div>
            @endif
            <br/>

        </div>
    </div>
</div>
@endsection
