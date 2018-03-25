<div class="comment-container">
    <div class="row">
        <div class="cell" style="width:5%; padding-top: 1%;  padding-right: 1%;">
            @if (1==1)
                <a href="{{ route('profile', ['profile_user_id' => $post->user]) }}"><img src="/assets/default-propic.jpg" class="responsive comment-avatar"></a>
            @else
                    <a href="{{ route('profile', ['profile_user_id' => $post->user]) }}"><img src="/assets/default-propic.jpg" class="responsive comment-avatar"></a>
            @endif
        </div>
        <div class="cell" style="width:70%;">
            <div class ="well comment-body">
                <h6 style="padding: 0; margin: 0;">{{$comment->user->first_name}} {{$comment->user->last_name}} wrote:</h6>
                <p style="padding:0; margin:0;">{{ $comment->body }}</p>
                <div class = "info">
                Posted {{ $comment->created_at->diffForHumans()}}
                </div>
            </div>
        </div>
    </div>
</div>