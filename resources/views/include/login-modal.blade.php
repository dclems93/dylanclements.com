<div id="loginmodal" class="modal">
    <form class="modal-content animate" action="{{ route('signin') }}" method="post">
        <div class="imgcontainer">
            <span onclick="document.getElementById('loginmodal').style.display='none'" class="close" title="Close Modal">&times;</span>
            <img src="https://s3.us-east-2.amazonaws.com/dclems-blog-assets/default.jpg" alt="Avatar" class="avatar" style="width:50%;">
        </div>

        <div class="container">
            <label for="eml"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="eml" value={{ Request::old('eml') }}>

            <label for="pass"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="pass" value={{ Request::old('pass') }}>
            <button type="submit">Login</button>
            <input type="hidden" name="_token" value="{{ Session::token() }}">
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        </div>
    </form>
</div>