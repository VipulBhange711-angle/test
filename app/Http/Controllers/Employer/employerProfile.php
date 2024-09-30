<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{employer as Employer, job_posting as JobPosting, jobseeker as Jobseeker, employer_payment as EmpPayments};
use Illuminate\Support\Facades\{Session, DB, Validator, View, Storage, Crypt};
use Carbon\Carbon;



class employerProfile extends Controller
{
    public $username;
    public $currentDate;
    public $time;
    public $JobPosting;
    public $Jobseeker;
    public $Employer;
    public $date;
    public function __construct()
    {
        $this->Jobseeker = new Jobseeker;
        $this->Employer = new employer;
        $this->JobPosting = new JobPosting;
        $this->username = session()->get('emp_username');
        $this->currentDate = Carbon::now('Europe/Malta');
        $this->time = $this->currentDate->format('Y-m-d H:i:s');
        $this->date = $this->currentDate->format('Y-m-d');
    }

    public function getDropDownlist($table, $select)
    {

        $data = DB::table($table)->select($select)->where('is_deleted', 'No')->get();
        return $data;
    }
    
    

    public function getEmpProfile()
    {

        if (session()->has('emp_username')) {

            $employerData = $this->Employer->empProfileDetails();


            return view('employer.emp-company-profile', compact('employerData'));
        }
    }



    public function addEmpProfile(Request $req)
    {

        if ($req->isMethod('POST') && $req->ajax() && session()->has('emp_username')) {


            $emp_com_name = isset($req->emp_com_name) ? htmlspecialchars($req->input('emp_com_name')) : '';
            $full_name = isset($req->full_name) ? htmlspecialchars($req->input('full_name')) : '';
            $emp_com_type = is_numeric($req->emp_com_type) ? $req->input('emp_com_type') : 0;
            $emp_com_size = is_numeric($req->emp_com_size) ? $req->input('emp_com_size') : 0;
            $emp_com_indus = is_numeric($req->emp_com_indus) ? $req->input('emp_com_indus') : 0;
            $emp_com_city = is_numeric($req->emp_com_city) ? $req->input('emp_com_city') : 0;
            $emp_com_zip = isset($req->emp_com_zip) ? htmlspecialchars($req->input('emp_com_zip')) : '';
            $emp_com_web = isset($req->emp_com_web) ? htmlspecialchars($req->input('emp_com_web')) : '';
            $emp_com_facebook = isset($req->emp_com_facebook) ? htmlspecialchars($req->input('emp_com_facebook')) : '';
            $emp_com_insta = isset($req->emp_com_insta) ? htmlspecialchars($req->input('emp_com_insta')) : '';
            $emp_com_linkedin = isset($req->emp_com_linkedin) ? htmlspecialchars($req->input('emp_com_linkedin')) : '';
            $emp_com_addrss = isset($req->emp_com_addrss) ? htmlspecialchars($req->input('emp_com_addrss')) : '';
            $license_no = isset($req->license_no) ? htmlspecialchars($req->input('license_no')) : '';
            $emp_id = is_numeric($req->emp_id) ? $req->input('emp_id') : 0;
          


            $rules = [
                "full_name" => "required|string|min:3",
                "emp_com_name" => "required|string",
                "emp_id" => "required",
                "license_no" => "required|min:3"
            ];

            $validate = Validator::make($req->only(['full_name', 'emp_com_name', 'emp_id', 'license_no']), $rules);

            
            $exists = Employer::where('email', session()->get('emp_username'))->count();

 
          

            if ($exists === 1) {
                if (!$validate->fails()) {
                try {

                    $user_id = Employer::where('id', $emp_id)->update([
                        'fullname' => $full_name,
                        'company_name' => $emp_com_name,
                        'company_type' => $emp_com_type,
                        'company_size' => $emp_com_size,
                        'industry' => $emp_com_indus,
                            'address' => $emp_com_addrss,
                        'license_no' => $license_no,
                        'city' => $emp_com_city,
                        'website' => $emp_com_web,
                        'facebook' => $emp_com_facebook,
                        'instagram' => $emp_com_insta,
                            'linkedin' => $emp_com_linkedin,
                        'zip' => $emp_com_zip,
                        'is_deleted' => 'No',
                    ]);
                        if ($user_id > 0) {
                            // mail_send(9, ['#Name#', '#Cat#'], [ucfirst($full_name), 'Employer'], session()->get('emp_username'));
                        echo json_encode(array('code' => 200, 'message' => 'Successfully Updated', 'icon' => 'success'));
                    } else {
                        echo json_encode(['code' => 201, 'message' => 'Unble to Add Details', "icon" => "error"]);
                    }
                } catch (\Exception $e) {
                        return $e;
                    echo json_encode(['code' => 201, 'message' => 'Unble to Add Details', "icon" => "error"]);
                }
                } else {
                    echo json_encode(['code' => 201, 'message' => 'Mandatory Field Missing', "icon" => "error"]);
                }
            } else {

                echo json_encode(['code' => 201, 'message' => 'User Not Exist', "icon" => "error"]);
            }
        } else {

            echo json_encode(['code' => 201, 'message' => 'Someting Went Wronge', "icon" => "error"]);
        }
    }

    public function jobApplications($job_id = "")
    {

        if (session()->has('emp_username')) {
            $username = Session::get('emp_username');
            $query = DB::table('job_application_history')->select('job_application_history.js_id', 'job_application_history.job_id', 'job_application_history.applied_on', 'job_posting_view.job_title',  'jobseeker_view.profile_img', 'jobseeker_view.fullname', 'jobseeker_view.notice_name', 'job_application_history.is_shortlisted')->leftJoin('job_posting_view', 'job_application_history.job_id', '=', 'job_posting_view.id')->leftJoin('jobseeker_view', 'jobseeker_view.js_id', '=', 'job_application_history.js_id')->where('job_posting_view.email', $username)->whereNotNull('job_application_history.applied_on')->orderBy('job_application_history.applied_on', 'DESC');

            if (isset($job_id) && !empty($job_id) && !is_numeric($job_id)) {
                $job_id =  base64_decode($job_id);
                $query->where('job_posting_view.id', $job_id);
            }

            $appliedData = $query->get();
            return view('employer.emp-applied-jobseeker', compact('appliedData'));
        }
    }
    public function shortlisted()
    {

        if (session()->has('emp_username')) {

            $emp_user_id = Session::get('emp_user_id');
            $username = Session::get('emp_username');

            $query = DB::table('job_application_history')
            ->select('job_application_history.js_id', 'job_application_history.job_id', 'jobseeker_view.fullname', 'jobseeker_view.profile_img', 'job_application_history.is_shortlisted')
            ->leftJoin('job_posting_view', 'job_application_history.employer_id', '=', 'job_posting_view.id')
            ->join('jobseeker_view', 'jobseeker_view.js_id', '=', 'job_application_history.js_id')
            ->where('job_application_history.employer_id', $emp_user_id)
            ->where('job_application_history.is_shortlisted', 'Yes');





            $shortlisted = $query->get();

            // return $shortlisted;
            return view('employer.emp-shortlisted-jobseeker', compact('shortlisted'));
        }
    }
    public function empJobseekerVeiw($js_id)
    {

     
        if (isset($js_id) && !empty($js_id) && $js_id != '') {

           
            $js_id = base64_decode($js_id);
       
            $data = $this->Jobseeker->profileDetails($js_id);
            $jsEdu = $this->Jobseeker->eduDetails($js_id);
            $jsExp = $this->Jobseeker->expDetails($js_id);

            return view('employer.jobseeker-details', compact('data', 'jsEdu', 'jsExp'));
        }
    }
    public function empPaymentsData()
    {
        if (session()->has('emp_username')) {
            $user_id = session()->get('emp_user_id');
            $data =
                DB::table('employer_payments')->select('employer_payments.*', 'employer_plan.plan_name')->leftJoin('employer_plan', 'employer_payments.plan_id', '=', 'employer_plan.id')->where('employer_payments.emp_id', $user_id)->orderBy('employer_payments.created_at', 'DESC')->get();

            return view('employer.emp-transactions', compact('data'));
        }
    }
    public function empDetailsView($id)
    {

        if (isset($id) && !empty($id) && !is_numeric($id)) {

            $enc_id = base64_decode($id);


            $exists = Employer::where('id', $enc_id)->count();
            if ($exists === 1) {
                try {
                    $select = ['id', 'company_name', 'profile_img', 'website', 'facebook', 'instagram', 'linkedin', 'industry_name', 'company_type_name', 'company_size_name', 'license_no', 'city_name', 'country_name', 'address', 'zip'];
                    $empData = DB::table('employer_view')->select($select)->where(['id' => $enc_id, 'is_deleted' => 'No'])->get();
                    $table = 'job_posting_view';
                    $jobData = $this->JobPosting->jobUpdateView($table, ['posted_by' => $empData[0]->id]);

                    return view('company-details', compact('empData', 'jobData'));
                } catch (\Exception $e) {
                    return $e;
                    return redirect('not-found')->with('msg', 'Compant Details Not Found');
                }
            } else {

                return redirect('not-found')->with('msg', 'Compant Details Not Found');
            }
        } else {

            return redirect('not-found')->with('msg', 'Something Went Wrong');
        }
    }

    public function getJobseekers(Request $req)
    {
        $curr_date = $this->date;
        $data = [];
        if (
            isset($req->left_jtype_fil) ||
            isset($req->left_edu_fil) || isset($req->notice_type_fil) || isset($req->left_exp_fil) || isset($req->left_sal_fil)
            || isset($req->date_sort) || isset($req->left_loc_fil)
        ) {
            $filter['start_date'] =  $this->currentDate->format('Y-m-d');
            $filter['job_type_fil'] = isset($req->left_jtype_fil) ? $req->input('left_jtype_fil') : 0;
            $filter['edu_fil'] = isset($req->left_edu_fil) ? $req->input('left_edu_fil') : 0;
            $filter['notice_fil'] = isset($req->notice_type_fil) ? $req->input('notice_type_fil') : 0;
            $filter['loc_fil'] = isset($req->left_loc_fil) ? $req->input('left_loc_fil') : '';
            $filter['exp_fil'] = isset($req->left_exp_fil) ? $req->input('left_exp_fil') : 0;
            $filter['sal_fil'] = isset($req->left_sal_fil) ? $req->input('left_sal_fil') : 0;
            $filter['date_sort'] = isset($req->date_sort) ? Carbon::now()->subDays($req->date_sort)->format('Y-m-d') : $filter['start_date'];

            $query = $this->Jobseeker->searchJobseeker($curr_date, '', $filter);
        } else {
            $query = $this->Jobseeker->searchJobseeker($curr_date, $req, '');
        }

        $data['perPage'] = 4; // Number of items per page
        $data['page'] = !empty(request()->get('page')) ? request()->get('page') : 1;

        $data['offset'] = ($data['page'] - 1) * $data['perPage'];



         $data['total_count'] = $query->count();
        // if (!empty($req->page_no) && is_numeric($req->page_no) && isset($req->page_no)) {
        //     $page = 10 * $req->page_no;
        //     // $data['paginate'] = $query->skip($page)->take(10);
        //     $data['paginate'] = $query->paginate(1000);
        // } else {
        //     $data['paginate'] = $query->paginate(1000);
        // }

        $data['list'] = $query->skip($data['offset'])->take($data['perPage'])->get();


        // $data['list'] = $query->get();
         $data['count'] = $data['total_count'] ?? 0;
        // $data['page'] =  ceil($data['count'] / 10);
        $data['html'] = '';
        $saved = '';

        if (count($data['list']) > 0) {
            foreach ($data['list'] as $lists) {

                $where = ['js_id' => $lists->js_id, 'employer_id' => session('emp_user_id'), 'is_shortlisted' => 'Yes'];
                $id = base64_encode($lists->js_id);
               

                // if (session()->has('js_username')) {
                $saved = '';
                $action = '';
                if (is_exist('job_application_history', $where) != 0) {
                    $action = base64_encode('No');
                    $saved =  "<label class='like-btn shortlist' data-is_toggle='No' data-short_action=" . $action . "
                                        data-js_id='$id' data-job_id=''>
                                        <i class='fa fa-bookmark' style='color: #11a1f5;'></i>
                                    </label>";
                } else {
                    $action = base64_encode('Yes');
                    $saved = "<label class='like-btn shortlist' data-is_toggle='Yes'
                                        data-short_action=" . $action . " data-js_id='$id' data-job_id=''>
                                        <i class='far fa-bookmark' style='color: #11a1f5;'></i>
                                        </label> 
                                        ";
                }
                // } else {

                //     $saved = "<label class='like-btn jslogincheck'><input type='checkbox'>
                //                   <i class='far fa-bookmark' aria-hidden='true'></i>
                //                 </label>";
                // }


                $img = "<img alt='' src='" . Storage::url('jobseeker/no-image.png') . "'>";
                if (!empty($lists->profile_img)) {
                    $img = "<img alt='' src='" . Storage::url("jobseeker/profile_image/$lists->profile_img") . "'>";
                } else {
                    $img = "<img alt='' src='" . Storage::url('no-image.jpg') . "'>";
                }
                // $sal = '';
                // if (!empty($lists->salary_hide === 'No')) {
                //     $sal = "<div class='salary-bx'><span>" . $lists->job_salary_to_name . "</span></div>";
                // }
                $duration = duration($lists->updated_at);

                $data['html'] .= "<li>
									<div class='post-bx'>
										<div class='d-flex mb-4'>
											<div class='job-post-company'>
												<a href='javascript:void(0);'><span>
													" . $img . "
												</span></a>
											</div>
											<div class='job-post-info'>
												<h4><a href=" . route('emp-js-view', $id) . " class='js-name'>" . $lists->fullname . "</a></h4>
												<p class='m-b5 font-13'>
													<a href='javascript:void(0);' class='text-primary'>" . $lists->role_name . " </a>
													
												</p>
												<ul>
													<li><i class='fas fa-map-marker-alt'></i> " . $lists->prefered_location_name . "</li>
													<li><i class='fa-solid fa-business-time'></i> " . $lists->experiance_name . "</li>
													<li><i class='far fa-money-bill-alt'></i> " . $lists->expected_salary_name . "</li>
													 <li><i class='far fa-clock'></i> Active " . $duration . " ago</li> 
												</ul>
											</div>
										</div>
										<div class='d-flex'>
											<div class='job-time me-auto'>
												<a href='javascript:void(0);'><span>" . $lists->pref_job_type_name . "</span></a>
												<a href='javascript:void(0);'><span>" . $lists->notice_name . "</span></a>
											</div>

										</div>
										" . $saved . "
									</div>
								</li>";
            }
        } else {
            $data['html'] .= "<li>
			<div class='post-bx'>
				<div class='d-flex m-b30'>
					<div class='job-post-info'>
						<ul>
							<li><h4>No Jobseeker Found</h4></li>
						</ul>
					</div>
				</div>
			</div>
		</li>";
        }

        if ($req->ajax()) {
            return $data;
        } else {
            return view('employer/browse-jobseeker', $data);
        }
    }
}