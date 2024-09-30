@extends('layouts.main')
@section('content')

    <!-- Content -->
    <div class="page-content bg-white">


		<!-- Filters Search END -->
        <!-- contact area -->
        <div class="content-block">
			<!-- Browse Jobs -->
			<div class="section-full browse-job p-b50 p-t30">
				<div class="container">
					<div class="row">
						@include('employer.left-filter-browse-jobseeker')
						<div class="col-xl-9 col-lg-8">
							<div class="job-bx-title clearfix">
								<h5 class="font-weight-700 float-start text-uppercase" id="jobseekerCount">{{ $count ?? 0 }} Jobseekers Found</h5>
								{{-- <div class="float-end">
									<span class="select-title">Sort by</span>
									<select>
										<option>Last 2 Months</option>
										<option>Last Months</option>
										<option>Last Weeks</option>
										<option>Last 3 Days</option>
									</select>

								</div> --}}
							</div>

							<ul class="post-job-bx browse-js-list" id="jobseekerResults">
								{!! $html !!}
							</ul>
							

					@if ($page > 1 )
					<a href="?page={{ $page - 1 }}" class="btn btn-primary">Previous</a>
					@else
					<a class="btn btn-primary">Previous</a>
					@endif

					
					@if($list->count() == $perPage)
					<a href="?page={{ $page + 1 }}" class="btn btn-primary">Next</a>
					@endif


							{{-- <div class="pagination-bx m-t30">
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
            <!-- Browse Jobs END -->
		</div>
    </div>
    <!-- Content END-->



<!-- Import footer  -->
@endsection()