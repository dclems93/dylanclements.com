<?php
namespace App\Http\Controllers;

use App\Post;
use App\Like;
use App\User;
use App\Comment;
use App\Tag;
use App\PrimaryPic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Collective\Html\HtmlServiceProvider;

class PostController extends Controller{
	public function getWelcome(){
        $admin = User::where('email','dylan@gmail.com')->first();
        $admin_id = $admin->id;
        // Recent posts
        $posts = Post::where('user_id',$admin_id)
            ->latest()
            ->take(3)
            ->get();
        return view('welcome', ['posts' => $posts, 'user' => Auth::user()]);
    }

    public function getBlog(){
        $admin = User::where('email','dylan@gmail.com')->first();
        $admin_id = $admin->id;
        $posts = Post::where('user_id',$admin_id)
            ->latest()
            ->get();
        $starred = Post::where('user_id',$admin_id)
            ->where('starred',true)
            ->latest()
            ->take(5)
            ->get();
        //get ids of most popular tags
        $tags = DB::table('post_tags')
            ->join('tags', 'post_tags.tag_id','=','tags.id')
            ->select('text',DB::raw('count(text) as total_tagged'))
            ->groupBy('text')
            ->orderBy('total_tagged','desc')
            ->take(10)
            ->get();


        return view('blog', ['posts' => $posts,'starred'=>$starred, 'tags' => $tags, 'user' => Auth::user()]);
    }

    public function getForum(){
		$posts = Post::latest()->get();
		return view('forum', ['posts' => $posts]);
	}
    //TODO Verify that the file being posted is an image
    public function postCreatePost(Request $request){
	    try {
            $message = "There was an error saving your post.";
            // Verify user logged in
            if (!Auth::user()) {
                $message = "You must be logged in to create a post!";
                return redirect()->back()->with(['message' => $message]);
            }
            $user = Auth::user();
            $this->validate($request, [
                'body' => 'required|max:10000',
                'tag' => 'max:100',
                'title' => 'required|max:255']);
            $post = new Post();
            $post->body = $request['body'];
            $post->title = $request['title'];
            if ($request['starred']) {
                $post->starred = true;
            }
            $post->save();
            // Check for image in form
            if( $request->hasFile('image')) {
                $file = $request->file('image');
                $mimeType = strtolower($file->getClientOriginalExtension());
                $fileSize = $file->getClientSize();
                // Retrieve instance of s3 storage
                $fileName = '/post-pics/'. $user->id . '/' . 'post_pics_' . uniqid() . '.' . $request->file('image')->guessClientExtension();
                $s3 = Storage::disk('s3');
                // Test if it saved to storage, if so create a model for it and save to database
                if ($s3->put($fileName, file_get_contents($file), 'public')) {
                    $image = new PrimaryPic();
                    $image->url = $fileName;
                    $image->size = $fileSize;
                    $image->mime_type = $mimeType;
                    $image->save();
                    $image->user()->associate($user);
                    $image->post()->associate($post);
                    $image->update();
                }
            }
            // if user applied tags to post, handle tags and associate with post
            if ($request['tags']) {
                $tags = explode(",", $request['tags']);
                foreach ($tags as $tag) {
                    $ltag = strtolower($tag);
                    // Check if tag exists on database
                    $tag_exists = Tag::where('text', $ltag)->first();
                    if ($tag_exists) {
                        $post->tags()->attach($tag_exists);
                    } else {
                        // create tag if it is new
                        $new_tag = new Tag();
                        $new_tag->text = $ltag;
                        $new_tag->save();
                        $post->tags()->attach($new_tag);
                    }
                }
            }
            // save the post to user, if it fails return an error message
            if ($request->user()->posts()->save($post)) {
                $message = 'Post successfully created!';
            }
        }
        catch(Exception $e) {
            //TODO Log to file
            //TODO reconfig the text editor
	        return redirect()->back()->with(['message' => $message]);
        }

        return redirect()->back()->with(['message' => $message]);
    }
    public function getDeletePost($post_id){
    	$post = Post::where('id', $post_id)->first();
    	if(Auth::user() != $post->user){
    		return redirect()->back();
    	}
    	$post->delete();
    	return redirect()->route('forum')->with(['message' => 'Post Successfully deleted!']);
    }

    public function getDeletePostWelcome($post_id){
        $post = Post::where('id', $post_id)->first();
        if(Auth::user() != $post->user){
            return redirect()->back();
        }
        $post->delete();
        return redirect()->route('welcome')->with(['message' => 'Post Successfully deleted!']);
    }

    public function postEditPost(Request $request){
        $this->validate($request, [
            'body' => 'required'
        ]);
        $post = Post::find($request['postId']);
        if(Auth::user() != $post->user){
               return redirect()->back();
        }
        $post->body = $request['body'];
        $post->title = $request['title'];
        if($request['tag']){
            $post->tag = $request['tag'];
        }
        $post->update();
    
        return response()->json(['new_title' => $post->title, 'new_body' => $post->body], 200);
    }
    
    public function postCreateComment(Request $request){
        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);

        $message = 'There was an error';
        $post_id = $request['post_id'];
        
        $post = Post::where('id', $post_id)->first();
        if(!$post){
            return redirect()->back()->with(['message' => $message]);
        }
        $user = Auth::user();

        $comment = new Comment();
        $comment->body = $request['body'];
        $comment->user_id = $user->id;
        $comment->post_id = $post->id;        
        
        if($request->user()->comments()->save($comment)){
            $message = 'Comment successfully created!';
        }
        return redirect()->back()->with(['message' => $message]);

    }

    public function postLikePost(Request $request){
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true'? true:false;
        $update = false;
        $post = Post::find($post_id);
        if(!$post){
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if($like){
            $already_like = $like->like;
            $update = true;
            if($already_like == $is_like){
                $like->delete();
                return null;
            }
        }else{
            $like = new Like();
        }
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if($update){
            $like->update();
        }else{
            $like->save();
        }
        return null;
    }

}