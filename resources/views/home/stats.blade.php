@extends('layouts.app')

@section('content')
    <div class="content">
        @foreach ($stats as $state)
            <div class="title m-b-md">
                (<span class="{{$state->state}}">{{ $state->count }}</span>) {{ ucwords($numberFormatter->format($state->count)) }} - {{ __('messages.'.$state->state) }}
            </div>
        @endforeach
    </div>
@endsection