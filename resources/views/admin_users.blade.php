@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('User Management') }}</div>

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

                    {{ Auth::user()->authorized ? '' : 'You are not authorized to access data - another administrator must authorize you!' }}

                    @if (Auth::user()->authorized && Gate::allows('manage-users'))
                    <table style="width:100%;"><tr><th>ID</th><th>Name</th><th>Email</th><th colspan=2>Status / Actions</th></tr>
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
                    @endif

                    <br/>
                    <a href="{{ route('admin') }}">Go Back to the Admin Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
