@extends('layouts.master')

@section('content')
    @include('include.message-block')

    <div class="jumbo one-hundo" id="projects">
        <img src="/assets/tapes.png">
    </div><!-- / blog jumbo -->
    <img class="torn-top" src="/assets/torn_top_long.png">
    <div class="row one-hundo">
        <h1 style="margin-left:3%;">My Projects:</h1>
        @foreach($projects as $project)
            <a href="{{ route('get.project', ['project_id' => $project->id]) }}" class="project-link">
            <div class="project-sum">
            @if(!$project->primarypic==null)
                <div class="project-sum-image">
                    <img src="https://s3.us-east-2.amazonaws.com/dclems-blog-assets{{ $project->primarypic->url }}">
                </div>
            @endif
                <div class="project-content">
                    <h3>{!! $project->title !!}</h3>
                    <p>{!! $project->description !!}</p>
                </div>
            </div>
            </a>
        @endforeach
    </div>
    @include('include.new-project-modal')
    @include('include.footer')
@endsection