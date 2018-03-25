@extends('layouts.master')

@section('content')
    @include('include.message-block')

    <div class="jumbo one-hundo" id="blog">
        <img src="/assets/tapes.png" style="width: 70%; display:inline-block; float:right;">
    </div><!-- / blog jumbo -->
    <img class="torn-top" src="/assets/torn_top_long.png">
    <div class="row one-hundo blog-title-section">
        <div class="thirty-three">
            <p> </p>
        </div>
        <div class="sixty-six">
            <h3>Dylan Blogs.</h3>
        </div>
    </div>
    <div class="row one-hundo">
        <div class="thirty-three">
            @include('snippets.starred-posts')
            <div class="one-hundo">
                <h4 style="padding-left:20%;">Tags:</h4>
                <div class="tags">
                    @foreach($tags as $tag)
                        <h5>{{ $tag->text }}</h5>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="sixty-six post-section">
            @include('sections.posts')
        </div>
    </div>
    @include('include.footer')
@endsection
