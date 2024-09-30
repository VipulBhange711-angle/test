
@extends('layouts.main')
@section('content')

    <!-- Content -->
    <div class="page-content bg-white">
    <!-- contact area -->
        <div class="content-block">
			<!-- Browse Jobs -->
			<div class="section-full bg-white p-t50 p-b20">
				<div class="container">
					<div class="row">
						{{-- Left Menu --}}
						<div class="col-xl-3 col-lg-4 m-b30">
							@include('layouts/employer-left-menu')
						</div>
						{{-- Left Menu end --}}
						<div class="col-xl-9 col-lg-8 m-b30">
							<div class="job-bx clearfix">
								<div class="job-bx-title clearfix">
									<h5 class="font-weight-700 float-start text-uppercase">Applied Jobseekers</h5>
									{{-- <a href="#" class="site-button button-sm float-end"><i class="fas fa-pencil-alt m-r5"></i> Edit</a> --}}
								</div>
								<ul class="post-job-bx browse-job-grid post-resume row">
									{{-- @if (!empty($appiedData) && is_array($appiedData)) --}}
									@foreach ($appliedData as $appliedDatas)
									@php
										$js_id =base64_encode($appliedDatas->js_id);
										$job_id =base64_encode($appliedDatas->job_id);
										$action =base64_encode('Yes');
									@endphp
									<li class="col-lg-12 col-md-12">
										<div class="post-bx">
											<div class="d-flex m-b20">
												<div class="jobseeker-photo-for-applied">
														<span>
														@if (isset($appliedDatas->profile_img) && !empty($appliedDatas->profile_img))
															<img alt="" src="{{ Storage::url('jobseeker/profile_image/'.$appliedDatas->profile_img)}}">
														@else
															<img alt="" src="{{ Storage::url('no-image.jpg')}}">
														@endif
														</span>
												</div>
												<div class="job-post-info">
													<h5 class="m-b0"><a href="{{ route('emp-js-view', $js_id)}}" target="_blank">{{$appliedDatas->fullname}}</a></h5>
													<ul>
														<li><i class="fa fa-briefcase"></i>Job Title: {{$appliedDatas->job_title}}</li>
													</ul>
													<ul>
														<li><i class="fa fa-user"></i>Joining : {{ isset($appliedDatas->notice_name) ?$appliedDatas->notice_name : 'NA'}}</li>
													</ul>
													<ul>
														<li><i class="fa fa-file-alt"></i>Applied On : {{ isset($appliedDatas->applied_on) ?$appliedDatas->applied_on : 'NA'}}</li>
													</ul>
												</div>
											</div>
											<div class="job-time m-t15 m-b10">
												<a href="{{ route('emp-js-view', $js_id)}}"><span>Show Jobseeker Details</span></a>
												@if ($appliedDatas->is_shortlisted==='No')
													<a href="javascript:void(0);" data-js_id="{{$js_id}}" data-short_action="{{$action}}" data-job_id="{{$job_id}}" class="shortlist"><span>Add to Shortlist</span></a>
												@else
													<a href="javascript:void(0);" ><span>Shortlisted</span></a>
												@endif
												
											</div>
											{{-- <a href="files/pdf-sample.pdf" target="blank" class="job-links">
												<i class="fa fa-download"></i>
											</a> --}}
										</div>
									</li>
							@endforeach
									{{-- @else
									<li class="col-lg-12 col-md-12">
										<div class="post-bx">
											<div class="d-flex m-b20">
												<div class="jobseeker-photo-for-applied">
													<a href="javascript:void(0);">
														<span>
															<img alt="" src="{{ asset('images/logo/icon2.png')}}">
														</span>
													</a>
												</div>
												<div class="job-post-info">
													<h5 class="m-b0"><a href="#">Application Not Recieved</a></h5>

													<ul>
														{{-- <li><i class="fa fa-briefcase"></i>Job Title: {{$appliedDatas->job_title}}</li> --}}
													</ul>
												</div>
											</div>
											
											{{-- <a href="files/pdf-sample.pdf" target="blank" class="job-links">
												<i class="fa fa-download"></i>
											</a> --}}
										{{-- </div>
									</li>
										 --}}
									{{-- @endif  --}}
								</ul>
								{{-- <div class="pagination-bx float-end">
									<ul class="pagination">
										<li class="previous"><a href="javascript:void(0);"><i class="ti-arrow-left"></i> Prev</a></li>
										<li class="active"><a href="javascript:void(0);">1</a></li>
										<li><a href="javascript:void(0);">2</a></li>
										<li><a href="javascript:void(0);">3</a></li>
										<li class="next"><a href="javascript:void(0);">Next <i class="ti-arrow-right"></i></a></li>
									</ul>
								</div> --}}
							</div>
						</div>
					</div>
				</div>
			</div>
            <!-- Browse Jobs END -->
		</div>
    </div>
    <!-- Content END-->


<!-- Import footer  -->
@endsection()
