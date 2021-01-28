@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="visible-xs visible-sm visible-md">
                            <div class="circle pull-left" style="background-color: {{ $statesData[$diary->state]['color'] }}; border: 2px solid {{ $statesData[$diary->state]['textColor'] }};">
                                {{ substr(__('messages.'.$diary->state), 0, 1) }}
                            </div>
                            <div class="label labeled pull-left" style="background-color: {{ $statesData[$diary->state]['color'] }}; color: {{ $statesData[$diary->state]['textColor'] }};  border-bottom: 2px solid {{ $statesData[$diary->state]['textColor'] }}; border-right: 2px solid {{ $statesData[$diary->state]['textColor'] }}; border-top: 2px solid {{ $statesData[$diary->state]['textColor'] }};">
                                {{ substr(__('messages.'.$diary->state), 1) }}
                            </div>
                            <button class="btn pull-right waves-button" style="background-color: {{ $statesData[$diary->state]['color'] }}; color: {{ $statesData[$diary->state]['textColor'] }};" @click="submitStateUpdate()">
                                <i class=" glyphicon glyphicon-floppy-saved"></i>
                            </button>
                            <a class="pull-right margin-right-10px waves-button" href="{{ action('HomeController@flow') }}">
                                <i class="glyphicon glyphicon-home"></i>
                            </a>
                        </div>
                        <div class="visible-lg">
                            <div class="circle pull-left" style="background-color: {{ $statesData[$diary->state]['color'] }}; border: 2px solid {{ $statesData[$diary->state]['textColor'] }};">
                                {{ substr(__('messages.'.$diary->state), 0, 1) }}
                            </div>
                            <div class="label labeled pull-left" style="background-color: {{ $statesData[$diary->state]['color'] }}; color: {{ $statesData[$diary->state]['textColor'] }};  border-bottom: 2px solid {{ $statesData[$diary->state]['textColor'] }}; border-right: 2px solid {{ $statesData[$diary->state]['textColor'] }}; border-top: 2px solid {{ $statesData[$diary->state]['textColor'] }};">
                                {{ substr(__('messages.'.$diary->state), 1) }}
                            </div>
                            <small>
                                <span class="ago" style="color: {{ $statesData[$diary->state]['textColor'] }};">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                    @php
                                        $created_at = $time->getNeededDateDependingOnTimezone($diary->timezone, $diary->created_at, "Y-m-d H:i:s");
                                    @endphp
                                    {{ $carbon->parse($created_at)->format('l j \\of F Y \\a\\t H:i A') }}<span class="greyed">,
                                        {{ $carbon->parse($created_at)->diffForHumans() }}
                                    </span>
                                </span>
                            </small>
                            <button class="btn pull-right waves-button" style="background-color: {{ $statesData[$diary->state]['color'] }}; color: {{ $statesData[$diary->state]['textColor'] }};" @click="submitStateUpdate()">
                                <i class=" glyphicon glyphicon-floppy-saved"></i>
                            </button>
                            <a class="pull-right margin-right-10px waves-button" href="{{ action('HomeController@flow') }}">
                                <i class="glyphicon glyphicon-home"></i>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger margin-10px margin-top-0px">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        {{ Form::model($diary, ['route' => [ 'state.update', $diary->id], 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form', 'id' => 'state.update']) }}

                        {{ method_field('PUT') }}

                        <div class="{{ $errors->has('emotion') ? ' has-error' : '' }}">
                            {{ Form::textarea('emotion', $diary->emotion, ['class' => 'form-control '.$diary->state, 'autocomplete' => 'off', 'autofocus', 'placeholder' => 'Day events that causes the value']) }}

                            @if ($errors->has('emotion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('emotion') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
