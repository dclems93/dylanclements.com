<div id="newpostmodal" class="modal">
    {!! Form::open(array('route' => 'post.create', 'files'=>'true', 'method'=>'post', 'class'=>'modal-content animate')) !!}
    <div class="imgcontainer">
        <span onclick="document.getElementById('newpostmodal').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>
    <div class="container">
        <h3>Create a new post:</h3>
        {!! Form::label('title','Title:') !!}
        {!! Form::text('title') !!}
        {!! Form::label('body','Body:') !!}
        {!! Form::textarea('body',null,['class'=>'postbody']) !!}
        {!! Form::label('tags','Tags:','Separate tags with a comma...') !!}
        {!! Form::text('tags') !!}
        {!! Form::label('starred','Star this post?') !!}
        {!! Form::checkbox('starred','value',false) !!}
        {!! Form::label('image','Header image:') !!}
        {!! Form::file('image') !!}
        <input type="hidden" value="{{ Session::token() }}" name="_token">
        <button type="submit">Submit</button>
    </div>
    <div class="container" style="background-color:#f1f1f1">
        <button type="button" onclick="document.getElementById('newpostmodal').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
    {!! Form::close() !!}
</div>
<script src="{{ URL::to('src/js/vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
    var editor_config = {
        path_absolute : "{{ URL::to('/') }}/",
        selector: "textarea.postbody",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
        file_browser_callback : function(field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }
            tinyMCE.activeEditor.windowManager.open({
                file : cmsURL,
                title : 'Filemanager',
                width : x * 0.8,
                height : y * 0.8,
                resizable : "yes",
                close_previous : "no"
            });
        }
    };
    tinymce.init(editor_config);
</script>