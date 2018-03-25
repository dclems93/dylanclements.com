var postId = 0;
var postBodyElement = null;
var postCommentString = null;
var postComments = null;
var postSomeComments = null;
var postAllComments = null;
var postLeaveComment = null;
var postCommentBtn = null;
var postCommentCount = null;
var page = $('.page');
var modal = document.getElementById('id01');


$('.menu_toggle').on('click', function(){
    var $elm = $('.content');
    var $innerElm = $('navbar')
    if($elm.hasClass('openPage')){
        $elm.removeClass('openPage');
    }
    page.toggleClass('shazam');

});
$('.content').on('click', function(){
    page.removeClass('shazam');
});


$('.post').find('.interaction').find('.edit').on('click', function(event){
    console.log('itworks!');
    event.preventDefault();
    postTitleElement = event.target.parentNode.parentNode.childNodes[1];
    postBodyElement = event.target.parentNode.parentNode.childNodes[3];
    var postTitle = postTitleElement.textContent;
    var postBody = postBodyElement.textContent;
    postId = event.target.parentNode.parentNode.dataset['postid'];
    $('#post-title').val(postTitle);
    $('#post-body').val(postBody);
    $('#edit-modal').modal();
});

$('.projects').find('.new_project').on('click', function(event){
    event.preventDefault();
    $('#project-modal').modal();
});

$('#modal-save').on('click', function(){
    $.ajax({
        method: 'POST',
        url: urlEdit,
        data: {title: $('#post-title').val(), body: $('#post-body').val(), postId: postId, _token: token}
    })
        .done(function (msg){
            $(postTitleElement).text(msg['new_title']);
            $(postBodyElement).text(msg['new_body']);
            $('#edit-modal').modal('hide');
        });

});

$('#modal-new-project-save').on('click', function(){
    $.ajax({
        method: 'POST',
        url: urlNewProject,
        data: {title: $('#project-title').val(), base: $('#project-base').val(), _token: token}
    })
        .done(function (msg){
            //$(projectTitleElement).text(msg['project_title']);
            //$(projectBaseElement).text(msg['project_base']);
            $('#project-modal').modal('hide');
        });

});

$('.like').on('click', function(event){
	event.preventDefault();
	postId = event.target.parentNode.parentNode.dataset['postid'];
	var isLike = true;
	console.log(isLike);
	$.ajax({
		method: 'POST',
		url: urlLike,
		data: {isLike: isLike, postId: postId, _token: token}
	})

	.done(function(){
		event.target.innerText = event.target.innerText == 'Like' ? 'You Like this post' : 'Like'  ;
		if(event.target.innerText == 'You Like this post'){
			event.target.nextElementSibling.innerText ='Dislike';
		}
	});
});

$('.dislike').on('click', function(event){
	event.preventDefault();
	postId = event.target.parentNode.parentNode.dataset['postid'];
	var isLike = false;
	$.ajax({
		method: 'POST',
		url: urlLike,
		data: {isLike: isLike, postId: postId, _token: token}
	})
	.done(function(){
		event.target.innerText = event.target.innerText  == 'Dislike' ? 'You Dislike this post' : 'Dislike' ;
		if(event.target.innerText == 'You Dislike this post'){
			event.target.previousElementSibling.innerText ='Like';
		}
		$window.location.reload();
	});
});


function getComments(postid){
	var postCommentString = "#";
	var postCommentString = postCommentString.concat(postid);
	console.log(postid);
	var postSomeComments = postCommentString.concat("-some-comments");
	$(postSomeComments).toggle();
	var postAllComments = postCommentString.concat("-all-comments");
	$(postAllComments).toggle();
	var postCommentCount = postCommentString.concat("-comment-count");
	$(postCommentCount).toggle();

};

function getLeaveComment(postid){
	var postCommentString = "#";
	var postCommentString = postCommentString.concat(postid);
	var postLeaveComment = postCommentString.concat("-leave-comment");
	$(postLeaveComment).toggle();

	var postCommentBtn = postCommentString.concat("-leave-comment-btn");
	$(postCommentBtn).toggle();

};

// On doc load, load first animation
$(window).bind("load", function() {
    var $elm = $('.content');
    $('.imac-frame').addClass('start');
    $($elm).addClass('makeVisible');
    $($elm).addClass('openPage');
});
// Check if element is within viewport
function isElementInViewport(elem) {
    var $elem = $(elem);
    var scrollElem = ((navigator.userAgent.toLowerCase().indexOf('webkit') != -1) ? 'body' : 'html');
    var viewportTop = $(scrollElem).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    var elemTop = Math.round( $elem.offset());
    var elemBottom = elemTop + $elem.height();

    return ((elemTop < viewportBottom) && (elemBottom > viewportTop));
};


function pushLink(st) {
    event.preventDefault();
    var $elm = $('.content');
    $($elm).addClass('closePage');
    var timeout = window.setTimeout(function() { forwardPage(st); },1000);
};

function forwardPage(st) {
    console.log(st);
    // have to reset the url
    window.location = st;
}

// Loop through static-defined list of classes that need animating during scrolling events
function checkAnimation() {
	var anim_list = ['.jumbo .j-image-left','.jumbo .j-image-right','.transbox','.circleimg'];
	for(var i=0;i<anim_list.length;i++) {

        var $cur_class = $(anim_list[i]);
        //console.log("tryiing out " + anim_list[i]);
        if ($cur_class.hasClass('start')) return;
        try {
            if (isElementInViewport($cur_class)) {
                try {
                    //console.log($cur_class + "is in viewport!");
                    $cur_class.addClass('start');
                }
                catch (error) {
                    console.log(error);
                }
            }
        }
        catch (error) {
            console.log(error);
        }
    }

};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

$('.content_inner').scroll(function(){
    //checkAnimation();
});


