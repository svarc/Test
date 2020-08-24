@extends('layouts.app')

@section('title')
<title>{{ config('app.name', 'Laravel') }} | Homepage</title>
@endsection

@section('head-css')
<link href="{{ asset('/css/dropzone.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-5 mx-auto dropzone-container">
                <form id="dropzone" enctype="multipart/form-data">
                    <div class="text-description">Drop your CSV file here or click to select a CSV file.</div>
                    <div class="fallback"><input name="file" type="file" multiple /></div>
                </form>
            </div>
        </div>
    </div>
    <div id="modal-error" class="modal" tabindex="-1" role="dialog" >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Error</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>There was an error. Please try again.</p>
          </div>
        </div>
      </div>
    </div>
    <div id="modal-success" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Success</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Your data was imported in the database.</p>
          </div>
        </div>
      </div>
    </div>
    <div id="modal-progress" class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content align-items-center">
          <div class="modal-header">
            <h5 class="modal-title">Processing</h5>
          </div>
          <div class="modal-body">
            <img src="{{ asset('/images/loader.svg') }}">
          </div>
        </div>
      </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('/js/dropzone.js') }}"></script>
<script src="{{ asset('/js/scripts.js') }}"></script>
@endpush
