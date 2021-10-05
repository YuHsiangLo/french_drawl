@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

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

                    {{ __('You are logged in!') }}
                    <br/>
                    {{ Auth::user()->authorized ? 'You are authorized to access data.' : 'You are not authorized to access data - another administrator must authorize you!' }}
                </div>
            </div>
            @if (Auth::user()->authorized && Gate::allows('manage-users'))
            <br/>
            <div class="card">
                <div class="card-header">Users Awaiting Authorization</div>

                <div class="card-body">
                    @if (!$users->isEmpty())
                    The following unauthorized users require authorization, or deletion if they should not have access:
                    <table width="100%">
                        <tr><th>ID</th><th>Name</th><th>Email</th><th colspan=2>Status / Actions</th></tr>
                        @foreach ($users as $user)
                            <tr><td>{{ $user->id }}</td><td>{{ $user->name }}</td><td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->authorized)
                                        Authorized
                                        @if (Auth::user() != $user)
                                            (<a href="{{ route ('admin_users.deauthorize', $user->id) }}">Deauthorize</a>)
                                        @endif
                                    @else
                                        Not Authorized
                                        @if (Auth::user() != $user)
                                            (<a href="{{ route ('admin_users.authorize', $user->id) }}">Authorize</a>)
                                        @endif
                                    @endif
                                    </td>

                                        @if (Auth::user() != $user)
                                        <td>
                                            <a href="{{ route ('admin_users.destroy', $user->id) }}" onclick="return confirm('Are you sure you wish to delete this user? This cannot be undone!')">Delete User</a>
                                        </td>
                                        @endif
                            </tr>
                        @endforeach
                    </table>
                    @else
                    There are no users awaiting authorization.
                    @endif
                    <br/><br/>
                <a href="{{ route('admin_users.index') }}">Go to the User Management Page</a>
                </div>
            </div>
            @endif
            @if (Auth::user()->authorized && Gate::allows('manage-data'))
            <br/>
            <div class="card">
                <div class="card-header">New Submissions (past 7 days)</div>
                <div class="card-body">
                    @if ($consent_forms)
                    <table style="width:100%;">
                        <tr><th>ID</th><th>Email for map</th><th>Email for gift</th><th>Date</th><th><i class="fas fa-clipboard-list" title="Was questionnaire received?"></i></th><th><i class="fas fa-microphone" title="Was recording received?"></i></th><th>Actions</th></tr>
                        @foreach ($consent_forms as $consent_form)
                            <tr><td>{{ $consent_form->id }}</td><td>{{ $consent_form->email_for_map }}</td><td>{{ $consent_form->email_for_gift }}</td><td>{{ $consent_form->created_at }}</td><td>{!! $consent_form->has_demographic_questionnaire ? '<i class="far fa-check-square" title="Questionnaire Received"></i>' : '<i class="far fa-square" title="Questionnaire NOT Received"></i>' !!}</td><td>{!! $consent_form->has_recording ? '<i class="far fa-check-square" title="Recording Received"></i>' : '<i class="far fa-square" title="Recording NOT Received"></i> ' !!}</td><td><a href="{{ route ('consent_forms.show', $consent_form->id) }}" class="btn btn-info" title="View submission"><i class="fas fa-eye"></i></a> <a href="{{ route ('consent_forms.destroy-get', $consent_form->id) }}" class="btn btn-info" title="Delete submission" onclick="return confirm('Are you sure you wish to delete this submission? This cannot be undone!')"><i class="fas fa-trash-alt"></i></a></td></tr>
                        @endforeach
                    </table>
                    @else
                    There have been no new submissions in the past week
                    <br/>
                    @endif
                    <br/>
                <a href="{{ route('consent_forms.index') }}">View All Submissions</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
