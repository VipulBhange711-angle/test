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
						<div class="job-bx submit-resume">
							<div class="job-bx-title clearfix">
								<h5 class="font-weight-700 float-start text-uppercase">Update Job Details</h5>
								{{-- <a href="#" class="site-button button-sm float-end "><i class="fas fa-pencil-alt m-r5"></i> Edit</a> --}}
							</div>
							@foreach ($jobData as $jobDatas)

							@php
								$job_id = base64_encode($jobDatas->id);
							@endphp
							<form id="addJobForm">
								<div class="row">
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label>Job Title <span class="imp-field-star">*</span></label>
											<input type="text" class="form-control" id="job_title" value="{{$jobDatas->job_title}}" name="job_title"
												placeholder="Enter Job Title">
												<input type="text" class="form-control" value="{{$job_id}}" name="job_id" hidden>
											<span id="job_title_error" style="color:red;display:none;">
												<small>
													<i>Please Job Title </i>
												</small></span>
										</div>
									</div>
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label>Job Type <span class="imp-field-star">*</span></label>
											<select id="job_type" name="job_type">
												@if (isset($jobDatas->job_type))
														<option value="{{ $jobDatas->job_type}}" selected>{{ $jobDatas->job_type_name}}</option>
													@else
														<option value="" disabled selected>Select Job Type</option>
													@endif
												 @foreach (getDropDownlist('job_types', ['id', 'job_type']) as $job_type)
												@if ($jobDatas->job_type != $job_type->id)
												<option value="{{ $job_type->id}}">{{ $job_type->job_type}}</option>
												@endif
												@endforeach 
											</select>
											<span id="job_type_error" style="color:red;display:none;">
												<small>
													<i>Please Provide Job Type </i>
												</small></span>
										</div>
									</div>

									<div class="col-lg-6 col-md-6">
										<div class="form-group">

											<label>Required Language <span class="imp-field-star">*</span></label>
												@php
													$skill_lang = explode(',', $jobDatas->required_language);
													$lang_arr = multiSelectDropdown('languages',['skill_language','id'], $skill_lang);

												@endphp
											<select id="job_lang" name="job_lang[]" multiple>
													 @foreach ($lang_arr as $lang)
												@if (isset($lang[0]->id))
														<option value="{{ $lang[0]->id}}" selected>{{$lang[0]->skill_language}}
													</option>
													@else
														<option value="" disabled>Select Language</option>
													@endif 
													@endforeach 
												 @foreach (getDropDownlist('languages', ['id', 'skill_language']) as $language)
												<option value="{{ $language->id}}">{{ $language->skill_language}}
												</option>
												@endforeach 
											</select>
											<span id="job_lang_error" style="color:red;display:none;">
												<small>
													<i>Please Provide Required Language </i>
												</small></span>
										</div>
									</div>
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label>Industry <span class="imp-field-star">*</span></label>
											<select id="job_indus"  name="job_indus">
											@if (isset($jobDatas->job_industry_name))
														<option value="{{ $jobDatas->job_industry}}" selected>{{ $jobDatas->job_industry_name}}</option>
													@else
														<option value="" disabled selected>Select Industry</option>
													@endif
												 @foreach (getDropDownlist('industries', ['id', 'industries_name']) as $indus)
												<option value="{{ $indus->id}}">{{ $indus->industries_name}}</option>
												@endforeach 
											</select>
											<span id="job_indus_error" style="color:red;display:none;">
												<small>
													<i>Please Provide Industry </i>
												</small></span>
										</div>
									</div>
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label>Function Area <span class="imp-field-star">*</span></label>
											<select id="job_func_area"  name="job_func_area">
											@if (isset($jobDatas->functional_name))
														<option value="{{ $jobDatas->functional_area}}" selected>{{ $jobDatas->functional_name}}</option>
													@else
														<option value="" disabled selected>Select Function Area</option>
													@endif
												 @foreach (getDropDownlist('functional_areas', ['id', 'functional_name']) as $functional_area)
												<option value="{{ $functional_area->id}}">
													{{ $functional_area->functional_name}}</option>
												@endforeach 
											</select>
											<span id="job_func_area_error" style="color:red;display:none;">
												<small>
													<i>Please Provide Function Area </i>
												</small></span>
										</div>
									</div>
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label>Designation <span class="imp-field-star">*</span></label>
											<select id="job_designation"  name="job_designation">
											@if (isset($jobDatas->job_designation))
														<option value="{{ $jobDatas->job_designation}}" selected>{{ $jobDatas->job_designation_name}}</option>
													@else
														<option value="" disabled selected>Select Designation</option>
													@endif
												 @foreach (getDropDownlist('designations', ['id', 'role_name']) as $designation)
												<option value="{{ $designation->id}}">{{ $designation->role_name}}
												</option>
												@endforeach 
											</select>
											<span id="job_designation_error" style="color:red;display:none;">
												<small>
													<i>Please Provide Designation </i>
												</small></span>
										</div>
									</div>

									<div class="col-lg-3 col-md-3">
										<div class="form-group">
											<label>Experience <span class="imp-field-star">*</span></label>
											<select id="job_expr"  name="job_expr">
												@if (isset($jobDatas->work_experience_from))
														<option value="{{ $jobDatas->work_experience_from}}" selected>{{ $jobDatas->experiance}}</option>
													@else
														<option value="" disabled selected>Select Experience</option>
													@endif
												 @foreach (getDropDownlist('experiances', ['experiance', 'id']) as $exp)
												<option value="{{ $exp->id}}">{{ $exp->experiance}}
												</option>
												@endforeach

											</select>
											<span id="job_expr_error" style="color:red;display:none;">
												<small>
													<i>Please Select Experience </i>
												</small></span>
										</div>
									</div>
									<div class="col-lg-3 col-md-3">
										<div class="form-group">
											<label>Salary Range</label>
											<select id="job_sal"  name="job_sal">
												@if (isset($jobDatas->job_salary_to_name))
														<option value="{{ $jobDatas->job_salary_to}}" selected>{{ $jobDatas->job_salary_to_name}}</option>
													@else
														<option value="" disabled selected>Select Salary Range</option>
													@endif
												 @foreach (getDropDownlist('salary_ranges', ['id', 'salary_range']) as $salary_range)
												<option value="{{ $salary_range->id}}">{{ $salary_range->salary_range}}
												</option>
												@endforeach 
											</select>
											<div class="show-hide-check-emp sal_disply">
												@php
													$checked = '';
												@endphp
												@if ($jobDatas->salary_hide === 'Yes')
												@php
													$checked = 'checked';
												@endphp
												@endif
												<input type="checkbox" id="job_sal_hide" name="job_sal_hide"
													value="Yes" @php
														echo $checked
													@endphp>&nbsp;&nbsp;
												<span>Hide from Job Seekers</span>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label>Location <span class="imp-field-star">*</span></label>
											<select id="job_location"  name="job_location">
												@if (isset($jobDatas->location_hiring))
														<option value="{{ $jobDatas->location_hiring}}" selected>{{ $jobDatas->location_hiring_name}}</option>
													@else
														<option value="" disabled selected>Select Location</option>
													@endif
												 @foreach (getDropDownlist('cities', ['id', 'city_name']) as $city)
												<option value="{{ $city->id}}">{{ $city->city_name}}</option>
												@endforeach 
											</select>
											<span id="job_location_error" style="color:red;display:none;">
												<small>
													<i>Please Provide Location </i>
												</small></span>
										</div>
									</div>
								
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
                                                 @php
                                                $gender = explode(',', $jobDatas->gender);
                                                $gender
												@endphp
											<label>Gender </label>
											<select id="job_gender"  name="job_gender[]" multiple>
												<option value="{{ $jobDatas->gender}}" selected>{{ $jobDatas->gender}}</option>
											</option>
											@if ($jobDatas->gender != 'Female')
												  <option value="Female">Female</option>
											@endif
												@if ($jobDatas->gender != 'Male')
												  <option value="Male">Male</option>
											@endif
										</select>
									</div>
								</div>  
  
										<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label>No. of Openings <span class="imp-field-star">*</span></label>
											<input type="number" id="vacancy_count" min="1" value="{{$jobDatas->no_of_openings}}" name="vacancy_count" class="form-control"
												placeholder="No of Vacanies">
											<span id="vacancy_count_error" style="color:red;display:none;">
												<small>
													<i>Enter No. of Openings Not less then 1 </i>
												</small></span>
										</div>
									</div>
								</div>
								

								<!-- Desired Candidate Profile -->
								<div class="job-bx-title clearfix">
									<h5 class="font-weight-700 float-start text-uppercase">Desired Candidate Profile
									</h5>
								</div>
								<div class="row m-b30">
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
												@php
													$skill_keyword = explode(',', $jobDatas->skill_keyword);
													$skill_arr = multiSelectDropdown('key_skills',['key_skill_name','id'], $skill_keyword);
												@endphp
											<label>Skills <span class="imp-field-star">*</span></label>
											<select id="job_skills"  name="job_skills[]" multiple class="job_skills">
												@foreach ($skill_arr as $skills)
												@if (isset($skills[0]->id))
														<option value="{{ $skills[0]->id}}" selected>{{$skills[0]->key_skill_name}}
													</option>
													@else
														<option value="" disabled>Select Language</option>
													@endif 
													@endforeach 
												 @foreach (getDropDownlist('key_skills', ['id', 'key_skill_name']) as $key_skill)
												<option value="{{ $key_skill->id}}">{{ $key_skill->key_skill_name}}
												</option>
												@endforeach 
											</select>
											<span id="job_skills_error" style="color:red;display:none;">
												<small>
													<i>Please Select Skills </i>
												</small></span>
										</div>
									</div>
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<label>Job Description: <span class="imp-field-star">*</span></label>
											<textarea class="form-control" id="job_disc" value="@php echo $jobDatas->job_description @endphp" name="job_disc">@php echo $jobDatas->job_description @endphp</textarea>
											<span id="job_disc_error" style="color:red;display:none;">
												<small>
													<i>Please Job Description </i>
												</small></span>
										</div>
									</div>
								</div>

								<!-- Qualification Details -->
								<div class="job-bx-title clearfix">
									<h5 class="font-weight-700 float-start text-uppercase">Qualification Details</h5>
								</div>
								<div class="row m-b30">
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label>Rquired Qualification <span class="imp-field-star">*</span></label>
											<select id="job_educ"  name="job_educ">
												@if (isset($jobDatas->job_education_name))
														<option value="{{ $jobDatas->job_education}}" selected>{{ $jobDatas->job_education_name}}</option>
													@else
														<option value="" disabled selected>Select Rquired Qualification</option>
													@endif
												 @foreach (getDropDownlist('qualifications', ['id', 'educational_qualification']) as $qualification)
												<option value="{{ $qualification->id }}">
													{{ $qualification->educational_qualification}}</option>
												@endforeach 
											</select>
											<span id="job_educ_error" style="color:red;display:none;">
												<small>
													<i>Please Provide Qualification </i>
												</small></span>
										</div>
									</div>
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label> Specialization <span class="imp-field-star"></span></label>
											<input type="text" id="job_spec" value="{{$jobDatas->specialization}}" name="job_spec" class="form-control"
												placeholder="Enter Specialization">
											<span id="job_spec_error" style="color:red;display:none;">
												<small>
													<i>Please Provide Specialization </i>
												</small></span>
										</div>
									</div>
								</div>

								<!-- Qualification Details -->
								<div class="job-bx-title clearfix">
									<h5 class="font-weight-700 float-start text-uppercase">Contact Details</h5>
								</div>
								<div class="row m-b30">
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label>Contact Person <span class="imp-field-star">*</span></label>
											<input type="text" id="job_con_person" value="{{$jobDatas->contact_person}}" name="job_con_person"
												class="form-control" placeholder="Enter Name">
											<span id="job_con_person_error" style="color:red;display:none;">
												<small>
													<i>Please Provide Contact Person </i>
												</small></span>
										</div>
									</div>
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label>Mobile No <span class="imp-field-star">*</span></label>
											<div class="row m-b30">
												<div class="col-4 " style="padding-right: 0;">
													<div class="dropdown bootstrap-select">
												<input type="text" id="mob_code" value="{{$jobDatas->mob_code}}" name="mob_code" class="form-control" readonly>
													</div>
												</div>
												<div class="col-8">
													<input type="number" id="job_con_phone" value="{{$jobDatas->contact_phone}}" name="job_con_phone" class="form-control" placeholder="Enter Mobile Number">
												</div>
											</div>

											<span id="job_con_phone_error" style="color:red;display:none;">
												<small>
													<i>Please Provide 8 Digit Mobile No </i>
												</small></span>

										</div>
									</div>
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<label>Email <span class="imp-field-star">*</span></label>
											<input type="email" id="job_con_email" value="{{$jobDatas->contact_email}}" name="job_con_email"
												class="form-control" placeholder="Enter Email Id">
											<span id="job_con_email_error" style="color:red;display:none;">
												<small>
													<i>Please Provide Email </i>
												</small>
											</span>
											<span id="job_con_email_ver_error" style="color:red;display:none;">
												<small>
													<i>Please Provide Valid Email id e.g (abc@test.com) </i>
												</small>
											</span>
											<div class="show-hide-check-emp">
												@php
													$checked_con = '';
												@endphp
												@if ($jobDatas->hide_contact_details === 'Yes')
												@php
													$checked_con = 'checked';
												@endphp

												@endif
												<input type="checkbox" id="job_con_hide" value="Yes" name="job_con_hide"
													data-gtm-form-interact-field-id="0" @php
														echo $checked_con
													@endphp>&nbsp;&nbsp;
												<span>Hide Contact Details from Job Seekers</span>
											</div>
										</div>
									</div>
								</div>
								<button type="button" class="site-button m-b30" id="postJob">Publish</button>
							</form>
							@endforeach

						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Browse Jobs END -->
	</div>
</div>
<!-- Content END-->
<script>
CKEDITOR.replace('job_disc');
</script>

<!-- Import footer  -->
@endsection()
