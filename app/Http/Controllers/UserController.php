<?php
namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
//use vendor\autoload.php;
//use aws/aws-sdk-php;

class UserController extends Controller{
	public function postSignUp(Request $request){
		$this->validate($request, [
			'email' => 'required|email|unique:users',
			'first_name' => 'required|max:120',
			'last_name' => 'required|max:120',
			'password' => 'required|min:4'
			]);
		$email = $request['email'];
		$first_name = $request['first_name'];
		$last_name = $request['last_name'];
		$password = bcrypt($request['password']);


		$user = new User();
		$profile = new Profile();

		$user->email = $email;
		$user->password = $password;
		$user->first_name = $first_name;
		$user->last_name = $last_name;
		$user->save();
		$profile->user()->associate($user);
		$profile->save();
		$user->roles()->attach(Role::where('name', 'User')->first());
        $message = "There was an error creating your account.";
        if(Auth::attempt(Auth::login($user))){
            $message = "Account successfully created!";
        }

		return redirect()->route('welcome')->with(['message' => $message]);
	}
	
	public function postSignIn(Request $request){
		$this->validate($request, [
			'eml' => 'required',
			'pass' => 'required'
			]);
		if(Auth::attempt(['email' => $request['eml'], 'password' => $request['pass']])){
			return redirect()->route('welcome');
		}
		return redirect()->back();
	}
	
	public function getLogout(){
		Auth::logout();
		return redirect()->route('welcome');
	}

	public function getAccount(){
		return view('account', ['user' => Auth::user()]);
	}

	public function getUserProfile(Request $request){
		//$profile_user = User::find('profile_user_id');
		$profile_user_id = $request['profile_user_id'];
		$profile_user = User::where('id', $profile_user_id)->first();
		return view('profile', ['user' => Auth::user(), 'profile_user' => $profile_user]);
	}

	public function getAdmin()
    {
        $users = User::all();
        return view('admin', ['users' => $users]);
    }

	public function postSaveAccount(Request $request){
		$this->validate($request, [
			'first_name' => 'required|max:120',
			'last_name' => 'required|max:120'
			]);
		
		$user = Auth::user();
		$user->first_name = $request['first_name'];
		$user->last_name = $request['last_name'];
		$user->update();
		$file = $request->file('image');
		$filename = $user->id . '-' . 'avatar' . '.jpg';
		if($file){
			Storage::disk('s3')->put($filename, File::get($file), 'public');
		}
		return redirect()->route('account');
	}

	public function getUserImage($filename){
		$file = Storage::disk('s3')->get($filename);
		return new Response($file, 200);
	}

}