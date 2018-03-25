@foreach($posts as $post)
    <div class="post">
        <article class="post" data-postid="{{ $post->id }}">
            <div class="post-title"><h2>{{ $post->title }}</h2>
                <p style="color:gray;">{{ $post->user->first_name }} {{ $post->user->last_name }} | {{ $post->created_at->diffForHumans()}}</p>
            </div>
            @if(!$post->primarypic==null)
                <div class="post-image">
                    <img src="https://s3.us-east-2.amazonaws.com/dclems-blog-assets{{ $post->primarypic->url }}">
                </div>
            @endif
            <div class="post-content">
                <p>{!! $post->body !!}</p>
            </div>
            <div class="likes">
                @if(count($post->likes->where('like',1))==0)
                @elseif(count($post->likes->where('like',1))==1)
                    {{ $post->likes->where('like', 1)->first()->user->first_name }} {{ $post->likes->where('like', 1)->first()->user->last_name }} Likes this
                @elseif(count($post->likes->where('like',1))==2)
                    {{$post->likes->where('like', 1)->first()->user->first_name}} {{$post->likes->where('like', 1)->first()->user->last_name}} and {{$post->likes->where('like', 1)->last()->user->first_name}} {{$post->likes->where('like', 1)->last()->user->last_name}} Like This
                @elseif(count($post->likes->where('like', 1))>=4)
                    {{$post->likes->where('like', 1)->first()->user->first_name}} {{$post->likes->where('like', 1)->first()->user->last_name}} and {{count($post->likes->where('like', 1)) - 1}}  Others Like This
                @else
                @endif
            </div>
            <div class = "dislikes">
                @if(count($post->likes->where('like',0))==0)
                @elseif(count($post->likes->where('like',0))==1)
                    {{ $post->likes->where('like', 0)->first()->user->first_name }} {{ $post->likes->where('like', 0)->first()->user->last_name }} Disikes this
                @elseif(count($post->likes->where('like',0))==2)
                    {{$post->likes->where('like', 0)->first()->user->first_name}} {{$post->likes->where('like', 0)->first()->user->last_name}} and {{$post->likes->where('like', 0)->last()->user->first_name}} {{$post->likes->where('like', 0)->last()->user->last_name}} Dislike This
                @elseif(count($post->likes->where('like', 0))>=4)
                    {{$post->likes->where('like', 0)->first()->user->first_name}} {{$post->likes->where('like', 0)->first()->user->last_name}} and {{count($post->likes->where('like', 0)) - 1}}  Others Disike This
                @endif
            </div>


            <div class="interaction">
                @if(Auth::user())
                    <a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'You Like this post' : 'Like' : 'Like' }}</a> |
                    <a href="#" class="dislike">{{ Auth::user()->likes()->where('post_id' , $post->id)->first() ? Auth::user()->likes()->where('post_id' , $post->id)->first()->like == 0 ? 'You Dislike this post' : 'Dislike' : 'Dislike' }}</a>
                @endif
                @if(Auth::user() == $post->user)
                    | <a href="#" class="edit">Edit</a> |
                    <a href="{{ route('post.delete', ['post_id' => $post->id]) }} ">Delete</a>
                @endif
            </div>
        </article>

        <div class="comments">
            @if(count($post->comments)>0)
                <p>Comments:</p>
            @elseif(!Auth::user())
                <p><a href="#" onclick="document.getElementById('loginmodal').style.display='block'">Log In</a> to be the first to comment!</p>
            @endif

            <div class="all-comments" id="{{$post->id }}-comments">
                @foreach($post->comments as $comment)
                    <div class ="well comment-body">
                        <h6>{{$comment->user->first_name}} {{$comment->user->last_name}} wrote:</h6>
                        <p>{{ $comment->body }}</p>
                        <div class = "info">
                            Posted on {{ $comment->created_at}}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="some-comments" id="{{$post->id }}-some-comments">
                <?php $i=0 ?>
                @foreach($post->comments as $comment)
                    @if($i ==2)
                        @break
                    @endif
                    @include('snippets.disp-comment')
                    <?php $i++ ?>
                @endforeach

                @if(count($post->comments) <= 2)
                @else
                    <h6 style="padding:0;margin:0;margin-left:10%;">Showing 2 of {{count($post->comments) }} comments. </h6>
                @endif


                @if(count($post->comments) >= 2)
                    <a href="javascript:void(0)" id="view-comments-btn" onclick="getComments({{$post->id}})"><h6 style="padding:0;margin:0;margin-left:10%;">Display All Comments</h6></a>
                @endif


            </div>

            <div class="all-comments" id="{{$post->id }}-all-comments">
                @foreach($post->comments as $comment)
                    @include('snippets.disp-comment')
                @endforeach
            </div>

            @if(Auth::user())
                <div class="comment-btn">
                    <a href="javascript:void(0)" class="leave-comment-btn " id="{{$post->id}}-leave-comment-btn" onclick="getLeaveComment({{$post->id}})"><button type="submit" class="comment-button" style="margin-left:10%;"><span>Comment</span></button></a>
                </div>
                <div class="leave-comment" id="{{$post->id}}-leave-comment" style="margin-top: 10px;">
                    <form action="{{ route('comment.create', ['post_id' => $post->id]) }}" method="post">
                        <div class="form-group" id="comment-submit">
                            <textarea class="form-control" style="width:50%;margin-left:10%;" rows=3 name="body" id="new-comment" placeholder="Have something to say?"></textarea>
                        </div>
                        <button type="submit" class="comment-button" id="post-comment-btn" style="margin-left:10%;"><span>Comment</span></button>
                        <input type="hidden" value="{{ Session::token() }}" name="_token">
                    </form>
                </div>
            @endif
        </div>
    </div>
@endforeach