<?php
namespace App\Http\Controllers;

use App\Post;
use App\Like;
use App\User;
use App\Comment;
use App\Project;
use App\Section;
use App\Tag;
use App\PrimaryPic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Collective\Html\HtmlServiceProvider;


class ProjectController extends Controller
{
    public function getProjects()
    {
        $admin = User::where('email', 'dylan@gmail.com')->first();
        $admin_id = $admin->id;
        $projects = Project::where('user_id', $admin_id)->get();
        return view('projects', ['projects' => $projects, 'user' => Auth::user()]);
    }

    public function getProject($project_id)
    {
        $project = Project::where('id',$project_id)->first();
        return view('project',['project'=>$project,'user' => Auth::user()]);
    }

    public function postCreateProject(Request $request)
    {
        try {
            $message = "There was an error creating your project.";
            // Verify user logged in
            if (!Auth::user()) {
                $message = "You must be logged in to create a project!";
                return redirect()->back()->with(['message' => $message]);
            }
            $user = Auth::user();
            //todo: check file size, verify image type
            $this->validate($request, [
                'project-title' => 'required|max:255',
                'section-title' => 'required|max:255',
                'project-description' => 'required|max:10000',
                'section-content' => 'required|max:10000',
                'tag' => 'max:100'
                ]);
            $project = new Project();
            $project->description = $request['project-description'];
            $project->title = $request['project-title'];
            if ($request['starred']) {
                $project->starred = true;
            }
            $project->save();
            // Check for image in form
            if( $request->hasFile('image')) {
                $file = $request->file('image');
                $mimeType = strtolower($file->getClientOriginalExtension());
                $fileSize = $file->getClientSize();
                // Retrieve instance of s3 storage
                $fileName = '/project-pics/'. $user->id . '/' . 'project_pics_' . uniqid() . '.' . $request->file('image')->guessClientExtension();
                $s3 = Storage::disk('s3');
                // Test if it saved to storage, if so create a model for it and save to database
                if ($s3->put($fileName, file_get_contents($request->file('image')), 'public')) {
                    $image = new PrimaryPic();
                    $image->url = $fileName;
                    $image->size = $fileSize;
                    $image->mime_type = $mimeType;
                    $image->save();
                    $image->user()->associate($user);
                    $image->project()->associate($project);
                    $image->update();
                }
            }
            // if user applied tags to project, handle tags and associate with project
            if ($request['tags']) {
                $tags = explode(",", $request['tags']);
                foreach ($tags as $tag) {
                    $ltag = strtolower($tag);
                    // Check if tag exists on database
                    $tag_exists = Tag::where('text', $ltag)->first();
                    if ($tag_exists) {
                        $project->tags()->attach($tag_exists);
                    } else {
                        // create tag if it does not exist in database
                        $new_tag = new Tag();
                        $new_tag->text = $ltag;
                        $new_tag->save();
                        $project->tags()->attach($new_tag);
                    }
                }
            }
            // create first section for project on creation, avoid having empty projects.
            $section = new Section();
            $section->section_number = 1;
            $section->title = $request['section-title'];
            $section->content = $request['section-content'];
            $section->save();
            $section->project()->associate($project);
            $section->update();


            // save the project to user, if it fails return an error message
            if ($request->user()->projects()->save($project)) {
                $message = 'Project successfully created!';
            }
        }
        catch(Exception $e) {
            //TODO Log to file
            //TODO reconfig the text editor
            return redirect()->back()->with(['message' => $message]);
        }

        return redirect()->back()->with(['message' => $message]);
    }


}