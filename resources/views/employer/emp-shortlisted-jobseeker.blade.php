
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
									<h5 class="font-weight-700 float-start text-uppercase">Shortlisted Jobseekers</h5>
									{{-- <a href="#" class="site-button button-sm float-end "><i class="fas fa-pencil-alt m-r5"></i> Edit</a> --}}
								</div>
								<ul class="post-job-bx browse-job-grid post-resume row">
									@php
										$i = 1;
									@endphp
									@foreach ($shortlisted as $shortlist)
									@php
										$js_id =base64_encode($shortlist->js_id);
										$job_id =base64_encode($shortlist->job_id);
										$action =base64_encode('No');
									@endphp
								<li class="col-lg-12 col-md-12" id='candidate_{{$i}}'>
										<div class="post-bx">
											<div class="d-flex m-b20">
												<div class="jobseeker-photo-for-applied">
														<span>

															
															@if (isset($shortlist->profile_img) && !empty($shortlist->profile_img))
										   <img alt="" src="{{ Storage::url('jobseeker/profile_image/'.$shortlist->profile_img)}}">
									@else
										   <img alt="" src="{{ Storage::url('no-image.jpg')}}">
									@endif
                                 
														</span>
												</div>
												<div class="job-post-info">
													<h5 class="m-b0"><a href="{{ route('emp-js-view', $js_id)}}">{{$shortlist->fullname}}</a></h5>

													<ul>
														{{-- <li><i class="fa fa-briefcase"></i>Job Title: {{$shortlist->job_title}}</li> --}}
													</ul>
												</div>
											</div>
											<div class="job-time m-t15 m-b10">
												<a href="{{ route('emp-js-view', $js_id)}}"><span>Show Jobseeker Details</span></a>
													<a href="javascript:void(0);" data-js_id="{{$js_id}}" data-short_action="{{$action}}" data-job_id="{{$job_id}}" data-row="{{$i}}" class="shortlist"><span>Reject</span></a>
											</div>
											{{-- <a href="files/pdf-sample.pdf" target="blank" class="job-links">
												<i class="fa fa-download"></i>
											</a> --}}
										</div>
									</li>
									@php
									$i++	
									@endphp
	@endforeach

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
