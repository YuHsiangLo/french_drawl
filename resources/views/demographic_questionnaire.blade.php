@extends('layouts.wizard')

@section('title')
    @lang('messages.DemoTitle')
@endsection

@section('content')
    <form class="w-75 mx-auto" action="{{ route('demographic_questionnaires.store') }}" method="post">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="age"><strong>1.</strong> Quel âge avez-vous ?*</label>
                <input name="Age" id="age" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
            </div>
            <div class="form-group col-md-6">
                <label for="gender"><strong>2.</strong> À quel genre vous identifiez-vous ?*</label>
                <div class="form-check">
                    <input name="Gender" type="radio" class="form-check-input" value="male" id="choice_female" required><label class="form-check-label" for="choice_female" id="label_female">femme</label>
                </div>
                <div class="form-check">
                    <input name="Gender" type="radio" class="form-check-input" value="male" id="choice_male" required><label class="form-check-label" for="choice_male" id="label_male">homme</label>
                </div>
                <div class="form-check">
                    <input name="Gender" type="radio" class="form-check-input" value="other" id="choice_other" required><label class="form-check-label" for="choice_other" id="label_other">préfère me définir moi-même : </label><input type="text" name="Gender other">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="city_loc"><strong>3a.</strong> Dans quelle ville ou village avez-vous grandi ? (Plus d'une réponse possible.)*</label>
                <input class="form-control" name="Grown-up city" type="text" id="city_loc" aria-required="true" aria-invalid="false" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="city_year"><strong>3b.</strong> Vous êtes resté(e) à chaque endroit pendant combien d'années ?*</label>
                <input class="form-control" name="Years in grown-up city" type="text" id="city_year" aria-required="true" aria-invalid="false" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="current_loc"><strong>4a.</strong> Où habitez-vous présentement ?*</label>
                <input class="form-control" name="Current location" type="text" id="current_loc" aria-required="true" aria-invalid="false" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="current_year"><strong>4b.</strong> Depuis combien d'années habitez-vous à cet endroit ?*</label>
                <input class="form-control" name="Years in current location" type="text" id="current_year" aria-required="true" aria-invalid="false" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="lang"><strong>5.</strong> Quelle(s) langue(s) parlez-vous couramment ?*</label>
                <input class="form-control" name="Other languages" type="text" id="lang" aria-required="true" aria-invalid="false" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="accent"><strong>6.</strong> Quel accent considérez-vous avoir ? (Par exemple : franco-manitobain, gaspésien, montréalais, acadien, franco-ontarien, etc.)*</label>
                <input class="form-control" name="Accent" type="text" id="accent" aria-required="true" aria-invalid="false" required>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">@lang('messages.Next')</button>
            <br/>
            <br/>
            <br/>
        </div>
    </form>
@endsection
