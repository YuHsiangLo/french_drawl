@extends('layouts.wizard')

@section('title')
    @lang('messages.DemoTitle')
@endsection

@section('content')
    <form class="w-50 mx-auto" action="{{ route('demographic_questionnaires.store') }}" method="post">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Voice Type *</label>
                <div class="form-check">
                    <input name='Gender' type='radio' class="form-check-input" value='Male' id='choice_1_3_0' /><label class="form-check-label" for='choice_1_3_0' id='label_1_3_0'>Male</label>
                </div>
                <div class="form-check">
                    <input name='Gender' type='radio' class="form-check-input" value='Female' id='choice_1_3_1' /><label class="form-check-label" for='choice_1_3_1' id='label_1_3_1'>Female</label>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label>Age *</label>
                <select name='Years' id='input_1_65' class="form-control" aria-required="true" aria-invalid="false">
                    <option value='Select years'>Select years</option>
                    @include('includes.any.questionnaire.years_list')
                </select>
            </div>
        </div>
        <input type="hidden" name="Operating system" value="{{ $useragent->os->family }}">
        <input type="hidden" name="Operating system version" value="{{ $useragent->os->toVersion() }}">
        <input type="hidden" name="Browser" value="{{ $useragent->ua->family }}">
        <input type="hidden" name="Browser version" value="{{ $useragent->ua->toVersion() }}">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Primary language spoken in your childhood home *</label>
                <select name='Primary language childhood home' id='input_1_5' class='form-control' aria-required="true"
                        aria-invalid="false">
                    <option value=''></option>
                    @include('includes.'.$locale.'.questionnaire.language_list')
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for='input_1_6'>Primary language spoken in your childhood community *</label>
                <select name='Primary language childhood community' id='input_1_6' class='form-control'
                        aria-required="true" aria-invalid="false">
                    <option value=''></option>
                    @include('includes.'.$locale.'.questionnaire.language_list')
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for='input_1_10'>Primary language spoken in your adult home *</label>
                <select name='Primary language adult home' id='input_1_10' class='form-control'
                        aria-required="true" aria-invalid="false">
                    <option value=''></option>
                    @include('includes.'.$locale.'.questionnaire.language_list')
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for='input_1_8'>Primary language spoken in your adult community *</label>
                <select name='Primary language adult community' id='input_1_8' class='form-control'
                        aria-required="true" aria-invalid="false">
                    <option value=''></option>
                    @include('includes.'.$locale.'.questionnaire.language_list')
                </select>
            </div>
        </div>
        <div class="form-row">
            <label for='input_1_12'>What languages do you use on a daily or weekly basis?
                Please select at least one *</label>
            <div class="form-group col-sm-6">

                <select name='Daily weekly language 1' id='input_1_12' class='form-control'
                        aria-required="true" aria-invalid="false">
                    <option value='Daily/weekly language 1'>Daily/weekly language 1</option>
                    @include('includes.'.$locale.'.questionnaire.language_list')
                </select>
            </div>
            <div class="form-group col-sm-6">
                <select name='Daily weekly language 2' id='input_1_16' class='form-control'
                        aria-invalid="false">
                    <option value='Daily/weekly language 2'>Daily/weekly language 2</option>
                    @include('includes.'.$locale.'.questionnaire.language_list')
                </select>
            </div>
            <div class="form-group col-sm-6">
                <select name='Daily weekly language 3' id='input_1_47' class='form-control'
                        aria-invalid="false">
                    <option value='Daily/weekly language 3'>Daily/weekly language 3</option>
                    @include('includes.'.$locale.'.questionnaire.language_list')
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for='input_1_68'>Number of years you have lived in British Columbia *</label>
            <select name='Years lived in BC' id='input_1_68' class='form-control' aria-required="true"
                    aria-invalid="false">
                <option value='Select years'>Select years</option>
                @include('includes.any.questionnaire.years_list')
            </select>
        </div>
        <div class="form-row">
            <img src="{{ asset('images/bc-regions.jpg') }}" alt="image description" width="540"
                 height="348">
            <div class="form-group col-md-6">
                <br/>
                <label for='input_1_18'>Current BC geographic location *</label>
                <select name='Current region' id='input_1_18' class='form-control' aria-required="true"
                        aria-invalid="false">
                    <option value=''></option>
                    <option value='Vancouver Island/Coast'>Vancouver Island/Coast</option>
                    <option value='Lower Mainland/Southwest'>Lower Mainland/Southwest</option>
                    <option value='Thompson-Okanagan'>Thompson-Okanagan</option>
                    <option value='Kootenay-Rockies'>Kootenay-Rockies</option>
                    <option value='Cariboo-Chilcotin-Coast'>Cariboo-Chilcotin-Coast</option>
                    <option value='Skeena-North Coast'>Skeena-North Coast</option>
                    <option value='Peace-Northeast'>Peace-Northeast</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for='input_1_20'>In which general geographic location have you lived the
                    longest in B.C. *</label>
                <select name='BC region lived longest' id='input_1_20' class='form-control'
                        aria-required="true" aria-invalid="false">
                    <option value=''></option>
                    <option value='Vancouver Island/Coast'>Vancouver Island/Coast</option>
                    <option value='Lower Mainland/Southwest'>Lower Mainland/Southwest</option>
                    <option value='Thompson-Okanagan'>Thompson-Okanagan</option>
                    <option value='Kootenay-Rockies'>Kootenay-Rockies</option>
                    <option value='Cariboo-Chilcotin-Coast'>Cariboo-Chilcotin-Coast</option>
                    <option value='Skeena-North Coast'>Skeena-North Coast</option>
                    <option value='Peace-Northeast'>Peace-Northeast</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for='input_1_21'>In which B.C. city/town/community have you lived the
                    longest? *</label>
                <input name='Community lived longest'
                       id='input_1_21' type='text' value='' class='form-control' aria-required="true" aria-invalid="false" />
            </div>
            <div class="form-group col-md-6">
                <label for='input_1_66'>How many years in that community? *</label>
                <select name='Years in community' id='input_1_66' class='form-control' aria-required="true"
                        aria-invalid="false">
                    <option value='Select years'>Select years</option>
                    @include('includes.any.questionnaire.years_list')
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for='input_1_59'>If known, in what country was your mother born?</label>
                <select name='Birth country mother' id='input_1_59' class='form-control'
                        aria-invalid="false">
                    <option value='Choose country'>Choose country</option>
                    @include('includes.any.questionnaire.country_list')
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for='input_1_60'>If known, in what country was your father born?</label>
                <select name='Birth country father' id='input_1_60' class='form-control'
                        aria-invalid="false">
                    <option value='Choose country'>Choose country</option>
                    @include('includes.any.questionnaire.country_list')
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for='input_1_25'>If known, in what languages were/are your parents
                    fluent? *</label>
                <select name='Parental language 1' id='input_1_25' class='form-control' aria-required="true"
                        aria-invalid="false">
                    <option value='Parental language 1'>Parental language 1</option>
                    @include('includes.'.$locale.'.questionnaire.language_list')
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for='input_1_26'>&nbsp;</label>
                <select name='Parental language 2' id='input_1_26' class='form-control'
                        aria-invalid="false">
                    <option value='Parental language 2'>Parental language 2</option>
                    @include('includes.'.$locale.'.questionnaire.language_list')
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for='input_1_27'></label>
                <select name='Parental language 3' id='input_1_27' class='form-control'
                        aria-invalid="false">
                    <option value='Parental language 3'>Parental language 3</option>
                    @include('includes.'.$locale.'.questionnaire.language_list')
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for='input_1_28'></label>
                <select name='Parental language 4' id='input_1_28' class='form-control'
                        aria-invalid="false">
                    <option value='Parental language 4'>Parental language 4</option>
                    @include('includes.'.$locale.'.questionnaire.language_list')
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for='input_1_61'>If known, in what country was your maternal grandmother
                    born?</label>
                <select name='Birth country maternal grandmother' id='input_1_61' class='form-control'
                        aria-invalid="false">
                    <option value='Choose country'>Choose country</option>
                    @include('includes.any.questionnaire.country_list')
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for='input_1_62'>If known, in what country was your maternal grandfather
                    born?</label>
                <select name='Birth country maternal grandfather' id='input_1_62' class='form-control'
                        aria-invalid="false">
                    <option value='Choose country'>Choose country</option>
                    @include('includes.any.questionnaire.country_list')
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for='input_1_63'>If known, in what country was your paternal grandmother
                    born?</label>
                <select name='Birth country paternal grandmother' id='input_1_63' class='form-control'
                        aria-invalid="false">
                    <option value='Choose country'>Choose country</option>
                    @include('includes.any.questionnaire.country_list')
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for='input_1_64'>If known, in what country was your paternal grandfather
                    born?</label>
                <select name='Birth country paternal grandfather' id='input_1_64' class='form-control'
                        aria-invalid="false">
                    <option value='Choose country'>Choose country</option>
                    @include('includes.any.questionnaire.country_list')
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for='input_1_33'>If known, in what languages were/are your grandparents
                    fluent?</label>
                <select name='Grandparents language 1' id='input_1_33' class='form-control'
                        aria-invalid="false">
                    <option value='Grandparents&#039; language 1'>Grandparents&#039; language 1</option>
                    @include('includes.'.$locale.'.questionnaire.language_list')
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for='input_1_34'></label>
                <select name='Grandparents language 2' id='input_1_34' class='form-control'
                        aria-invalid="false">
                    <option value='Grandparents&#039; language 2'>Grandparents&#039; language 2</option>
                    @include('includes.'.$locale.'.questionnaire.language_list')
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for='input_1_35'></label>
                <select name='Grandparents language 3' id='input_1_35' class='form-control'
                        aria-invalid="false">
                    <option value='Grandparents&#039; language 3'>Grandparents&#039; language 3</option>
                    @include('includes.'.$locale.'.questionnaire.language_list')
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for='input_1_36'></label>
                <select name='Grandparents language 4' id='input_1_36' class='form-control'
                        aria-invalid="false">
                    <option value='Grandparents&#039; language 4'>Grandparents&#039; language 4</option>
                    @include('includes.'.$locale.'.questionnaire.language_list')
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for='input_1_39'>What other languages have you studied, and how fluent are
                you?</label>
            <select name='Other languages 1' id='input_1_39' class='form-control' aria-invalid="false">
                <option value='Choose language 1'>Choose language 1</option>
                @include('includes.'.$locale.'.questionnaire.language_list')
            </select>
        </div>
        <div class="form-group">
            <label>Reading/Writing</label>
            <div class="form-check">
                <input name='Other languages 1 reading' class="form-check-input" type='radio' value='None'
                       id='choice_1_40_0' /><label class="form-check-label" for='choice_1_40_0' id='label_1_40_0'>None</label>
            </div>
            <div class="form-check">
                <input name='Other languages 1 reading' class="form-check-input" type='radio' value='Basic'
                       id='choice_1_40_1' /><label class="form-check-label" for='choice_1_40_1' id='label_1_40_1'>Basic</label>
            </div>
            <div class="form-check">
                <input name='Other languages 1 reading' class="form-check-input" type='radio' value='Moderate'
                       id='choice_1_40_2' /><label class="form-check-label" for='choice_1_40_2' id='label_1_40_2'>Moderate</label>
            </div>
            <div class="form-check">
                <input name='Other languages 1 reading' class="form-check-input" type='radio' value='Fluent'
                       id='choice_1_40_3' /><label class="form-check-label" for='choice_1_40_3' id='label_1_40_3'>Fluent</label>
            </div>
        </div>
        <div class="form-group">
            <label>Speaking</label>
            <div class="form-check">
                <input name='Other languages 1 speaking' class="form-check-input" type='radio' value='None'
                       id='choice_1_42_0' /><label class="form-check-label" for='choice_1_42_0' id='label_1_42_0'>None</label>
            </div>
            <div class="form-check">
                <input name='Other languages 1 speaking' class="form-check-input" type='radio' value='Basic'
                       id='choice_1_42_1' /><label class="form-check-label" for='choice_1_42_1' id='label_1_42_1'>Basic</label>
            </div>
            <div class="form-check">
                <input name='Other languages 1 speaking' class="form-check-input" type='radio'
                       value='Moderate' id='choice_1_42_2' /><label class="form-check-label" for='choice_1_42_2'
                                                                    id='label_1_42_2'>Moderate</label>
            </div>
            <div class="form-check">
                <input name='Other languages 1 speaking' class="form-check-input" type='radio' value='Fluent'
                       id='choice_1_42_3' /><label class="form-check-label" for='choice_1_42_3' id='label_1_42_3'>Fluent</label>
            </div>
        </div>
        <div class="form-group">
            <label>Listening</label>
            <div class="form-check">
                <input name='Other languages 1 listening' class="form-check-input" type='radio' value='None'
                       id='choice_1_41_0' /><label class="form-check-label" for='choice_1_41_0' id='label_1_41_0'>None</label>
            </div>
            <div class="form-check">
                <input name='Other languages 1 listening' class="form-check-input" type='radio' value='Basic'
                       id='choice_1_41_1' /><label class="form-check-label" for='choice_1_41_1' id='label_1_41_1'>Basic</label>
            </div>
            <div class="form-check">
                <input name='Other languages 1 listening' class="form-check-input" type='radio'
                       value='Moderate' id='choice_1_41_2' /><label for='choice_1_41_2' class="form-check-label"
                                                                    id='label_1_41_2'>Moderate</label>
            </div>
            <div class="form-check">
                <input name='Other languages 1 listening' class="form-check-input" type='radio' value='Fluent'
                       id='choice_1_41_3' /><label class="form-check-label" for='choice_1_41_3' id='label_1_41_3'>Fluent</label>
            </div>
        </div>
        <div class="form-group">
            <label for='input_1_43'>Other languages studied?</label>
            <select name='Other languages 2' id='input_1_43' class='form-control' aria-invalid="false">
                <option value='Choose Language 2'>Choose Language 2</option>
                @include('includes.'.$locale.'.questionnaire.language_list')
            </select>
        </div>
        <div class="form-group">
            <label>Reading/Writing</label>
            <div class="form-check">
                <input name='Other languages 2 reading' class="form-check-input" type='radio' value='None'
                       id='choice_1_44_0' /><label class="form-check-label" for='choice_1_44_0' id='label_1_44_0'>None</label>
            </div>
            <div class="form-check">
                <input name='Other languages 2 reading' class="form-check-input" type='radio' value='Basic'
                       id='choice_1_44_1' /><label class="form-check-label" for='choice_1_44_1' id='label_1_44_1'>Basic</label>
            </div>
            <div class="form-check">
                <input name='Other languages 2 reading' class="form-check-input" type='radio' value='Moderate'
                       id='choice_1_44_2' /><label class="form-check-label" for='choice_1_44_2' id='label_1_44_2'>Moderate</label>
            </div>
            <div class="form-check">
                <input name='Other languages 2 reading' class="form-check-input" type='radio' value='Fluent'
                       id='choice_1_44_3' /><label class="form-check-label" for='choice_1_44_3' id='label_1_44_3'>Fluent</label>
            </div>
        </div>
        <div class="form-group">
            <label>Speaking</label>
            <div class="form-check">
                <input name='Other languages 2 speaking' class="form-check-input" type='radio' value='None'
                       id='choice_1_45_0' /><label class="form-check-label" for='choice_1_45_0' id='label_1_45_0'>None</label>
            </div>
            <div class="form-check">
                <input name='Other languages 2 speaking' class="form-check-input" type='radio' value='Basic'
                       id='choice_1_45_1' /><label class="form-check-label" for='choice_1_45_1' id='label_1_45_1'>Basic</label>
            </div>
            <div class="form-check">
                <input name='Other languages 2 speaking' class="form-check-input" type='radio'
                       value='Moderate' id='choice_1_45_2' /><label class="form-check-label" for='choice_1_45_2'
                                                                    id='label_1_45_2'>Moderate</label>
            </div>
            <div class="form-check">
                <input name='Other languages 2 speaking' class="form-check-input" type='radio' value='Fluent'
                       id='choice_1_45_3' /><label class="form-check-label" for='choice_1_45_3' id='label_1_45_3'>Fluent</label>
            </div>
        </div>
        <div class="form-group">
            <label>Listening</label>
            <div class="form-check">
                <input name='Other languages 2 listening' class="form-check-input" type='radio' value='None'
                       id='choice_1_46_0' /><label class="form-check-label" for='choice_1_46_0' id='label_1_46_0'>None</label>
            </div>
            <div class="form-check">
                <input name='Other languages 2 listening' class="form-check-input" type='radio' value='Basic'
                       id='choice_1_46_1' /><label class="form-check-label" for='choice_1_46_1' id='label_1_46_1'>Basic</label>
            </div>
            <div class="form-check">
                <input name='Other languages 2 listening' class="form-check-input" type='radio'
                       value='Moderate' id='choice_1_46_2' /><label class="form-check-label" for='choice_1_46_2'
                                                                    id='label_1_46_2'>Moderate</label>
            </div>
            <div class="form-check">
                <input name='Other languages 2 listening' class="form-check-input" type='radio' value='Fluent'
                       id='choice_1_46_3' /><label class="form-check-label" for='choice_1_46_3' id='label_1_46_3'>Fluent</label>
            </div>
        </div>
        <div class="form-group">
            <label>Are you active as a singer such as in a choir, band, or soloist? *</label>
            <div class="form-check">
                <input name='Active singer' class="form-check-input" type='radio' value='Yes'
                       id='choice_1_48_0' /><label class="form-check-label"for='choice_1_48_0' id='label_1_48_0'>Yes</label>
            </div>
            <div class="form-check">
                <input name='Active singer' class="form-check-input" type='radio' value='No'
                       id='choice_1_48_1' /><label class="form-check-label"for='choice_1_48_1' id='label_1_48_1'>No</label>
            </div>
        </div>
        <div class="form-group">
            <label>What singing instruction have you received?</label>
            <div class="form-check">
                <input name='Singing school choir' class="form-check-input" type='checkbox' value='School Choir'
                       id='choice_1_49_1' />
                <label class="form-check-label" for='choice_1_49_1' id='label_1_49_1'>School Choir</label>
            </div>
            <div class="form-check">
                <input name='Singing community church choir' class="form-check-input" type='checkbox' value='Community/Church choir'
                       id='choice_1_49_2' />
                <label class="form-check-label" for='choice_1_49_2' id='label_1_49_2'>Community/Church choir</label>
            </div>
            <div class="form-check">
                <input name='Singing college university choir' class="form-check-input" type='checkbox'
                       value='College/University choir' id='choice_1_49_3' />
                <label class="form-check-label" for='choice_1_49_3' id='label_1_49_3'>College/University choir</label>
            </div>
            <div class="form-check">
                <input name='Singing private training' class="form-check-input" type='checkbox' value='Private vocal training'
                       id='choice_1_49_4' />
                <label class="form-check-label" for='choice_1_49_4' id='label_1_49_4'>Private vocal training</label>
            </div>
            <div class="form-check">
                <input name='Singing professional training' class="form-check-input" type='checkbox'
                       value='Professional vocal training' id='choice_1_49_5' />
                <label class="form-check-label" for='choice_1_49_5' id='label_1_49_5'>Professional vocal training</label>
            </div>
            <div class="form-check">
                <input name='Singing other instruction' class="form-check-input" type='checkbox' value='Other' id='choice_1_49_6' />
                <label class="form-check-label" for='choice_1_49_6' id='label_1_49_6'>Other</label>
            </div>
        </div>
        <div class="form-group">
            <label for='input_1_67'>Years of singing instruction</label>
            <select name='Singing years of instruction'
                    id='input_1_67' class='form-control' aria-invalid="false">
                <option value='Select years'>Select years</option>
                @include('includes.any.questionnaire.years_list')
            </select>
        </div>
        {{--
        <div class="form-row">
           <div class="form-group col-md-6">
              <label for='input_1_52_1' id='input_1_52_1_label'>Street Address</label>
              <input class='form-control' type='text' name='Address Line 1' id='input_1_52_1' value='' />
           </div>
           <div class="form-group col-md-6">
              <label for='input_1_52_2' id='input_1_52_2_label'>Address Line 2</label>
              <input class='form-control' type='text' name='Address Line 2' id='input_1_52_2' value='' />
           </div>
        </div>
        <div class="form-row">
           <div class="form-group col-md-6">
              <label for='input_1_52_3' id='input_1_52_3_label'>City</label>
              <input class='form-control' type='text' name='Address city' id='input_1_52_3' value='' />
           </div>
           <div class="form-group col-md-6">
              <label for='input_1_52_4' id='Address province'>State / Province / Region</label>
              <input class='form-control' type='text' name='Address province' id='input_1_52_4' value='' />
           </div>
        </div>
        <div class="form-row">
           <div class="form-group col-md-6">
              <label for='input_1_52_5' id='Address postal'>ZIP / Postal Code</label>
              <input class='form-control' type='text' name='Address postal' id='input_1_52_5' value='' />
           </div>
           <div class="form-group col-md-6">
              <label for='input_1_52_6' id='input_1_52_6_label'>Country</label>
                 <select class='form-control' name='Address country' id='input_1_52_6'>
                    <option value='' selected='selected'></option>
                    @include('includes.any.questionnaire.country_list')
                 </select>
           </div>
        </div>
        --}}
        <div class="text-center">
            <button type="submit" class="btn btn-primary">@lang('messages.Next')</button><br/><br/><br/>
        </div>
    </form>
@endsection
