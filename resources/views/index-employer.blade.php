@extends('layouts.main')
@section('content')
<!-- Content -->
<div class="page-content">
<!-- Section Banner -->
<div class="content-inner-1 main-bnr emp-hero-banner">
    <div class="bg-circle-bx"></div>
    <div class="container">
        <div class="row" style="justify-content: space-between;">
            <div class="col-lg-7">
                <div class="banner-content ">
                    <h1> <span class="text-primary">Recruit Smarter:</span>  <br> Your Gateway to Top Talent.</h1>                         
                    <a href="{{ session()->has('emp_username') ?  route('post-job') :  route('emp_login')}}">
                        <button class="site-button style-1" type="button"><b>Post a Job for Free*</b></button>
                    </a>
                </div>	
                
            </div>
            <div class="col-lg-5 mb-3">
                <div class="banner-media">
                    <div class="banner-main-media banner-main-media-emp">
                        <img src="{{ asset("images/employer-hero-section.png") }}"  alt="">
                        
                    </div>
                    {{-- <div class="banner-media-bg">
                        <div class="bnr-circle1">
                            <img src="images/banner/microsoft.svg" class="banner-icon1" alt="">
                        </div>
                        <div class="bnr-circle2">
                            <img src="images/banner/google.svg" class="banner-icon1" alt="">
                            <img src="images/banner/logo.svg" class="banner-icon2" alt="">
                            <img src="images/banner/amazon.svg" class="banner-icon3" alt="">
                        </div>
                        <div class="bnr-circle3"></div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="back-circle"></div>
    <div class="back-circle2"></div>
</div>
<!-- Section Banner END -->


<!-- Partners -->
<div class="section-full content-inner-partner-1 partners bg-white style-1">
    <div class="container">
        <div class="our-partners item-center owl-loaded owl-theme owl-carousel owl-none mfp-gallery owl-dots-none">
            <div class="item">
                <a href="javascript:void(0);" class="partners-media">
                    <img src="{{ asset("images/libani-logo-01.png") }}" alt=""> 
                </a>
            </div>
            <div class="item">
                <a href="javascript:void(0);" class="partners-media">
                    <img src="{{ asset("images/desifood-01.png") }}" alt="">
                </a>
            </div>
            <div class="item">
                <a href="javascript:void(0);" class="partners-media">
                    <img src="{{ asset("images/angel-portal-logo-01.png") }}" alt="">
                </a>
            </div>
            <div class="item">
                <a href="javascript:void(0);" class="partners-media">
                    <img src="{{ asset("images/angel-gulf-jobs-01.png") }}" alt="">
                </a>
            </div>
            <div class="item">
                <a href="javascript:void(0);" class="partners-media">
                    <img src="{{ asset("images/oliasi-spain-01.png") }}" alt="">
                </a>
            </div>
            <div class="item">
                <a href="javascript:void(0);" class="partners-media">
                    <img src="{{ asset("images/oliasi-france-01.png") }}" alt="">
                </a>
            </div>
            <div class="item">
                <a href="javascript:void(0);" class="partners-media">
                    <img src="{{ asset("images/oliasi-malta-01.png") }}" alt="">
                </a>
            </div>
            
        </div>
    </div>
</div>
<!-- Partners End-->


		<!-- Latest jobs -->
		<div class="section-full latest-jobs content-inner-1 bg-white pb-5">
			<div class="container">
				<div class="latest-jobs-inner">
					<div class="section-head style-1">
						<h6>Candidates</h6>
						<h2 class="section-title-3">Featured Candidates</h2>
						<p class="dz-text-2">More Than 500+ Jobseekers Everyday</p>
					</div>
					{{-- <a href="javascript:void(0);" class="site-button style-1">Post a Job</a>	 --}}
				</div>
				<div class="row sp20 m-b20">
                    <div class="col-md-12">
                        <ul class="post-job-bx browse-job-grid post-resume row">
                            @php
                                $jsData = getData('jobseeker_view', ['fullname','role_name','company_name','prefered_location_name','expected_salary_name','pref_job_type_name','notice_name'], [], 6, 'updated_at', $order_dirc = 'DESC');
                            @endphp
                            @foreach ($jsData as $data)
                                
                         
                            <li class="col-lg-4 col-md-4">
                                <div class="post-bx">
                                    <div class="d-flex m-b20">
                                        <div class="job-post-info">
                                            <h5 class="m-b0"><a>{{ isset($data->fullname) ? $data->fullname : '' }}</a></h5>
                                            <p class="m-b5 font-13">
                                                <a class="text-primary">{{ isset($data->role_name) ? $data->role_name : 'Not Disclosed' }} </a>
                                                at {{ isset($data->company_name) ? $data->company_name : 'Not Disclosed' }}</p>
                                            <ul>
                                                <li><i class="fas fa-map-marker-alt"></i>{{ isset($data->prefered_location_name) ? $data->prefered_location_name : 'Not Disclosed' }}, Malta</li>
                                                <li><i class="far fa-money-bill-alt"></i> $ {{ isset($data->expected_salary_name) ? $data->expected_salary_name : 'Not Disclosed' }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="job-time m-t15 m-b10">
                                        <a><span>{{ isset($data->pref_job_type_name) ? $data->pref_job_type_name : 'Not Disclosed' }}</span></a>
                                        <a><span>{{ isset($data->notice_name) ? $data->notice_name : 'Not Disclosed' }}</span></a>
                                    </div>
                                    {{-- <a href="files/pdf-sample.pdf" target="blank" class="job-links">
                                        <i class="fa fa-download"></i>
                                    </a> --}}
                                </div>
                            </li>
                               @endforeach
                        </ul>
                    </div>
                </div>
				<div class="jobs-btn">
                    @if (session()->has('emp_username'))
                        <a href="{{ route('browse-jobseeker') }}" class="site-button style-1">All Candidates</a>
                    @else
                        <a href="{{ route('emp_login') }}" class="site-button style-1">All Candidates</a>
                    @endif
					
				</div>
			</div>
		</div>	
		<!-- Latest jobs END -->









</div>
<!-- Content END-->


<!-- Import footer  -->
@endsection()