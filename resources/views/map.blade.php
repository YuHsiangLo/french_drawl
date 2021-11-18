@extends('layouts.wizard')

@section('title')
    @lang('messages.MapTitle')
@endsection

@section('extra-headers')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://d3js.org/topojson.v3.min.js"></script>
    <script src="https://d3js.org/d3.v5.min.js"></script>
@endsection

@section('content')
    <span>
        <label for="year-slider">Year</label>
        <input type="range" id="year-slider" name="year-slider" value="1952" min="1991" max="2019" step="1">
        <label id="year-selection">1991</label>
    </span>

    <span>
        <button id="play-button" style="background-color: green">Play</button>
    </span>

    <div>
        <svg id="map"></svg>
    </div>

    @section('after-body')
        <script src="{{ asset('js/choroplethMap.js') }}"></script>
        <script src="{{ asset('js/mapControl.js') }}"></script>
    @endsection
@endsection
