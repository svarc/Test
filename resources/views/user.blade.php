@extends('layouts.app')

@section('title')
<title>{{ config('app.name', 'Laravel') }} | User - {{ $user[0]->name }}</title>
@endsection

@section('head-css')
<link href="{{ asset('/css/dropzone.css') }}" rel="stylesheet">
<link href="{{ asset('/css/Chart.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col text-center content">
                <h1 class="text-center">{{ $user[0]->name }}</h1>
                <div class="row">
                    <div class="col">
                        <h3>Average user score</h3>
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <select name="filter" id="filter">
                                          <option value="week" selected>Past Week</option>
                                          <option value="month">Past Month</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div id="chartContainer" style="height: 100%; width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <h3>Last calls</h3>
                        <div class="row">
                            <div class="col">
                                <table class="table table-hover table-bordered">
                                  <thead>
                                    <tr>
                                      <th scope="col">Name</th>
                                      <th scope="col">Type</th>
                                      <th scope="col">Date</th>
                                      <th scope="col">Duration</th>
                                      <th scope="col">Type</th>
                                      <th scope="col">Score</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @for ($i = 0; $i < 5; $i++)
                                    <tr">
                                      <th>{{ $user[0]['calls'][$i]['client_name'] }}</th>
                                      <td>{{ $user[0]['calls'][$i]['client_type'] }}</td>
                                      <td>{{ $user[0]['calls'][$i]['date'] }}</td>
                                      <td>{{ Carbon\CarbonInterval::seconds($user[0]['calls'][$i]['duration'])->cascade()->forHumans() }}</td>
                                      <td>{{ $user[0]['calls'][$i]['call_type'] }}</td>
                                      <td>{{ $user[0]['calls'][$i]['call_score'] }}</td>
                                    </tr>
                                    @endfor
                                  </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    var weekly_durations = [<?php foreach ($weekly_durations as $key => $value) {
            echo '{ x: new Date(' . date('Y',strtotime($key)) . ', ' . date('m',strtotime($key)) . ', ' . date('d',strtotime($key)) . '),  y: ' . $weekly_durations[$key][$key] . '},';
        }?>];
    var weekly_scores = [<?php foreach ($weekly_scores as $key => $value) {
            echo '{ x: new Date(' . date('Y',strtotime($key)) . ', ' . date('m',strtotime($key)) . ', ' . date('d',strtotime($key)) . '),  y: ' . $weekly_scores[$key][$key] . '},';
        }?>];
    var monthly_durations = [<?php foreach ($monthly_durations as $key => $value) {
            echo '{ x: new Date(' . date('Y',strtotime($key)) . ', ' . date('m',strtotime($key)) . ', ' . date('d',strtotime($key)) . '),  y: ' . $monthly_durations[$key][$key] . '},';
        }?>];
    var monthly_scores = [<?php foreach ($monthly_scores as $key => $value) {
            echo '{ x: new Date(' . date('Y',strtotime($key)) . ', ' . date('m',strtotime($key)) . ', ' . date('d',strtotime($key)) . '),  y: ' . $monthly_scores[$key][$key] . '},';
        }?>];
</script>
<script src="{{ asset('/js/jquery.canvasjs.min.js') }}"></script>
<script src="{{ asset('/js/scripts.js') }}"></script>
@endpush
