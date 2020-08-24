@extends('layouts.app')

@section('title')
<title>{{ config('app.name', 'Laravel') }} | Users</title>
@endsection

@section('head-css')
<link href="{{ asset('/css/dropzone.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if(count($users))
    <div class="container h-100">
        <div class="row h-100 align-items-center content-container">
            <div class="col content">
                <h1 class="text-center">Users</h1>
                <table class="table table-hover mt-30">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">User</th>
                      <th scope="col">Added At</th>
                      <th scope="col">Number Of Calls</th>
                      <th scope="col">Toral Call Duration</th>
                      <th scope="col">Average Call Score</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                    <tr class="clickable-row" data-href="/user/{{ $user->id }}">
                      <th scope="row">{{ $user->id }}</th>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->created_at->diffForHumans() }}</td>
                      <td>{{ $user->calls->count() }}</td>
                      <td>{{ Carbon\CarbonInterval::seconds($user->calls->sum('duration'))->cascade()->forHumans() }}</td>
                      <td>{{ round($user->calls->avg('call_score')) }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-5 mx-auto dropzone-container">
                <div id="no-users">
                    <div class="text-description-users">There are no users in our database. Please <a href="/">click here</a> and upload a CSV file with users data first.</div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
<script src="{{ asset('/js/scripts.js') }}"></script>
@endpush
