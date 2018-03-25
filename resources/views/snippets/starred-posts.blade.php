<div class="one-hundo">
    <h6 style="padding-top:0; margin-top:0;">Starred posts:</h6>
</div>
<div class="starred-posts">
    @foreach($starred as $st_post)
        <div class="row starred-posts">
            <div class="one-hundo">
                <div class="starred-image-container">
                    <img src="https://s3.us-east-2.amazonaws.com/dclems-blog-assets{{ $st_post->primarypic->url }}">
                </div>
            </div>
            <div class="one-hundo" style="margin:0; padding:0;">
                <p style="margin:0; padding:5% 5% 5% 5%;" >{{ $st_post->title }}</p>
            </div>
        </div>
    @endforeach
</div>