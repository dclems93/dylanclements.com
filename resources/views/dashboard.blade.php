@extends('layouts.master-no-container')

@section('content')
@include('include.message-block')
	<section class="post-post row jumbotron" id="post-post">
		<div class="container-fluid">
            <div class="col-md-6 col-md-offset-3"
		<header class="header"><h3>Let's talk tech.</h3>
		<p>Use this area to create your own posts, ask questions from other users, and see what other people are working on.</p></header>
		<form action="{{ route('post.create') }}" method="post">
			<div class="form-group">
            <textarea class="form-control well" name="title" id="new-post" rows ="1" placeholder="title..."></textarea>
				<textarea class="form-control well" name="body" id="new-post" rows ="5" placeholder="What do you have brewing up this time?"></textarea>
			</div>
			<button type="submit" class="btn btn-primary">Create Post</button>
			<input type="hidden" value="{{ Session::token() }}" name="_token">
		  </form>
          </div>
		</div>
	</section>
    <header class="col-md-6 col-md-offset-3"><h3>Recent Posts</h3></header>
	<section class="row posts container-fluid">

		@foreach($posts as $post)
        <div class="post-image col-md-3 col-md-offset-1 hidden-sm-down">
                    @if (Storage::disk('local')->has($post->user->id . '-' . 'avatar.jpg'))
                        <img src="{{ route('account.image', ['filename' => $post->user->id . '-' . 'avatar.jpg']) }}" class = "responsive img-circle pull-right" style=" width:80px; height:80px; pull:right">
                    @else
                        <img src="{{ route('account.image', ['filename' => 'default.jpg']) }}" class = "responsive img-circle pull-right" style=" width:80px; height:80px;">

                    @endif
        </div>
        <div class="col-md-6">
			<article class="post" data-postid="{{ $post->id }}">
                <div class="post-title">{{ $post->title }}</div>
                <div class="post-content">
				    <p>{{ $post->body }}</p>
                    <div class = "info">
                    Posted by {{ $post->user->first_name }} {{ $post->user->last_name }} on {{ $post->created_at}}
                    </div>
                </div>
                <div class = "likes">
                    @if(count($post->likes->where('like',1))==0)
                    @elseif(count($post->likes->where('like',1))==1)
                        {{ $post->likes->where('like', 1)->first()->user->first_name }} {{ $post->likes->where('like', 1)->first()->user->last_name }} Likes this
                    @elseif(count($post->likes->where('like',1))==2)
                        {{($post->likes->where('like', 1))->first()->user->first_name}} {{($post->likes->where('like', 1))->first()->user->last_name}} and {{($post->likes->where('like', 1))->last()->user->first_name}} {{($post->likes->where('like', 1))->last()->user->last_name}} Like This
                    @else(count($post->likes->where('like', 1))>=4)
                        {{($post->likes->where('like', 1))->first()->user->first_name}} {{($post->likes->where('like', 1))->first()->user->last_name}} and {{count($post->likes->where('like', 1)) - 1}}  Others Like This
                    @endif
                </div>
                <div class = "dislikes">
                    @if(count($post->likes->where('like',0))==0)
                    @elseif(count($post->likes->where('like',0))==1)
                        {{ $post->likes->where('like', 0)->first()->user->first_name }} {{ $post->likes->where('like', 0)->first()->user->last_name }} Disikes this
                    @elseif(count($post->likes->where('like',0))==2)
                        {{($post->likes->where('like', 0))->first()->user->first_name}} {{($post->likes->where('like', 0))->first()->user->last_name}} and {{($post->likes->where('like', 0))->last()->user->first_name}} {{($post->likes->where('like', 0))->last()->user->last_name}} Dislike This
                    @else(count($post->likes->where('like', 0))>=4)
                        {{($post->likes->where('like', 0))->first()->user->first_name}} {{($post->likes->where('like', 0))->first()->user->last_name}} and {{count($post->likes->where('like', 0)) - 1}}  Others Disike This
                    @endif
                </div>
                

				<div class="interaction">
					<a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'You Like this post' : 'Like' : 'Like' }}</a> |
					<a href="#" class="dislike">{{ Auth::user()->likes()->where('post_id' , $post->id)->first() ? Auth::user()->likes()->where('post_id' , $post->id)->first()->like == 0 ? 'You Dislike this post' : 'Dislike' : 'Dislike' }}</a>
					@if(Auth::user() == $post->user)
						 | <a href="#" class="edit">Edit</a> |
						<a href="{{ route('post.delete', ['post_id' => $post->id]) }} ">Delete</a>
					@endif
				</div>
			</article>
            <div class="comments">
                <h5>Comments</h5>
                @foreach($post->comments as $comment)
                <div class="comment_info col-md-12 pull-left">
                    {{$comment->user->first_name}} {{$comment->user->last_name}} wrote:
                </div>
                <div class ="well col-md-10 col-md-offset-1 col-md-offset-right-1">
                    <p>{{ $comment->body }}</p>
                    <div class = "info">
                    Posted on {{ $comment->created_at}}
                    </div>
                </div>
                @endforeach
                @if(!Auth::user())
                <div class="postinfo">
                    <a href="{{ route('userlogin') }}">Sign In</a> to leave a comment
                </div>
                @endif
                @if(Auth::user())
                <a href="javascript:void(0)" class="col-md-10 col-md-offset-1 pull-left" id="leave-comment-btn"><h5>Leave a Comment...</h5></a>
                <div class="leave-comment">
                <form action="{{ route('comment.create', ['post_id' => $post->id]) }}" method="post">
                    <div class="form-group" id="comment-submit">
                        <textarea class="form-control well" name="body" id="new-comment" rows ="5" placeholder="Have something to say?"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" id="post-comment-btn">Post Comment</button>
                    <input type="hidden" value="{{ Session::token() }}" name="_token">
                </form>
                </div>
                @endif
            </div>
            </div>
        @endforeach
        </div>
	</section>
	<div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title">Edit Post</h4>
      			</div>
      			<div class="modal-body">
        			<form>
                    <div class="form-group">
                        <label for="post-title">Edit the Post</label>
                        <textarea class="form-control" name="post-title" id="post-title" rows="1"></textarea>
                        <label for="post-body"></label>
                        <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
        			</div>
        			</form>
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        			<button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
      			</div>
    		</div><!-- /.modal-content -->
  		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<script>
		var token = '{{ Session::token() }}';
		var urlEdit = '{{ route('edit') }}';
		var urlLike = '{{ route('like') }}';
	</script>
@endsection
