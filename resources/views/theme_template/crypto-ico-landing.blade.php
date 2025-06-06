<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>ICO Landing | Skote - Responsive Bootstrap 4 Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">

        <!-- owl.carousel css -->
        <link rel="stylesheet" href="{{ URL::asset('assets/libs/owl.carousel/owl.carousel.min.css')}}">

        @include('layouts.head')

    </head>

    <body data-spy="scroll" data-target="#topnav-menu" data-offset="60">

        <nav class="navbar navbar-expand-lg navigation fixed-top sticky">
            <div class="container">
                <a class="navbar-logo" href="index.html">
                    <img src="assets/images/logo-dark.png" alt="" height="19" class="logo logo-dark">
                    <img src="assets/images/logo-light.png" alt="" height="19" class="logo logo-light">
                </a>

                <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
              
                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav ml-auto" id="topnav-menu" >
                        <li class="nav-item">
                            <a class="nav-link active" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#roadmap">Roadmap</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#team">Team</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#news">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#faqs">FAQs</a>
                        </li>

                    </ul>

                    <div class="ml-lg-2">
                        <a href="#" class="btn btn-outline-success w-xs">Sign in</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- hero section start -->
        <section class="section hero-section bg-ico-hero" id="home">
            <div class="bg-overlay bg-primary"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="text-white-50">
                            <h1 class="text-white font-weight-semibold mb-3 hero-title">Skote - Ico Landing for a cryptocurrency business</h1>
                            <p class="font-size-14">It will be as simple as occidental in fact to an English person, it will seem like simplified as a skeptical Cambridge</p>
                            
                            <div class="button-items mt-4">
                                <a href="#" class="btn btn-success">Get Whitepaper</a>
                                <a href="#" class="btn btn-light">How it work</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-8 col-sm-10 ml-lg-auto">
                        <div class="card overflow-hidden mb-0 mt-5 mt-lg-0">
                            <div class="card-header text-center">
                                <h5 class="mb-0">ICO Countdown time</h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    
                                    <h5>Time left to Ico :</h5>
                                    <div class="mt-4">
                                        <div data-countdown="2020/12/31" class="counter-number ico-countdown"></div>
                                    </div>

                                    <div class="mt-4">
                                        <button type="button" class="btn btn-success w-md">Get Token</button>
                                    </div>

                                    <div class="mt-5">
                                        <h4 class="font-weight-semibold">1 ETH = 2235 SKT</h4>
                                        <div class="clearfix mt-4">
                                            <h5 class="float-right font-size-14">5234.43</h5>
                                        </div>
                                        <div class="progress p-1 progress-xl softcap-progress">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-label">15 %</div>
                                            </div>
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-label">30 %</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- hero section end -->
        
        <!-- currency price section start -->
        <section class="section bg-white p-0">
            <div class="container">
                <div class="currency-price">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="avatar-xs mr-3">
                                            <span class="avatar-title rounded-circle bg-soft-warning text-warning font-size-18">
                                                <i class="mdi mdi-bitcoin"></i>
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <p class="text-muted">Bitcoin</p>
                                            <h5>$ 9134.39</h5>
                                            <p class="text-muted text-truncate mb-0">+ 0.0012.23 ( 0.2 % ) <i class="mdi mdi-arrow-up ml-1 text-success"></i></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="avatar-xs mr-3">
                                            <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                                <i class="mdi mdi-ethereum"></i>
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <p class="text-muted">Ethereum</p>
                                            <h5>$ 245.44</h5>
                                            <p class="text-muted text-truncate mb-0">- 004.12 ( 0.1 % ) <i class="mdi mdi-arrow-down ml-1 text-danger"></i></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="avatar-xs mr-3">
                                            <span class="avatar-title rounded-circle bg-soft-info text-info font-size-18">
                                                <i class="mdi mdi-litecoin"></i>
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <p class="text-muted">Litecoin</p>
                                            <h5>$ 63.61</h5>
                                            <p class="text-muted text-truncate mb-0">+ 0.0001.12 ( 0.1 % ) <i class="mdi mdi-arrow-up ml-1 text-success"></i></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
            <!-- end container -->
        </section>
        <!-- currency price section end -->

        <!-- about section start -->
        <section class="section pt-4 bg-white" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <div class="small-title">About us</div>
                            <h4>What is ICO Token?</h4>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-5">
  
                        <div class="text-muted">
                            <h4>Best ICO for your cryptocurrency business</h4>
                            <p>If several languages coalesce, the grammar of the resulting that of the individual new common language will be more simple and regular than the existing.</p>
                            <p class="mb-4">It would be necessary to have uniform pronunciation.</p>

                            <div class="button-items">
                                <a href="#" class="btn btn-success">Read More</a>
                                <a href="#" class="btn btn-outline-primary">How It work</a>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-lg-4 col-6">
                                    <div class="mt-4">
                                        <h4>$ 6.2 M</h4>
                                        <p>Invest amount</p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-6">
                                    <div class="mt-4">
                                        <h4>16245</h4>
                                        <p>Users</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 ml-auto">
                        <div class="mt-4 mt-lg-0">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <i class="mdi mdi-bitcoin h2 text-success"></i>
                                            </div>
                                            <h5>Lending</h5>
                                            <p class="text-muted mb-0">At vero eos et accusamus et iusto blanditiis</p>
        
                                        </div>
                                        <div class="card-footer bg-transparent border-top text-center">
                                            <a href="#" class="text-primary">Learn more</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card border mt-lg-5">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <i class="mdi mdi-wallet-outline h2 text-success"></i>
                                            </div>
                                            <h5>Wallet</h5>
                                            <p class="text-muted mb-0">Quis autem vel eum iure reprehenderit</p>
        
                                        </div>
                                        <div class="card-footer bg-transparent border-top text-center">
                                            <a href="#" class="text-primary">Learn more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <hr class="my-5">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="owl-carousel owl-theme clients-carousel" id="clients-carousel">
                            <div class="item">
                                <div class="client-images">
                                    <img src="assets/images/clients/1.png" alt="client-img" class="mx-auto img-fluid d-block">
                                </div>
                            </div>
                            <div class="item">
                                <div class="client-images">
                                    <img src="assets/images/clients/2.png" alt="client-img" class="mx-auto img-fluid d-block">
                                </div>
                            </div>
                            <div class="item">
                                <div class="client-images">
                                    <img src="assets/images/clients/3.png" alt="client-img" class="mx-auto img-fluid d-block">
                                </div>
                            </div>
                            <div class="item">
                                <div class="client-images">
                                    <img src="assets/images/clients/4.png" alt="client-img" class="mx-auto img-fluid d-block">
                                </div>
                            </div>
                            <div class="item">
                                <div class="client-images">
                                    <img src="assets/images/clients/5.png" alt="client-img" class="mx-auto img-fluid d-block">
                                </div>
                            </div>
                            <div class="item">
                                <div class="client-images">
                                    <img src="assets/images/clients/6.png" alt="client-img" class="mx-auto img-fluid d-block">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- about section end -->

        <!-- Features start -->
        <section class="section" id="features">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <div class="small-title">Features</div>
                            <h4>Key features of the product</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row align-items-center pt-4">
                    <div class="col-md-6 col-sm-8">
                        <div>
                            <img src="assets/images/crypto/features-img/img-1.png" alt="" class="img-fluid mx-auto d-block">
                        </div>
                    </div>
                    <div class="col-md-5 ml-auto">
                        <div class="mt-4 mt-md-auto">
                            <div class="d-flex align-items-center mb-2">
                                <div class="features-number font-weight-semibold display-4 mr-3">01</div>
                                <h4 class="mb-0">Lending</h4>
                            </div>
                            <p class="text-muted">If several languages coalesce, the grammar of the resulting language is more simple and regular than of the individual will be more simple and regular than the existing.</p>
                            <div class="text-muted mt-4">
                                <p class="mb-2"><i class="mdi mdi-circle-medium text-success mr-1"></i>Donec pede justo vel aliquet</p>
                                <p><i class="mdi mdi-circle-medium text-success mr-1"></i>Aenean et nisl sagittis</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row align-items-center mt-5 pt-md-5">
                    <div class="col-md-5">
                        <div class="mt-4 mt-md-0">
                            <div class="d-flex align-items-center mb-2">
                                <div class="features-number font-weight-semibold display-4 mr-3">02</div>
                                <h4 class="mb-0">Wallet</h4>
                            </div>
                            <p class="text-muted">It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend.</p>
                            <div class="text-muted mt-4">
                                <p class="mb-2"><i class="mdi mdi-circle-medium text-success mr-1"></i>Donec pede justo vel aliquet</p>
                                <p><i class="mdi mdi-circle-medium text-success mr-1"></i>Aenean et nisl sagittis</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6  col-sm-8 ml-md-auto">
                        <div class="mt-4 mr-md-0">
                            <img src="assets/images/crypto/features-img/img-2.png" alt="" class="img-fluid mx-auto d-block">
                        </div>
                    </div>
                    
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- Features end -->

        <!-- Roadmap start -->
        <section class="section bg-white" id="roadmap">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <div class="small-title">Timeline</div>
                            <h4>Our Roadmap</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="hori-timeline">
                            <div class="owl-carousel owl-theme events navs-carousel" id="timeline-carousel">
                                <div class="item event-list">
                                    <div>
                                        <div class="event-date">
                                            <div class="text-primary mb-1">December, 2019</div>
                                            <h5 class="mb-4">ICO Platform Idea</h5>
                                        </div>
                                        <div class="event-down-icon">
                                            <i class="bx bx-down-arrow-circle h1 text-primary down-arrow-icon"></i>
                                        </div>

                                        <div class="mt-3 px-3">
                                            <p class="text-muted">It will be as simple as occidental in fact it will be Cambridge</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="item event-list">
                                    <div>
                                        <div class="event-date">
                                            <div class="text-primary mb-1">January, 2020</div>
                                            <h5 class="mb-4">Research on project</h5>
                                        </div>
                                        <div class="event-down-icon">
                                            <i class="bx bx-down-arrow-circle h1 text-primary down-arrow-icon"></i>
                                        </div>

                                        <div class="mt-3 px-3">
                                            <p class="text-muted">To an English person, it will seem like simplified English existence.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="item event-list active">
                                    <div>
                                        <div class="event-date">
                                            <div class="text-primary mb-1">February, 2020</div>
                                            <h5 class="mb-4">ICO & Token Design</h5>
                                        </div>
                                        <div class="event-down-icon">
                                            <i class="bx bx-down-arrow-circle h1 text-primary down-arrow-icon"></i>
                                        </div>

                                        <div class="mt-3 px-3">
                                            <p class="text-muted">For science, music, sport, etc, Europe uses the same vocabulary.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="item event-list">
                                    <div>
                                        <div class="event-date">
                                            <div class="text-primary mb-1">March, 2020</div>
                                            <h5 class="mb-4">ICO Launch Platform</h5>
                                        </div>
                                        <div class="event-down-icon">
                                            <i class="bx bx-down-arrow-circle h1 text-primary down-arrow-icon"></i>
                                        </div>

                                        <div class="mt-3 px-3">
                                            <p class="text-muted">New common language will be more simple than existing.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="item event-list">
                                    <div>
                                        <div class="event-date">
                                            <div class="text-primary mb-1">April, 2020</div>
                                            <h5 class="mb-4">Token sale round 1</h5>
                                        </div>
                                        <div class="event-down-icon">
                                            <i class="bx bx-down-arrow-circle h1 text-primary down-arrow-icon"></i>
                                        </div>

                                        <div class="mt-3 px-3">
                                            <p class="text-muted">It will be as simple as occidental in fact it will be Cambridge</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="item event-list">
                                    <div>
                                        <div class="event-date">
                                            <div class="text-primary mb-1">May, 2020</div>
                                            <h5 class="mb-4">Token sale round 2</h5>
                                        </div>
                                        <div class="event-down-icon">
                                            <i class="bx bx-down-arrow-circle h1 text-primary down-arrow-icon"></i>
                                        </div>

                                        <div class="mt-3 px-3">
                                            <p class="text-muted">To an English person, it will seem like simplified English existence.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- Roadmap end -->

        <!-- Team start -->
        <section class="section" id="team">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <div class="small-title">Team</div>
                            <h4>Meet our team</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="col-lg-12">
                    <div class="owl-carousel owl-theme events navs-carousel" id="team-carousel">
                        <div class="item">
                            <div class="card text-center team-box">
                                <div class="card-body">
                                    <div>
                                        <img src="assets/images/users/avatar-2.jpg" alt="" class="rounded">
                                    </div>
    
                                    <div class="mt-3">
                                        <h5>Mark Hurley</h5>
                                        <P class="text-muted mb-0">CEO & Lead</P>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top">
                                    <div class="d-flex mb-0 team-social-links">
                                        <div class="flex-fill">
                                            <a href="#" data-toggle="tooltip" title="Facebook">
                                                <i class="mdi mdi-facebook"></i>
                                            </a>
                                        </div>
                                        <div class="flex-fill">
                                            <a href="#" data-toggle="tooltip" title="Linkedin">
                                                <i class="mdi mdi-linkedin"></i>
                                            </a>
                                        </div>
                                        <div class="flex-fill">
                                            <a href="#" data-toggle="tooltip" title="Google">
                                                <i class="mdi mdi-google"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card text-center team-box">
                                <div class="card-body">
                                    <div>
                                        <img src="assets/images/users/avatar-3.jpg" alt="" class="rounded">
                                    </div>
    
                                    <div class="mt-3">
                                        <h5>Calvin Smith</h5>
                                        <P class="text-muted mb-0">Blockchain developer</P>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top">
                                    <div class="d-flex mb-0 team-social-links">
                                        <div class="flex-fill">
                                            <a href="#" data-toggle="tooltip" title="Facebook">
                                                <i class="mdi mdi-facebook"></i>
                                            </a>
                                        </div>
                                        <div class="flex-fill">
                                            <a href="#" data-toggle="tooltip" title="Linkedin">
                                                <i class="mdi mdi-linkedin"></i>
                                            </a>
                                        </div>
                                        <div class="flex-fill">
                                            <a href="#" data-toggle="tooltip" title="Google">
                                                <i class="mdi mdi-google"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card text-center team-box">
                                <div class="card-body">
                                    <div>
                                        <img src="assets/images/users/avatar-8.jpg" alt="" class="rounded">
                                    </div>
                                    <div class="mt-3">
                                        <h5>Vickie Sample</h5>
                                        <P class="text-muted mb-0">Designer</P>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top">
                                    <div class="d-flex mb-0 team-social-links">
                                        <div class="flex-fill">
                                            <a href="#" data-toggle="tooltip" title="Facebook">
                                                <i class="mdi mdi-facebook"></i>
                                            </a>
                                        </div>
                                        <div class="flex-fill">
                                            <a href="#" data-toggle="tooltip" title="Linkedin">
                                                <i class="mdi mdi-linkedin"></i>
                                            </a>
                                        </div>
                                        <div class="flex-fill">
                                            <a href="#" data-toggle="tooltip" title="Google">
                                                <i class="mdi mdi-google"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card text-center team-box">
                                <div class="card-body">
                                    <div>
                                        <img src="assets/images/users/avatar-5.jpg" alt="" class="rounded">
                                    </div>
    
                                    <div class="mt-3">
                                        <h5>Alma Farley</h5>
                                        <P class="text-muted mb-0">App developer</P>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top">
                                    <div class="d-flex mb-0 team-social-links">
                                        <div class="flex-fill">
                                            <a href="#" data-toggle="tooltip" title="Facebook">
                                                <i class="mdi mdi-facebook"></i>
                                            </a>
                                        </div>
                                        <div class="flex-fill">
                                            <a href="#" data-toggle="tooltip" title="Linkedin">
                                                <i class="mdi mdi-linkedin"></i>
                                            </a>
                                        </div>
                                        <div class="flex-fill">
                                            <a href="#" data-toggle="tooltip" title="Google">
                                                <i class="mdi mdi-google"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="card text-center team-box">
                                <div class="card-body">
                                    <div>
                                        <img src="assets/images/users/avatar-1.jpg" alt="" class="rounded">
                                    </div>
    
                                    <div class="mt-3">
                                        <h5>Amy Hood </h5>
                                        <P class="text-muted mb-0">Designer</P>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top">
                                    <div class="d-flex mb-0 team-social-links">
                                        <div class="flex-fill">
                                            <a href="#" data-toggle="tooltip" title="Facebook">
                                                <i class="mdi mdi-facebook"></i>
                                            </a>
                                        </div>
                                        <div class="flex-fill">
                                            <a href="#" data-toggle="tooltip" title="Linkedin">
                                                <i class="mdi mdi-linkedin"></i>
                                            </a>
                                        </div>
                                        <div class="flex-fill">
                                            <a href="#" data-toggle="tooltip" title="Google">
                                                <i class="mdi mdi-google"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- Team end -->

        <!-- Blog start -->
        <section class="section bg-white" id="news">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <div class="small-title">Blog</div>
                            <h4>Latest News</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-4 col-sm-6">
                        <div class="blog-box mb-4 mb-xl-0">
                            <div class="position-relative">
                                <img src="assets/images/crypto/blog/img-1.jpg" alt="" class="rounded img-fluid mx-auto d-block">
                                <div class="badge badge-success blog-badge font-size-11">Cryptocurrency</div>
                            </div>

                            <div class="mt-4 text-muted">
                                <p class="mb-2"><i class="bx bx-calendar mr-1"></i> 04 Mar, 2020</p>
                                <h5 class="mb-3">Donec pede justo, fringilla vele</h5>
                                <p>If several languages coalesce, the grammar of the resulting language</p>
    
                                <div>
                                    <a href="#">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-sm-6">
                        <div class="blog-box mb-4 mb-xl-0">

                            <div class="position-relative">
                                <img src="assets/images/crypto/blog/img-2.jpg" alt="" class="rounded img-fluid mx-auto d-block">
                                <div class="badge badge-success blog-badge font-size-11">Cryptocurrency</div>
                            </div>

                            <div class="mt-4 text-muted">
                                <p class="mb-2"><i class="bx bx-calendar mr-1"></i> 12 Feb, 2020</p>
                                <h5 class="mb-3">Aenean ut eros et nisl</h5>
                                <p>Everyone realizes why a new common language would be desirable</p>

                                <div>
                                    <a href="#">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-sm-6">
                        <div class="blog-box mb-4 mb-xl-0">
                            <div class="position-relative">
                                <img src="assets/images/crypto/blog/img-3.jpg" alt="" class="rounded img-fluid mx-auto d-block">
                                <div class="badge badge-success blog-badge font-size-11">Cryptocurrency</div>
                            </div>

                            <div class="mt-4 text-muted">
                                <p class="mb-2"><i class="bx bx-calendar mr-1"></i> 06 Jan, 2020</p>
                                <h5 class="mb-3">In turpis, pellentesque posuere</h5>
                                <p>To an English person, it will seem like simplified English, as a skeptical Cambridge</p>

                                <div>
                                    <a href="#">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- Blog end -->
        
        <!-- Faqs start -->
        <section class="section" id="faqs">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <div class="small-title">FAQs</div>
                            <h4>Frequently asked questions</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="vertical-nav">
                            <div class="row">
                                <div class="col-lg-2 col-sm-4">
                                    <div class="nav flex-column nav-pills" role="tablist">
                                        <a class="nav-link active" id="v-pills-gen-ques-tab" data-toggle="pill" href="#v-pills-gen-ques" role="tab">
                                            <i class= "bx bx-help-circle nav-icon d-block mb-2"></i>
                                            <p class="font-weight-bold mb-0">General Questions</p>
                                        </a>
                                        <a class="nav-link" id="v-pills-token-sale-tab" data-toggle="pill" href="#v-pills-token-sale" role="tab"> 
                                            <i class= "bx bx-receipt nav-icon d-block mb-2"></i>
                                            <p class="font-weight-bold mb-0">Token sale</p>
                                        </a>
                                        <a class="nav-link" id="v-pills-roadmap-tab" data-toggle="pill" href="#v-pills-roadmap" role="tab">
                                            <i class= "bx bx-timer d-block nav-icon mb-2"></i>
                                            <p class="font-weight-bold mb-0">Roadmap</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-sm-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="v-pills-gen-ques" role="tabpanel">
                                                    <h4 class="card-title mb-4">General Questions</h4>
                                                    
                                                    <div>
                                                        <div id="gen-ques-accordion" class="accordion custom-accordion">
                                                            <div class="mb-3">
                                                                <a href="#general-collapseOne" class="accordion-list" data-toggle="collapse"
                                                                                                aria-expanded="true"
                                                                                                aria-controls="general-collapseOne">
                                                                    
                                                                    <div>What is Lorem Ipsum ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                    
                                                                </a>
                                        
                                                                <div id="general-collapseOne" class="collapse show" data-parent="#gen-ques-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
            
                                                            <div class="mb-3">
                                                                <a href="#general-collapseTwo" class="accordion-list collapsed" data-toggle="collapse"
                                                                                aria-expanded="false"
                                                                                aria-controls="general-collapseTwo">
                                                                    <div>Why do we use it ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="general-collapseTwo" class="collapse" data-parent="#gen-ques-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages.</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <a href="#general-collapseThree" class="accordion-list collapsed" data-toggle="collapse"
                                                                                aria-expanded="false"
                                                                                aria-controls="general-collapseThree">
                                                                    <div>Where does it come from ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="general-collapseThree" class="collapse" data-parent="#gen-ques-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental.</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <a href="#general-collapseFour" class="accordion-list collapsed" data-toggle="collapse"
                                                                                aria-expanded="false"
                                                                                aria-controls="general-collapseFour">
                                                                    <div>Where can I get some ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="general-collapseFour" class="collapse" data-parent="#gen-ques-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="v-pills-token-sale" role="tabpanel">
                                                    <h4 class="card-title mb-4">Token sale</h4>
                                                        
                                                    <div>
                                                        <div id="token-accordion" class="accordion custom-accordion">
                                                            <div class="mb-3">
                                                                <a href="#token-collapseOne" class="accordion-list collapsed" data-toggle="collapse"
                                                                                aria-expanded="false"
                                                                                aria-controls="token-collapseOne">
                                                                    <div>Why do we use it ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="token-collapseOne" class="collapse" data-parent="#token-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages.</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <a href="#token-collapseTwo" class="accordion-list" data-toggle="collapse"
                                                                                                aria-expanded="true"
                                                                                                aria-controls="token-collapseTwo">
                                                                    
                                                                    <div>What is Lorem Ipsum ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                    
                                                                </a>
                                        
                                                                <div id="token-collapseTwo" class="collapse show" data-parent="#token-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
            
                                                            <div class="mb-3">
                                                                <a href="#token-collapseThree" class="accordion-list collapsed" data-toggle="collapse"
                                                                                aria-expanded="false"
                                                                                aria-controls="token-collapseThree">
                                                                    <div>Where can I get some ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="token-collapseThree" class="collapse" data-parent="#token-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <a href="#token-collapseFour" class="accordion-list collapsed" data-toggle="collapse"
                                                                                aria-expanded="false"
                                                                                aria-controls="token-collapseFour">
                                                                    <div>Where does it come from ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="token-collapseFour" class="collapse" data-parent="#token-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental.</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="v-pills-roadmap" role="tabpanel">
                                                    <h4 class="card-title mb-4">Roadmap</h4>
                                                        
                                                    <div>
                                                        <div id="roadmap-accordion" class="accordion custom-accordion">

                                                            <div class="mb-3">
                                                                <a href="#roadmap-collapseOne" class="accordion-list" data-toggle="collapse"
                                                                                                aria-expanded="true"
                                                                                                aria-controls="roadmap-collapseOne">
                                                                    


                                                                    <div>Where can I get some ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                    
                                                                </a>
                                        
                                                                <div id="roadmap-collapseOne" class="collapse show" data-parent="#roadmap-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <a href="#roadmap-collapseTwo" class="accordion-list collapsed" data-toggle="collapse"
                                                                                aria-expanded="false"
                                                                                aria-controls="roadmap-collapseTwo">
                                                                    <div>What is Lorem Ipsum ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="roadmap-collapseTwo" class="collapse" data-parent="#roadmap-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages.</p>
                                                                    </div>
                                                                </div>
                                                            </div>


            
                                                            <div class="mb-3">
                                                                <a href="#roadmap-collapseThree" class="accordion-list collapsed" data-toggle="collapse"
                                                                                aria-expanded="false"
                                                                                aria-controls="roadmap-collapseThree">
                                                                    <div>Why do we use it ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="roadmap-collapseThree" class="collapse" data-parent="#roadmap-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <a href="#roadmap-collapseFour" class="accordion-list collapsed" data-toggle="collapse"
                                                                                aria-expanded="false"
                                                                                aria-controls="roadmap-collapseFour">
                                                                    <div>Where does it come from ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="roadmap-collapseFour" class="collapse" data-parent="#roadmap-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental.</p>
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
                            </div>
                        </div>
                        <!-- end vertical nav -->
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- Faqs end -->
        

        <!-- Footer start -->
        <footer class="landing-footer">
            <div class="container">

                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="mb-4 mb-lg-0">
                            <h5 class="mb-3 footer-list-title">Company</h5>
                            <ul class="list-unstyled footer-list-menu">
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Features</a></li>
                                <li><a href="#">Team</a></li>
                                <li><a href="#">News</a></li>
                                <li><a href="#">FAQs</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="mb-4 mb-lg-0">
                            <h5 class="mb-3 footer-list-title">Resources</h5>
                            <ul class="list-unstyled footer-list-menu">
                                <li><a href="#">Whitepaper</a></li>
                                <li><a href="#">Token sales</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="mb-4 mb-lg-0">
                            <h5 class="mb-3 footer-list-title">Links</h5>
                            <ul class="list-unstyled footer-list-menu">
                                <li><a href="#">Tokens</a></li>
                                <li><a href="#">Roadmap</a></li>
                                <li><a href="#">FAQs</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="mb-4 mb-lg-0">
                            <h5 class="mb-3 footer-list-title">Latest News</h5>
                            <div class="blog-post">
                                <a href="#" class="post">
                                    <div class="badge badge-soft-success font-size-11 mb-3">Cryptocurrency</div>
                                    <h5 class="post-title">Donec pede justo aliquet nec</h5>
                                    <p class="mb-0"><i class="bx bx-calendar mr-1"></i> 04 Mar, 2020</p>
                                </a>
                                <a href="#" class="post">
                                    <div class="badge badge-soft-success font-size-11 mb-3">Cryptocurrency</div>
                                    <h5 class="post-title">In turpis, Pellentesque</h5>
                                    <p class="mb-0"><i class="bx bx-calendar mr-1"></i> 12 Mar, 2020</p>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <hr class="footer-border my-5">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <img src="assets/images/logo-light.png" alt="" height="20">
                        </div>
    
                        <p class="mb-2">2020 © Skote. Design & Develop by Themesbrand</p>
                        <p>It will be as simple as occidental in fact, it will be to an english person, it will seem like simplified English, as a skeptical</p>
                    </div>

                </div>
            </div>
            <!-- end container -->
        </footer>
        <!-- Footer end -->

        <!-- JAVASCRIPT -->
        <script src="{{ URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/metismenu/metismenu.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/node-waves/node-waves.min.js')}}"></script>

        <script src="{{ URL::asset('assets/libs/jquery.easing/jquery.easing.min.js')}}"></script>

        <!-- Plugins js-->
        <script src="{{ URL::asset('assets/libs/jquery-countdown/jquery-countdown.min.js')}}"></script>

        <!-- owl.carousel js -->
        <script src="{{ URL::asset('assets/libs/owl.carousel/owl.carousel.min.js')}}"></script>

        <!-- ICO landing init -->
        <script src="{{ URL::asset('assets/js/pages/ico-landing.init.js')}}"></script>

        <script src="{{ URL::asset('assets/js/app.min.js')}}"></script>

    </body>
</html>
