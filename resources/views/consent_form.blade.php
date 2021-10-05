@extends('layouts.wizard')

@section('title')
    @lang('messages.ConsentTitle')
@endsection

@section('content')
    <div class="card w-75 mx-auto">
        <div class="card-body p-3" style="font-size: 12pt; overflow-y: auto; max-height: 275px">
            @include('includes.'.$locale.".consent_text")
        </div>
    </div>
    <br />
    <form action="{{ route('consent_forms.store') }}" method="post">
        @csrf
        <div class="container w-75 px-2">
            <div class="row">
                <div class="{{ config('app.wlar_request_consent_publication') ? 'col-md-6 col-sm-12' : 'col' }}">
                    <h4>@lang('messages.ConsentParticipation')</h4>
                    <p>@include('includes.'.$locale.".consent_participation_text")</p>

                    <div class="input-group mb-3 w-75 mx-auto">
                        <label for="email_map">@lang('messages.EmailForMap')</label>
                        <input type="email" id="email_map" name="email_map" class="form-control">
                    </div>

                    <div class="input-group mb-3 w-75 mx-auto">
                        <label for="email_gift">@lang('messages.EmailForGift')</label>
                        <input type="email" id="email_gift" name="email_gift" class="form-control">
                    </div>

{{--                    <div class="input-group mb-3 w-75 mx-auto">--}}
{{--                        <div class="input-group-prepend">--}}
{{--                            <span class="input-group-text">@lang('messages.ConsentName')</span>--}}
{{--                        </div>--}}
{{--                        <input type="text" id="name" name="user_name" class="form-control">--}}
{{--                    </div>--}}
{{--                    <div class="input-group mb-3 w-75 mx-auto">--}}
{{--                        <div class="input-group-prepend">--}}
{{--                            <span class="input-group-text">@lang('messages.ConsentEmail')</span>--}}
{{--                        </div>--}}
{{--                        <input type="email" id="email" name="user_email" class="form-control" {{ config('app.wlar_email_required') ? 'required' : 'placeholder=('.Lang::get('messages.Optional').')' }}>--}}
{{--                    </div>--}}
{{--                    <div class="form-check w-75 mx-auto">--}}
{{--                        <input class="form-check-input" id="check_1" type="checkbox" name="consent_box"--}}
{{--                               onchange="document.getElementById('c_button').disabled = !this.checked" required>--}}
{{--                        <label class="form-check-label" for="check_1">@lang('messages.ConsentParticipationConsent')</label>--}}
{{--                        <br/><br/>--}}
{{--                    </div>--}}
                </div>
                @if(config('app.wlar_request_consent_publication'))
                    <div class="col-md-6 col-sm-12">
                        <h4>@lang('messages.ConsentPublication')</h4>
                        <p>@include('includes.'.$locale.".consent_publication_text")</p>
                        <div class="form-check w-75 mx-auto">
                            <input class="form-check-input" id="check_2" type="checkbox" name="share_box">
                            <label class="form-check-label" for="check_2">@lang('messages.ConsentPublicationConsent')</label>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="text-center">
            <br/>
            <button type="submit" id="c_button" class="btn btn-primary">@lang('messages.Submit')</button>
            <br/>
            <br/>
            <br/>
        </div>
    </form>

@endsection
