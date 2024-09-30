                <ul class="nav navbar-nav mob-resp-btn">
							<li>
							<a class="dez-page" href="{{route('browse-jobseeker')}}">Browse Jobseeker </a>
							</li>
								<li>
									<a href="javascript:void(0);" class="site-button" style="color:#fff;background-color: #195577;">Profile<i class="fa fa-chevron-down"></i></a>
								<ul class="sub-menu">
									<li><a class="dez-page" href="{{route('company-profile')}}">My Profile </a></li>
									<li><a href="{{route('logout')}}" style="color:#000;"><i class="fa fa-user" style="color:#fff;"></i> Logout</a></li>
								</ul>
							</li>
								<li>
								<a href="javascript:void(0);" class="site-button plans-btn">Plans<i class="fa fa-chevron-down"></i></a>
								<ul class="sub-menu">
									<li><a class="dez-page" href="{{route('employer-plans')}}">Employer</a></li>
								</ul>
							</li>
						</ul>	