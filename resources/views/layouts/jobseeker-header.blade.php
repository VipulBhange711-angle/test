<ul class="nav navbar-nav mob-resp-btn">
							<li>
								<a href="javascript:void(0);">Jobs <i class="fa fa-chevron-down"></i></a>
								<ul class="sub-menu mm-show jobs-top-btn">
								<li>
									<form class="dezPlaceAni" action="{{url('top-search-bar')}}" method="GET">
									@csrf
									<input name="search_job_type[]" value='16' hidden>
									<a class="dez-page"><button class="btn btn-none" type="submit">Internship</button></a>
									</form>
								</li>
								<li class="active">
									<form class="dezPlaceAni" action="{{url('top-search-bar')}}" method="GET">
									@csrf
									<input name="search_job_type[]" value='17' hidden>
									<a class="dez-page"><button class="btn btn-none" type="submit">Part Time</button></a>
									</form>
								</li>
								<li class="active">
										<form class="dezPlaceAni" action="{{url('top-search-bar')}}" method="GET">
									@csrf
									<input name="search_job_type[]" value='19' hidden>
									<a class="dez-page"><button class="btn btn-none" type="submit">Full Time</button></a>
									</form>
								</li>
								</ul>
							</li>
							<li>
							<form class="dezPlaceAni" action="{{url('top-search-bar')}}" method="GET"> 
								@csrf
							<button class="site-button browse-job-btn" type="submit" ><b>Browse Jobs</b></button>
							</form>
								
							</li>
						
								<li>
									<a href="javascript:void(0);" class="site-button" style="color:#fff;background-color: #195577;">Profile<i class="fa fa-chevron-down"></i></a>
								<ul class="sub-menu">
									<li><a class="dez-page" href="{{route('js-profile')}}">My Profile </a></li>
									<li><a href="{{route('logout')}}" style="color:#000;"><i class="fa fa-user" style="color:#fff;"></i> Logout</a></li>
								</ul>
							</li>
							{{-- @endif --}}
								<li>
								<a href="javascript:void(0);" class="site-button plans-btn">Plans<i class="fa fa-chevron-down"></i></a>
								<ul class="sub-menu">
									<li><a class="dez-page" href="{{route('jobseeker-plans')}}">Jobseeker </a></li>
								</ul>
							</li>
						</ul>	