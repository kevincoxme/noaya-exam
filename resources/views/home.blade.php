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
                    <div class="text-center">
                        <img src="/storage/{{ Auth::user()->company->logo }}" alt="" height="80"><br>
                        <strong>{{ Auth::user()->company->name }} </strong>
                        <form method="post" action="{{ route('home_update_logo') }}" enctype="multipart/form-data" style="margin-top: 20px;">
                            @csrf
                            <label>
                                Upload Logo
                                <input type="file" name="logo">
                            </label><br>
                            <button type="subbmit" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
