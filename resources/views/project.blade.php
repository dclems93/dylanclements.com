@extends('layouts.master')

@section('content')
    @include('include.message-block')

    <div class="jumbo one-hundo" id="project">
        @if(!$project->primarypic==null)
            <img src="https://s3.us-east-2.amazonaws.com/dclems-blog-assets{{ $project->primarypic->url }}" style="width:100%;">
        @else
            <img src="/assets/tapes.png" style="width: 70%; display:inline-block; float:right;">
        @endif
    </div>
    <img class="torn-top" src="/assets/torn_top_long.png">
    <div class="one-hundo">
        <div class="project-description">
            <h3>{!! $project->title !!}</h3>
            <p>{!! $project->description !!}</p>
        </div>
        @foreach($project->sections as $section)
            <div class="project-section">
                <div class="project-title">
                    <h3>{!! $section->title !!}</h3>
                    <p style="color:gray;">{{ $project->user->first_name }} {{ $project->user->last_name }} | {{ $project->created_at->diffForHumans()}}</p>
                </div>
                <p>{!! $section->content !!}</p>
            </div>
        @endforeach

    </div>
    @include('include.new-project-modal')
    @include('include.footer')
@endsection