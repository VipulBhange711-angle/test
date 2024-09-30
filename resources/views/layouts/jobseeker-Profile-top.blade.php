
      <div class="overlay-black-dark profile-edit p-t50 p-b20" style="background-image:url({{ asset('images/jobseeker-profile-bg.jpg') }})">
		@php
            $table = 'jobseeker_view';
            $where = ['email'=> Session::get('js_username')];
            $select = ['js_id','fullname','country_name','city_name','role_name','work_desination_name','mob_code','mobile','email','profile_img','email_verified','resume_link'];
            $profile = [];
            $profile = getData($table, $select, $where);

            
        @endphp
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-7 candidate-info">
                <div class="candidate-detail">
                    <div class="canditate-des text-center">
                        <a >
                         @if (!empty($profile[0]->profile_img))
                        <img class="imagePreview" src="{{ url('storage/jobseeker/profile_image/'.$profile[0]->profile_img)}}"  style="height: 100px;width: 100px;margin: 1px;object-fit: contain;">
                        @else
                        <img class="imagePreview" src="{{ asset('images/no-image.png')}}"  style="height: 100px;width: 100px;margin: 1px;object-fit: contain;">
                        @endif
                            
                        </a>
                     <div class="upload-link" title="update" data-bs-toggle="tooltip" data-placement="right">
                    <form class="proflilImage" enctype="multipart/form-data">
                    <input type="file" class="update-flie image profilePic" name='com_logo' id="com_logo" accept=".png,.jpg,.jpeg">
                    <input type="text"  class='curr_img' value="{{ !empty($profile[0]->profile_img) ? $profile[0]->profile_img : ''  }}" name='old_img_name' hidden>
                    <i class="fas fa-pencil-alt"></i>
                    </form>
                </div>
                    </div>
                    @foreach ($profile as $info)
                        
                    
                    <div class="text-white browse-job text-left jobseeker-top-info-sec">
                        <h4 class="m-b0">{{ !empty($info->fullname) ? $info->fullname : ''}}
                            <a class="m-l15 font-16 text-white" data-bs-toggle="modal" data-bs-target="#profilename" href="#">
                                {{-- <i class="fas fa-pencil-alt"></i> --}}
                            </a>
                        </h4>
                        <p class="m-b15">{{!empty($info->role_name) ? $info->role_name : 'NA'}}</p>
                        <ul class="clearfix">
                            <li><i class="ti-location-pin"></i> {{!empty($info->city_name) ? $info->city_name : 'NA' }}, {{!empty($info->country_name) ? $info->country_name: ''}}</li>
                          <li><i class="ti-mobile"></i>{{!empty($info->mob_code) ? $info->mob_code : 'NA' }} {{!empty($info->mobile) ? $info->mobile: '' }}</li>
                            {{-- <li><i class="ti-briefcase"></i> Fresher</li> --}}
                           <li><i class="ti-email"></i> {{!empty($info->email) ? $info->email : 'NA' }} 
                            @if (!empty($info->email_verified) && $info->email_verified === 'Yes')
                                <a class="verified-pill">
                                Verified</a>
                            @else
                                
                            <a href="javascript:void(0)" class="unverified-pill verify">
                                <Span>Verify Now</Span></a>
                            @endif
                            </li>
                        </ul>
                        {{-- <div class="progress-box m-t10">
                            <div class="progress-info">Profile Strength (Average)<span>70%</span></div>
                            <div class="progress">
                                <div class="progress-bar bg-primary progress-bar-jobseeker" style="width: 80%" role="progressbar"></div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-5">
                <a href="javascript:void(0);">
                    <div class="pending-info text-white p-a25 ">
                        <h5>Pending Action</h5>
                        <ul class="list-check secondry">
                            <li>
                                @if (!empty($info->email_verified) && $info->email_verified === 'Yes')
                                     <i class="fa-solid fa-check" style="color: green"></i>
                                @else
                                      <i class="fa-solid fa-xmark" style="color: red"></i>
                                @endif
                                Verify Email Address
                            </li>
                        </ul>
                         <ul class="list-check secondry">
                            <li>
                                  @if (!empty($info->profile_img)  && $info->profile_img != null)
                                     <i class="fa-solid fa-check" style="color: green"></i>
                                @else
                                      <i class="fa-solid fa-xmark" style="color: red"></i>
                                @endif
                                Add Profile Photo</li>
                            <li>
                                  @if (!empty($info->resume_link)  && $info->resume_link != null)
                                     <i class="fa-solid fa-check" style="color: green"></i>
                                @else
                                      <i class="fa-solid fa-xmark" style="color: red"></i>
                                @endif
                                Add Resume
                            </li>
                        </ul>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
