@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @foreach ($states as $state)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="visible-xs visible-sm">
                            <div class="circle pull-left" style="background-color: {{ $statesData[$state->state]['color'] }}; border: 2px solid {{ $statesData[$state->state]['textColor'] }};">
                                    {{ substr(__('messages.'.$state->state), 0, 1) }}
                            </div>
                            <div class="label labeled pull-left" style="background-color: {{ $statesData[$state->state]['color'] }}; color: {{ $statesData[$state->state]['textColor'] }};  border-bottom: 2px solid {{ $statesData[$state->state]['textColor'] }}; border-right: 2px solid {{ $statesData[$state->state]['textColor'] }}; border-top: 2px solid {{ $statesData[$state->state]['textColor'] }};">
                                    {{ substr(__('messages.'.$state->state), 1) }}
                            </div>
                            <a class="edit pull-right waves-circle" style="color: {{ $statesData[$state->state]['textColor'] }};" href="{{ action('HomeController@show', ['diary' => $state->id]) }}">
                                    <i class="glyphicon glyphicon-pencil"></i>
                            </a>
                        </div>
                        <div class="visible-md visible-lg">
                            <div class="col-xs-12 col-sm-3">
                                <div class="circle pull-left" style="background-color: {{ $statesData[$state->state]['color'] }}; border: 2px solid {{ $statesData[$state->state]['textColor'] }};">
                                    {{ substr(__('messages.'.$state->state), 0, 1) }}
                                </div>
                                <div class="label labeled pull-left" style="background-color: {{ $statesData[$state->state]['color'] }}; color: {{ $statesData[$state->state]['textColor'] }};  border-bottom: 2px solid {{ $statesData[$state->state]['textColor'] }}; border-right: 2px solid {{ $statesData[$state->state]['textColor'] }}; border-top: 2px solid {{ $statesData[$state->state]['textColor'] }};">
                                    {{ substr(__('messages.'.$state->state), 1) }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-7">
                                <small>
                                    <span class="ago" style="color: {{ $statesData[$state->state]['textColor'] }};">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                        @php
                                         $created_at = $time->getNeededDateDependingOnTimezone($state->timezone, $state->created_at, "Y-m-d H:i:s");
                                        @endphp
                                        {{ $carbon->parse($created_at)->format('l j \\of F Y \\a\\t H:i A') }}<span class="greyed">,
                                            {{ $carbon->parse($created_at)->diffForHumans() }}
                                        </span>
                                    </span>
                                </small>
                            </div>
                            <div class="col-xs-12 col-sm-2">
                                <a class="edit pull-right waves-circle" style="color: {{ $statesData[$state->state]['textColor'] }};" href="{{ action('HomeController@show', ['diary' => $state->id]) }}">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    @if ($state->emotion)
                        <div class="panel-body">
                            {!!  nl2br(e($state->emotion)) !!}
                        </div>
                    @endif
                </div>
            @endforeach
            <div class="text-center">
                {{ $states->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
