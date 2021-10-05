@extends('layouts.wizard')

@section('title')
    @lang('messages.RecorderTitle')
@endsection

@section('extra-headers')
    <script src="{{ asset('js/audiodisplay.js') }}"></script>
    <script src="{{ asset('js/recorderjs/recorder.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/web-audio-peak-meter.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/jquery.scrolling-tabs.min.css') }}">
    <script src="{{ asset('js/jquery.scrolling-tabs.min.js') }}"></script>
    <script src="{{ asset('messages.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // $("#activateAudio").modalWizard();
            $('#activateAudio').modal('show');
            $('.nav-tabs').scrollingTabs({
                bootstrapVersion: 4,
                cssClassLeftArrow: 'fa fa-chevron-left',
                cssClassRightArrow: 'fa fa-chevron-right'
            });
        });

        function ShowProgressAnimation(message){
            var progresstext = document.getElementById('progresstext');
            progresstext.innerHTML = message;
            $("#statusWindow").modal('show');
            //$("#my-peak-meter").hide();
        }

        function EndProgressAnimation(){
            $("#statusWindow").modal('hide');
            //$("#my-peak-meter").show();
        }
    </script>
    <style>
        canvas {
            display: inline-block;
            background: #202020;
            width: 90%;
            height: 55px;
        {{-- box-shadow: 0px 0px 10px blue; --}}
}

        #progresstext {
            padding: 10px 0px;
            text-align: center;
            margins: auto;
        }

        #progressimg {
            height:32px;
            width:32px;
            margin:30px;
        }
        @media (orientation: portrait) {
            .limitsize { max-height: 40vh;
                overflow-y:auto; }
        }



    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

@endsection


@section('content')
    <div id="activateAudio" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"><div id="wizard-title">@lang('messages.RecorderActivateAudioTitle')</div></h5>
                </div>
                <div class="modal-body">
                    <div id="first-step">
                        <p>@lang('messages.RecorderActivateAudioPrompt')</p>
                    </div>
                </div>
                <div id="wizard-footer" class="modal-footer">
                    <p id="activate-audio" class="text-center"><button type="button" class="btn btn-primary" onclick="initAudio('{{$locale}}');">@lang('messages.RecorderActivateAudioButton')</button></p>
                </div>
            </div>
        </div>
    </div>
    <div id="statusWindow" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><div id="wizard-title">@lang('messages.RecorderStatusDialogTitle')</div></h5>
                </div>
                <div class="modal-body text-center">
                    <div id="progressimage"><img id="progressimg" src="/images/please_wait.gif" alt="Loading.." /><br /></div>
                    <div id="progresstext">@lang('messages.RecorderEncoding')</div>
                </div>
                <div id="status-footer" class="modal-footer invisible">
                    <button type="button" class="btn btn-info" data-dismiss="modal" onclick="$('#status-footer').addClass('invisible');">@lang('messages.OK')</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#instructions">@lang('messages.RecorderInstructionsTitle')</a>
                            </li>
                            @if(config('app.wlar_test_recording_enabled'))
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#test">@lang('messages.RecorderTestTitle')</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#read">@lang('messages.RecorderReadingTitle')</a>
                            </li>
                            @if(config('app.wlar_additional_reading_enabled'))
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#additional">@lang('messages.RecorderAdditionalReadingTitle')</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="card-body limitsize">
                        <div class="tab-content mt-3">
                            <div class="tab-pane active" id="instructions">
                                <p class="card-text">
                                    @include('includes.'.$locale.".recorder_instructions")
                                </p>
                            </div>
                            @if(config('app.wlar_test_recording_enabled'))
                                <div class="tab-pane" id="test">
                                    <p class="card-text">
                                        @include('includes.'.$locale.".recorder_test")
                                    </p>
                                </div>
                            @endif
                            <div class="tab-pane" id="read">
                                <p class="card-text">
                                    @include('includes.'.$locale.".reading_passage")
                                </p>
                            </div>
                            @if(config('app.wlar_additional_reading_enabled'))
                                <div class="tab-pane" id="additional">
                                    <p class="card-text">
                                        @include('includes.'.$locale.".additional_reading_passage")
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 text-center">
                <div class="card">
                    <div class="card-header">
                        @lang('messages.RecorderToolTitle')
                    </div>
                    <div class="card-body">
                        <div class="text-center">@lang('messages.RecorderInputLevelLabel')</div>
                        <div id="my-peak-meter" style="width: 90%; height: 50px; display: inline-block; background: #202020;"></div>
                        {{-- <canvas id="analyser" width="1000" height="150"></canvas> --}}
                        <button id="recordButton" class="btn btn-secondary">
                            {{-- <img id="record" src="{{ asset('images/mic128.png') }}" width="75" height="75"> --}}
                            <i class="fas fa-microphone"></i>
                            <span id="rectext">@lang('messages.RecorderRec')</span>
                        </button>
                        <h4 id="rectime"><time>00:00:00</time></h4>
                        <div class="text-center">@lang('messages.RecorderPlaybackSubmitLabel')</div>
                        <canvas id="wavedisplay" width="1000" height="150"></canvas>
                        <div id="audioplayer"></div>
                        <button id="save" type="button" class="btn btn-primary" onclick="startSubmit(this);" disabled>
                            {{-- <img src="{{ asset('images/save.svg') }}" width="75" height="75"> --}}
                            <i class="fas fa-upload"></i> @lang('messages.RecorderSave')
                        </button>
                        <div id="recwarning">
                            <div style="color: red;">@lang('messages.RecorderNotYet')</div>
                        </div>
                    </div>
                </div>
            </div>
            @endsection

            @section('after-body')
                <script>
                    const user_id = "{{ Session::get('user_id') }}";
                    const h1 = document.getElementById('rectime');
                    const start = document.getElementById('recordButton');
                    var recording_in_progress;
                    var seconds = 0;
                    var minutes = 0;
                    var hours = 0;
                    var t;

                    function add() {
                        seconds++;
                        if (seconds >= 60) {
                            seconds = 0;
                            minutes++;
                            if (minutes >= 60) {
                                minutes = 0;
                                hours++;
                            }
                        }

                        h1.textContent = (hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds);
                        timer();
                    }

                    function timer() {
                        t = setTimeout(add, 1000);
                    }

                    timer();

                    window.onload=function() {
                        clearTimeout(t);
                        h1.textContent = "00:00:00";
                        seconds = 0;
                        minutes = 0;
                        hours = 0;
                        recording_in_progress = false;
                    }

                    start.onclick = function() {
                        toggleRecording(document.getElementById('recordButton'));

                        if (recording_in_progress) {
                            clearTimeout(t);
                            h1.textContent = '00:00:00';
                            seconds = 0;
                            minutes = 0;
                            hours = 0;
                            recording_in_progress = false;
                        } else {
                            timer();
                            recording_in_progress = true;
                        }
                    }
                </script>
@endsection
