@extends('layouts.adminLayout.admin_designApp')

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
<!--   <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" > -->

<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons">
<link rel="stylesgeet" href="https://rawgit.com/creativetimofficial/material-kit/master/assets/css/material-kit.css">
<style type="text/css">
    html *{
    -webkit-font-smoothing: antialiased;
}
    .content-wrapper{
        padding-right: 15px !important;
        padding-left: 15px !important;
    }
.h6, h6 {
    font-size: .75rem !important;
    font-weight: 500;
    font-family: Roboto,Helvetica,Arial,sans-serif;
    line-height: 1.5em;
    text-transform: uppercase;
}
.col-md-6{
    float:inherit !important;
}
.name h6 {
    margin-top: 10px;
    margin-bottom: 10px;
}


.profile-page .page-header {
    height: 380px;
    background-position:center;
}

.page-header {
    height: 90vh;
    background-size: cover;
    margin: 0;
    padding: 0;
    border: 0;
    display: flex;
    align-items: center;
}

.header-filter:after, .header-filter:before {
    position: absolute;
    z-index: 1;
    width: 100%;
    height: 100%;
    display: block;
    left: 0;
    top: 0;
    content: "";
}

.header-filter::before {
    background: rgba(0,0,0,.5);
}

.main-raised {
    margin-top: -15%;
    margin-right: 5%;
    margin-left:5%;
    border-radius: 6px;
    box-shadow: 0 16px 24px 2px rgba(0,0,0,.14), 0 6px 30px 5px rgba(0,0,0,.12), 0 8px 10px -5px rgba(0,0,0,.2);
}

.main {
    background: #FFF;
    position: relative;
    z-index: 3;
}

.profile-page .profile {
    text-align: center;
}

.profile-page .profile img {
    max-width: 160px;
    width: 100%;
    margin: 0 auto;
    -webkit-transform: translate3d(0,-50%,0);
    -moz-transform: translate3d(0,-50%,0);
    -o-transform: translate3d(0,-50%,0);
    -ms-transform: translate3d(0,-50%,0);
    transform: translate3d(0,-50%,0);
}

.img-raised {
    box-shadow: 0 5px 15px -8px rgba(0,0,0,.24), 0 8px 10px -5px rgba(0,0,0,.2);
}

.rounded-circle {
    border-radius: 50%!important;
}

.img-fluid, .img-thumbnail {
    max-width: 100%;
    height: auto;
}

.title {
    margin-top: 30px;
    margin-bottom: 25px;
    min-height: 32px;
    color: #3C4858;
    font-weight: 700;
    font-family: "Roboto Slab","Times New Roman",serif;
}

.profile-page .description {
    margin: 1.071rem auto 0;
    max-width: 600px;
    color: #999;
    font-weight: 300;
}

p {
    font-size: 14px;
    margin: 0 0 10px;
}

.profile-page .profile-tabs {
    margin-top: 4.284rem;
}

.nav-pills, .nav-tabs {
    border: 0;
    border-radius: 3px;
    padding: 0 15px;
}

.nav .nav-item {
    position: relative;
    margin: 0 2px;
}

.nav-pills.nav-pills-icons .nav-item .nav-link {
    border-radius: 4px;
}

.nav-pills .nav-item .nav-link.active {
    color: #fff;
    background-color: #9c27b0;
    box-shadow: 0 5px 20px 0 rgba(0,0,0,.2), 0 13px 24px -11px rgba(156,39,176,.6);
}

.nav-pills .nav-item .nav-link {
    line-height: 24px;
    font-size: 12px;
    font-weight: 500;
    min-width: 100px;
    color: #555;
    transition: all .3s;
    border-radius: 30px;
    padding: 10px 15px;
    text-align: center;
}

.nav-pills .nav-item .nav-link:not(.active):hover {
    background-color: rgba(200,200,200,.2);
}


.nav-pills .nav-item i {
    display: block;
    font-size: 30px;
    padding: 15px 0;
}

.tab-space {
    padding: 20px 0 50px;
}

.profile-page .gallery {
    margin-top: 3.213rem;
    padding-bottom: 50px;
}

.profile-page .gallery img {
    width: 100%;
    margin-bottom: 2.142rem;
}

.profile-page .profile .name{
    margin-top: -80px;
}

img.rounded {
    border-radius: 6px!important;
}

.tab-content>.active {
    display: block;
}

/*buttons*/
.btn {
    position: relative;
    padding: 12px 30px;
    margin: .3125rem 1px;
    font-size: .75rem;
    font-weight: 400;
    line-height: 1.428571;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0;
    border: 0;
    border-radius: .2rem;
    outline: 0;
    transition: box-shadow .2s cubic-bezier(.4,0,1,1),background-color .2s cubic-bezier(.4,0,.2,1);
    will-change: box-shadow,transform;
}

.btn.btn-just-icon {
    font-size: 20px;
    height: 41px;
    min-width: 41px;
    width: 41px;
    padding: 0;
    overflow: hidden;
    position: relative;
    line-height: 41px;
}

.btn.btn-just-icon fa{
    margin-top: 0;
    position: absolute;
    width: 100%;
    transform: none;
    left: 0;
    top: 0;
    height: 100%;
    line-height: 41px;
    font-size: 20px;
}
.btn.btn-link{
    background-color: transparent;
    color: #999;
}

/* dropdown */




.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    float: left;
    min-width: 11rem !important;
    margin: .125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: left;
    background-color: #fff;
    background-clip: padding-box;
    border-radius: .25rem;
    transition: transform .3s cubic-bezier(.4,0,.2,1),opacity .2s cubic-bezier(.4,0,.2,1);
}

.dropdown-menu.show{
    transition: transform .3s cubic-bezier(.4,0,.2,1),opacity .2s cubic-bezier(.4,0,.2,1);
}


.dropdown-menu .dropdown-item:focus, .dropdown-menu .dropdown-item:hover, .dropdown-menu a:active, .dropdown-menu a:focus, .dropdown-menu a:hover {
    box-shadow: 0 4px 20px 0 rgba(0,0,0,.14), 0 7px 10px -5px rgba(156,39,176,.4);
    background-color: #9c27b0;
    color: #FFF;
}
.show .dropdown-toggle:after {
    transform: rotate(180deg);
}

.dropdown-toggle:after {
    will-change: transform;
    transition: transform .15s linear;
}


.dropdown-menu .dropdown-item, .dropdown-menu li>a {
    position: relative;
    width: auto;
    display: flex;
    flex-flow: nowrap;
    align-items: center;
    color: #333;
    font-weight: 400;
    text-decoration: none;
    font-size: .8125rem;
    border-radius: .125rem;
    margin: 0 .3125rem;
    transition: all .15s linear;
    min-width: 7rem;
    padding: 0.625rem 1.25rem;
    min-height: 1rem !important;
    overflow: hidden;
    line-height: 1.428571;
    text-overflow: ellipsis;
    word-wrap: break-word;
}

.dropdown-menu.dropdown-with-icons .dropdown-item {
    padding: .75rem 1.25rem .75rem .75rem;
}

.dropdown-menu.dropdown-with-icons .dropdown-item .material-icons {
    vertical-align: middle;
    font-size: 24px;
    position: relative;
    margin-top: -4px;
    top: 1px;
    margin-right: 12px;
    opacity: .5;
}

/* footer */

footer{
    margin-top: 10px;
    color: #555;
    padding: 25px;
    font-weight: 300;
    
}
.footer p{
    margin-bottom: 0;
    font-size: 14px;
    margin: 0 0 10px;
    font-weight: 300;
}
footer p a{
    color: #555;
    font-weight: 400;
}

footer p a:hover {
    color: #9f26aa;
    text-decoration: none;
}
.box{
     background: none !important; 
    border-top: none !important;
}
.nav-link>active{
    background-color: #9c27b0;
    color: white;
    box-shadow: 0 5px 20px 0 rgba(0,0,0,.2), 0 13px 24px -11px rgba(156,39,176,.6);
}
.badgebox
{
    opacity: 0;
}

.badgebox + .badge
{
    /* Move the check mark away when unchecked */
    text-indent: -999999px;
    /* Makes the badge's width stay the same checked and unchecked */
  width: 27px;


}
.wrapper {
  margin-right: auto; /* 1 */
  margin-left:  auto; /* 1 */

  max-width: 960px; /* 2 */

  padding-right: 10px; /* 3 */
  padding-left:  10px; /* 3 */
}
.badgebox:focus + .badge
{
    /* Set something to make the badge looks focused */
    /* This really depends on the application, in my case it was: */
    
    /* Adding a light border */
    box-shadow: inset 0px 0px 5px;
     Taking the difference out of the padding 
}

.badgebox:checked + .badge
{
    /* Move the check mark back when checked */
  text-indent: 0;
}
</style>

</head>
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="text-decoration: none;"></h1>
    </section>

    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            
        <form action="{{ url('BookTrainer')}}" role="form" method="post" class="form-horizontal" enctype="multipart/form-data">
            {{csrf_field()}}
            
            <div class="col-md-12">
                <div class="row">
                    <div class="box box-info">
                        <!-- /.box-header -->
                        <div class="box-body">

                            @if($trainerprofile->trainerphoto) @php $photo=$trainerprofile->trainerphoto;@endphp @else @php $photo='default.png';@endphp @endif
                         
                            <input type="hidden" name="trainerid" value="{{request()->route('id')}}">
                            
                            @php
                            if(session()->has('mobileno'))
                            {
                               $mobileno = session('mobileno');
                            }
                            @endphp
                            <input type="hidden" name="mobileno" value="{{$mobileno}}">
                            <div class="profile-page">

                                <div class="page-header" data-parallax="true" style="background-image: url('/images/fitness5back.jpg');"></div>

                                <div class="main main-raised">
                                    <div class="profile-content">
                                        <div class="container">
                                            <center>
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-10">
                                                        <div class="profile">
                                                            <div class="avatar">
                                                                <img src="{{url('/files/'.$photo)}}" alt="Circle Image" class="img-raised rounded-circle img-fluid" style="height:150px;">
                                                            </div>
                                                            <div class="name">
                                                                <h3 class="title">{{ ucfirst($trainerprofile->first_name)}} {{ucfirst($trainerprofile->last_name)}} {{ '(' . $trainerprofile->username .')' }}</h3>
                                                                <h4 class="title"> </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </center>
                                            <div class="row">
                                                <center>
                                                    <div class="col-xs-12 col-sm-8 col-lg-10 col-10 col-md-8 col-md-offset-1 col-md-offset-0 col-xl-offset-1 ">
                                                        <div class="nav-tabs-custom">
                                                            <center>
                                                                <ul class="nav nav-tabs nav-justified">

                                                                    <li class="active"><a href="#about" data-toggle="tab" aria-expanded="true">About</a></li>
                                                                    <li class=""><a href="#freeslots" data-toggle="tab" aria-expanded="true">Available Slot</a></li>
                                                                    <li class=""><a href="#results" data-toggle="tab" aria-expanded="false">Results</a></li>
                                                                </ul>
                                                            </center>
                                                            <div class="tab-content">
                                                                <div class="tab-pane active" id="about">
                                                                    <div class="form-horizontal">
                                                                        <br>
                                                                        <div class="form-group">
                                                                            <label for="City" class="col-sm-4 control-label">City</label>
                                                                            <div class="col-sm-8">
                                                                                <input id="City" type="text" readonly="" value="{{$trainerprofile->trainercity}}" name="city" class="form-control">

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group justify-content-left">
                                                                            <label for="City" class="col-sm-4 control-label">Level Of Trainer</label>
                                                                            <div class="col-sm-8">
                                                                                <input id="City" type="text" readonly="" value="{{$trainerprofile->   leveloftrainer}}" name="city" class="form-control">

                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="City" class="col-sm-4 control-label">Experience</label>
                                                                            <div class="col-sm-8">
                                                                                <input id="City" type="text" readonly="" value="{{$trainerprofile->exp}}" name="city" class="form-control">

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="City" class="col-sm-4 control-label">Achievments</label>
                                                                            <div class="col-sm-8">
                                                                                <input id="City" type="text" readonly="" value="{{$trainerprofile->   achievments}}" name="city" class="form-control">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane" id="freeslots">
                                                                    @php $array=explode(',',$trainerprofile->freeslots); @endphp 
                                                                    @if(count($array)>1) 
                                                                        @foreach($array as $ar)
                                                                        <label class="btn btn-default margin"> {{$ar}}
                                                                            <input type="checkbox" name="slots[]" value="{{$ar}}" class="badgebox">
                                                                            <span class="badge bg-orange">&check;</span>
                                                                        </label>
                                                                        @endforeach 
                                                                    @endif
                                                                </div>
                                                                <div class="tab-pane" id="results">
                                                                    @if($trainerprofile->results)
                                                                    <center>
                                                                        <tr>
                                                                            @php $img= json_decode($trainerprofile->results); @endphp @foreach($img as $img1)

                                                                            <td><img src="/files/{{$img1}}" target="_blank" height="100px;" width="100px;"></td>
                                                                            @endforeach </tr>
                                                                        @else {{ 'Not Uploaded' }} 
                                                                    </center>
                                                                    @endif
                                                            </div>
                                                            <!-- /.tab-pane -->
                                                        </div>
                                                        <!-- /.tab-content -->
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-6 col-sm-6">
                                                            <button name="add" type="submit" id="add" class="btn btn-success"></span> Book Trainer
                                                            </button>
                                                        </div>
                                                    </div>
                                                        <!-- /.nav-tabs-custom -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        </div>
    </section>
</div>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

@endsection