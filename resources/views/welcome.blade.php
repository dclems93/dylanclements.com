@extends('layouts.master')

@section('content')
    @include('include.message-block')
    <div class="jumbo one-hundo first-elem" id="welcome">
        <div class="imac-frame fifty-fifty">
            <img src="assets/mac_lr.png" id="imac-frame"/>
            <img src="assets/mac_opt.gif" alt="" id="mac-intro" />
        </div>
        <div class="transbox"><p>A Technology and Programming Blog</p></div>
    </div><!-- / welcome jumbo -->
    <img class="torn-top" src="/assets/torn_top_long.png">
    <!-- id="first-section" must be applied to first section for the nav scroll sticky function to work -->
    <section>
        <div class="one-hundo" style="border-bottom: solid #bdbdbd 1px; padding-bottom:1%;">
            <img src="https://s3.us-east-2.amazonaws.com/dclems-blog-assets/dylan-faceshot.jpg" style="width:40%; margin-left:30%; margin-top:0; padding-top:0;"
                 class="avatar">
        </div>
        <div class="one-hundo about-section">
            <div class="about-header">
                <h4>About Me</h4>
            </div>
            <p style="text-align: center;">Technology and programming have been one of my many passions since childhood. In my free time, I like to work on side-projects that are often technology related. I wanted a place to display these projects, so I made this website to document what I have worked on, and hopefully help others. I am a big believer that technology moves forward through sharing knowledge, so I hope that by documenting and sharing code, others can learn as well.</p>
            <div class="about-header">
                <h4>My skills</h4>
            </div>
            <p style="margin-left: 10%;">
                <b>Java</b> :  Abundant experience creating RESTful APIs, stand-alone applications, and Web-Apps.<br>
                <b>Databases</b> :  SQL, MySQL, and PostgreSQL.<br>
                <b>Deployment</b> :  Kubernetes, AWS, and Heroku.<br>
                <b>Agile/Scrum</b> :  Worked in an Agile environment at a corporate level.<br>
                <b>Android</b> :  Utilized features: Google Maps, Camera, Tensorflow integration, and others.<br>
                <b>Web-Apps</b> :  Java JSP, Grails, and Laravel.<br>
                <b>C</b> :  Experience making command-line applications, arduino, and ARM chips.<br>
                <b>Operating Systems</b> :  Proficient in Linux, Mac OS, and Windows.<br>
            </p>
            <div class="about-header">
                <h4>Contact Me</h4>
            </div>
            <p style="margin-left: 10%;"><b>Email:</b> djclements93@gmail.com<br>
                <b>Phone:</b> (765) 994-1932<br><br>
                <b>Click <a href="https://s3.us-east-2.amazonaws.com/dclems-blog-assets/Dylan+Clements+Resume+2016.pdf"
                            target="_blank">HERE</a> to download my resume.</b><br><br>

                <b>Social media: </b><br>
            <a href="https://www.linkedin.com/in/dylan-clements-5111a1125" target="_blank"><img
                            src="https://s3.us-east-2.amazonaws.com/dclems-blog-assets/link-logo.png"
                            style="width: 60px; padding:5px;"></a>
            <a href="https://github.com/dclems93/main/"
                                                                      target="_blank"><img
                            src="https://s3.us-east-2.amazonaws.com/dclems-blog-assets/github-logo.png"
                            style="width: 60px;padding:5px;"></a>
            <a href="https://www.facebook.com/dylanclements93"
                                                                     target="_blank"><img
                            src="https://s3.us-east-2.amazonaws.com/dclems-blog-assets/facebook-logo.png"
                            style="width: 60px; padding:5px;"></a></div> </p>


    </section> <!-- end about me -->
    <img class="torn-bottom" src="/assets/torn_bottom_long.png">
    <div id="recent-posts" class="one-hundo jumbo" >
        <div class="fifty-fifty" id="ibm-container">
            <img id="ibm_back" src="/assets/ibm_comp_back.png"/>
            <img id="ibm_front" src="/assets/ibm_comp_front.png"/>
        </div>
        <div class="transbox" ><p>What is Dylan up to?</p></div>
    </div>
    <img class="torn-top" src="/assets/torn_top_long.png">
    <section>
        @include('sections.posts')
    </section>
    @include('include.footer')
@endsection
