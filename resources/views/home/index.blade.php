@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="container-mood" v-diary-day>
                <h2>Today's day:</h2>
                <ul>
                    @foreach ($states as $state)
                        <li>
                            <input type="radio" id="{{$state}}" name="selector">
                            <label for="{{$state}}">{{ __("messages.".$state) }}</label>

                            <div class="check"></div>
                        </li>
                    @endforeach
                </ul>
                {{ Form::textarea('emotion', null, ['class' => 'form-control', 'id' => 'emotion', 'placeholder' => 'Day events that causes the value']) }}
                <hr>
                <div class="calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection
