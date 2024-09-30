<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\{job_posting_view as Jobs, employer as Employer, employer_payment as EmpPayments, jobseeker_profile as JobseekerProf, jobseeker_payment as JsPayement};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session, Http, DB, Validator, Storage};
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;


class commonController extends Controller
{
    public $JobView;
    public $currentDate;
    public $time;
    public $date;
    public function __construct()
    {
        $this->JobView = new Jobs;
        $this->currentDate = Carbon::now('Europe/Malta');
        $this->time = $this->currentDate->format('Y-m-d H:i:s');
        $this->date = $this->currentDate->format('Y-m-d');
    }
    public function getDropDownlist($table, $select)
    {
        $data = DB::table($table)->select($select)->where('is_deleted', 'No')->get();
        return $data;
    }
    public function profilImageUpload(Request $req)
    {
        if (
            $req->isMethod('POST') && $req->ajax() && session()->has('emp_username') ||
            session()->has('js_username')
        ) {

            if (session()->has('emp_username')) {
                $id = Session::has('emp_user_id') ? Session::get('emp_user_id') : 0;
                $where = ['id' => $id];
                $folder = 'storage/employer/profile_image/';
                $table = 'employers';
                $cat = 'Employer';
            } elseif (session()->has('js_username')) {
                $id = Session::has('js_user_id') ? Session::get('js_user_id') : 0;
                $table = 'jobseekers';
                $where = ['id' => $id];
                $folder = 'storage/jobseeker/profile_image/';
                $cat = 'Jobseeker';
            }



            $com_logo = $req->hasFile('com_logo') ? $req->file('com_logo') : '';
            $old_img_name = !empty($req->input('old_img_name')) ? $req->input('old_img_name') : '';
            $logo_name = $req->hasFile('com_logo') ? $id . "_" . time() . "." . $com_logo->getClientOriginalExtension() :  $old_img_name;
            if ($req->hasFile('com_logo')) {
                $rules = [
                    'com_logo' => 'required|mimes:jpeg,png,jpg,svg|max:3072',
                ];

                $validate = Validator::make($req->only(['com_logo']), $rules);
                if (!$validate->fails()) {


                    $logo_uploaded = file_upload($com_logo, $folder, $logo_name, $req->input('old_img_name'));
    
    
    
                    if ($logo_uploaded === TRUE && !empty($id) && is_numeric($id)) {
                        try {

                            DB::table($table)->where($where)->update(['profile_img' => $logo_name]);
                            // mail_send(9, ['#Name#', '#Cat#'], ['', $cat], session()->get('emp_username'));
                            echo json_encode(['code' => 200, 'message' => 'Successfully Uploaded', 'text' => "", "icon" => "error", 'new' => $logo_name]);
                        } catch (\Exception $e) {
                            echo json_encode(['code' => 201, 'message' => 'Unable to Upload1', 'text' => "Try Again", "icon" => "error", 'old' => $old_img_name]);
                        }
                    } else {
                        echo json_encode(['code' => 202, 'message' => 'Unable to Upload2', 'text' => "Try Again", "icon" => "error", 'old' => $old_img_name]);
                    }
                } else {

                    echo json_encode(['code' => 203, 'message' => 'Invalid File', 'text' => "File Should be JPG, PNG & Less then 3MB", "icon" => "error", 'old' => $old_img_name]);
                }
            } else {

                echo json_encode(['code' => 204, 'message' => 'No Image', 'text' => "", "icon" => "error", 'old' => $old_img_name]);
            }
        } else {

            echo json_encode(['code' => 205, 'message' => 'Someting Went Wronge', 'text' => "", "icon" => "error"]);
        }
    }
    // public function searchJobs(Request $req)
    // {
    //     $curr_date = $this->date;
    //     $data = [];
    //     if (
    //         isset($req->left_jtype_fil) ||
    //         isset($req->left_edu_fil) || isset($req->left_indus_fil) || isset($req->left_exp_fil) || isset($req->left_sal_fil)
    //         || isset($req->date_sort) || isset($req->left_loc_fil)
    //     ) {
    //         $filter['start_date'] =  $this->currentDate->format('Y-m-d');
    //         $filter['job_type_fil'] = isset($req->left_jtype_fil) ? $req->input('left_jtype_fil') : 0;
    //         $filter['edu_fil'] = isset($req->left_edu_fil) ? $req->input('left_edu_fil') : 0;
    //         $filter['indus_fil'] = isset($req->left_indus_fil) ? $req->input('left_indus_fil') : 0;
    //         $filter['loc_fil'] = isset($req->left_loc_fil) ? $req->input('left_loc_fil') : '';
    //         $filter['exp_fil'] = isset($req->left_exp_fil) ? $req->input('left_exp_fil') : 0;
    //         $filter['sal_fil'] = isset($req->left_sal_fil) ? $req->input('left_sal_fil') : 0;
    //         $filter['date_sort'] = isset($req->date_sort) ? Carbon::now()->subDays($req->date_sort)->format('Y-m-d') : $filter['start_date'];

    //         $query = $this->JobView->topSearchJobs($curr_date, '', $filter);
    //     } else {
    //         $query = $this->JobView->topSearchJobs($curr_date, $req, '');
    //     }

    //     $data['perPage'] = 5; // Number of items per page
    //     $data['page'] = request()->get('page') ?: 1;

    //     $data['offset'] = ($data['page'] - 1) * $data['perPage'];

    //     $data['total_count'] = $query->count();
    //     // if (!empty($req->page_no) && is_numeric($req->page_no) && isset($req->page_no)) {
    //     //     $page = 10 * $req->page_no;
    //     //     // $data['paginate'] = $query->skip($page)->take(10);
    //     //     $data['paginate'] = $query->paginate(1000);
    //     // } else {
    //     //     $data['paginate'] = $query->paginate(1000);
    //     // }
    //     $data['list'] = $query->skip($data['offset'])->take($data['perPage'])->get();
    //      // echo "<pre>";
    //     // print_r($data['list']);
    //     // die;

    //       $data['count'] = $data['total_count'] ?? 0;
    //     // $data['page'] =  ceil($data['count'] / 10);
    //     $data['html'] = '';
    //     $saved = '';

    //     if (count($data['list']) > 0) {
    //         foreach ($data['list'] as $lists) {

    //             $where = ['job_id' => $lists->id, 'js_id' => session('js_user_id'), 'is_saved' => 'Yes'];
    //             $id = base64_encode($lists->id);
    //             $posted_by = base64_encode($lists->posted_by);
    //             if (session()->has('js_username')) {

    //                 if (is_exist('jobseeker_viewed_jobs', $where) != 0) {
    //                     $saved =  "<label class='like-btn action' data-is_toggle='No' data-posted_by='$posted_by' data-job_action='Saved'
    //                                     data-job_id='$id'>
    //                                     <i class='fa fa-bookmark' style='color: #11a1f5;'></i>
    //                                 </label>";
    //                 } else {
    //                     $saved = "<label class='like-btn action' data-is_toggle='Yes' data-posted_by='$posted_by'
    //                                     data-job_action='Unsaved' data-job_id='$id)'>
    //                                     <i class='far fa-bookmark' style='color: #11a1f5;'></i>
    //                                     </label> 
    //                                     ";
    //                 }
    //             } else {

    //                 $saved = "<label class='like-btn jslogincheck'><input type='checkbox'>
    //                               <i class='far fa-bookmark' aria-hidden='true'></i>
    //                             </label>";
    //             }


    //             $img = "<img alt='' src='" . Storage::url('storage/no-image.png') . "'>";
    //             if (!empty($lists->profile_img)) {
    //                 $img = "<img alt='' src='" . Storage::url("employer/profile_image/$lists->profile_img") . "'>";
    //             } else {
    //                 $img = "<img alt='' src='" . Storage::url('jobseeker/no-image.jpg') . "'>";
    //             }
    //             $sal = '';
    //             if (!empty($lists->salary_hide === 'No')) {
    //                 $sal = "<div class='salary-bx'><span>" . $lists->job_salary_to_name . "</span></div>";
    //             }
    //             $duration = duration($lists->posted_on);

    //             $data['html'] .= "<li>
	// 		<div class='post-bx'>
	// 			<div class='d-flex m-b30'>
	// 	<div class='job-post-company'><a ><span>
	// 	" . $img .
    //                 "
		
	// 	</span></a>
	// 				</div>
	// 				<div class='job-post-info'>
	// 					<h4><a href='" . url('job-details-view', $id) . "' target='_blank'>" . htmlspecialchars_decode($lists->job_title) . "</a></h4>
    //                     <div class='company-name-url'>
    //                         <span>" . htmlspecialchars_decode($lists->company_name) . "</span>
    //                     </div>
                        
	// 					<ul>
                            
	// 						<li><i class='fa-solid fa-briefcase'></i>" . $lists->experiance . " </li>
	// 						<li><i class='fas fa-map-marker-alt'></i>" . $lists->location_hiring_name . "</li>
	// 						<!-- <li><i class='far fa-bookmark'></i>" . $lists->job_type_name . " </li> -->
	// 						<li><i class='far fa-clock'></i> Published " . $duration . " ago</li>
	// 					</ul>
	// 				</div>
	// 			</div>
	// 			<div class='d-flex'>
	// 				<div class='job-time me-auto'><a><span>" . $lists->job_type_name . "</span></a></div>
	// 				<div class='salary-bx'><span>" . $sal . "</span></div>
	// 			</div>
    //             " . $saved . "
	// 		</div>
	// 	</li>";
    //         }
    //     } else {
    //         $data['html'] .= "<li>
	// 		<div class='post-bx'>
	// 			<div class='d-flex m-b30'>
	// 				<div class='job-post-info'>
	// 					<ul>
	// 						<li><h4>No Jobs Found</h4></li>
	// 					</ul>
	// 				</div>
	// 			</div>
	// 		</div>
	// 	</li>";
    //     }

    //     if ($req->ajax()) {
    //         return $data;
    //     } else {
    //         return view('browse-all-jobs', $data);
    //     }
    // }
    public function searchJobs(Request $req)
    {
        $curr_date = $this->date;
        $data = [];
        if (
            isset($req->left_jtype_fil) ||
            isset($req->left_edu_fil) || isset($req->left_indus_fil) || isset($req->left_exp_fil) || isset($req->left_sal_fil)
            || isset($req->date_sort) || isset($req->left_loc_fil) || isset($req->left_desig_fil)
        ) {
            $filter['start_date'] =  $this->currentDate->format('Y-m-d');
            $filter['job_type_fil'] = isset($req->left_jtype_fil) ? $req->input('left_jtype_fil') : 0;
            $filter['edu_fil'] = isset($req->left_edu_fil) ? $req->input('left_edu_fil') : 0;
            $filter['indus_fil'] = isset($req->left_indus_fil) ? $req->input('left_indus_fil') : 0;
            $filter['loc_fil'] = isset($req->left_loc_fil) ? $req->input('left_loc_fil') : '';
            $filter['exp_fil'] = isset($req->left_exp_fil) ? $req->input('left_exp_fil') : 0;
            $filter['sal_fil'] = isset($req->left_sal_fil) ? $req->input('left_sal_fil') : 0;
            $filter['desig_fil'] = isset($req->left_desig_fil) ? $req->input('left_desig_fil') : 0;
            $filter['date_sort'] = isset($req->date_sort) ? Carbon::now()->subDays($req->date_sort)->format('Y-m-d') : $filter['start_date'];

            $query = $this->JobView->topSearchJobs($curr_date, '', $filter);
        } else {
            //cotrol + hover on topsearchjobs get view code and table code select query you can print that page 
            $query = $this->JobView->topSearchJobs($curr_date, $req, '');
        }




        $data['total_count'] = $query->count();
        // echo $data['total_count'];
        // exit;
        if (!empty($req->page_no) && is_numeric($req->page_no) && isset($req->page_no)) {
            $page = 10 * $req->page_no;
            // $data['paginate'] = $query->skip($page)->take(10);
            $data['paginate'] = $query->paginate(10);
        } else {
            $data['paginate'] = $query->paginate(10);
        }

    

        $data['list'] = $query->get();
        $data['count'] = $data['total_count'] ?? 0;
        $data['page'] =  ceil($data['count'] / 10);
        $data['html'] = '';
        $saved = '';
        // echo "<pre>";
        // print_r($data['list']);
        // exit;
    

        if (count($data['list']) > 0) {
            foreach ($data['list'] as $lists) {
                $where = ['job_id' => $lists->id, 'js_id' => session('js_user_id'), 'is_saved' => 'Yes'];
                $id = base64_encode($lists->id);
                $posted_by = base64_encode($lists->posted_by);
                if (session()->has('js_username')) {
                    


                    if (is_exist('jobseeker_viewed_jobs', $where) != 0) {
                       

                        $saved =  "<label class='like-btn action' data-is_toggle='No' data-posted_by='$posted_by' data-job_action='Saved' data-job_id='$id'>
                                        <i class='fa fa-bookmark' style='color: #11a1f5;'></i>
                                    </label>";
                    } else {
                        $saved = "<label class='like-btn action' data-is_toggle='Yes' data-posted_by='$posted_by' data-job_action='Unsaved' data-job_id='$id'>
                                        <i class='far fa-bookmark' style='color: #11a1f5;'></i>
                                    </label>";
                    }
                } 
                else {
                    $saved = "<label class='like-btn jslogincheck'><input type='checkbox'>
                                    <i class='far fa-bookmark' aria-hidden='true'></i>
                                </label>";

                }
        
                $img = "<img alt='' src='" . Storage::url('no-image.jpg') . "'>";
                if (!empty($lists->profile_img)) {
                    $img = "<img alt='' src='" . Storage::url("employer/profile_image/$lists->profile_img") . "'>";
                }
        
                $sal = '';
                if (!empty($lists->salary_hide) && $lists->salary_hide === 'No') {
                    $sal = "<div class='salary-bx'><span>" . $lists->job_salary_to_name . "</span></div>";
                }
        
                $duration = duration($lists->posted_on);
        
                $data['html'] .= "<li>
                    <div class='post-bx'>
                        <div class='d-flex m-b30'>
                            <div class='job-post-company'><a ><span>{$img}</span></a></div>
                            <div class='job-post-info'>
                                <h4><a href='" . url('job-details-view', $id) . "' target='_blank'>" . htmlspecialchars_decode($lists->job_title) . "</a></h4>
                                <div class='company-name-url'>
                                    <span>" . htmlspecialchars_decode($lists->company_name) . "</span>
                                </div>
                                <ul>
                                    <li><i class='fa-solid fa-briefcase'></i>" . $lists->experiance . " </li>
                                    <li><i class='fas fa-map-marker-alt'></i>" . $lists->location_hiring_name . "</li>
                                    <li><i class='far fa-clock'></i> Published " . $duration . " ago</li>
                                </ul>
                            </div>
                        </div>
                        <div class='d-flex'>
                            <div class='job-time me-auto'><a><span>" . $lists->job_type_name . "</span></a>  ";
        
                // Skills
                $skill = explode(',', $lists->skill_keyword);
                $skills = multiSelectDropdown('key_skills', ['id','key_skill_name'], $skill);
                foreach ($skills as $key_skill) {
                    if (isset($key_skill[0]->key_skill_name)) {
                        $data['html'] .= "<span style='margin-right: 7px;'>{$key_skill[0]->key_skill_name}</span>";
                    }
                }
                $data['html'] .= "</div></div>";
        
                $data['html'] .= "<div class='salary-bx'><span>{$sal}</span></div>
                        {$saved}
                    </div>
                </li>";
            }
        }else {
            $data['html'] .= "<li>
			<div class='post-bx'>
				<div class='d-flex m-b30'>
					<div class='job-post-info'>
						<ul>
							<li><h4>No Jobs Found</h4></li>
						</ul>
					</div>
				</div>
			</div>
		</li>";
        }

        if ($req->ajax()) {
            return $data;
        } else {
            return view('browse-all-jobs', $data);
        }
    }


    public function buy_plan($plan, $amount)
    {


        if (isset($plan) && !empty($plan) && isset($amount) && !empty($plan) && session()->has('emp_username') || session()->has('js_username')) {


            if (session()->has('js_username')) {
                $username = session()->get('js_username');
                $table = 'jobseeker_view';
                $select = ['js_id', 'fullname', 'dob'];
                $where = ['email' => $username, 'is_delete' => 'No'];
            } elseif (session()->has('emp_username')) {
                $username = session()->get('emp_username');
                $table = 'employer_view';
                $select = ['id', 'fullname'];
                $where = ['email' => $username, 'is_deleted' => 'No'];
            } else {

                return redirect()->back()->with('msg', 'Someting Went Wrong');
            }

            $userData = getData($table, $select, $where);

            $id = !empty($userData[0]->id) ? base64_encode($userData[0]->id) : base64_encode($userData[0]->js_id);
            $fullname = $userData[0]->fullname;
            $dob = isset($userData[0]->dob) ? $userData[0]->dob : 'NA';
            $order_id = $this->currentDate->format('YmdHis');
            try {
                $payex = $amount * 100;
                $data = [
                    "provider" => "OMK",
                    "payment_destination" => "oliasi-malta",
                    "amount" => $payex,
                    "callback_url" => env('APP_URL'),
                    "callback_id" => $order_id,
                    "return_cta" => env('APP_URL'),
                    "return_cta_name" => "Return to Angel-Jobs.mt",
                    "dynamic_fields" => [
                        "student_id" => $id,
                        "student_first_name" => $fullname,
                        "student_last_name" => ' ',
                        "student_date_of_birth" => $dob,
                        "student_email" => $username,
                    ]

                ];

                $headers = Http::withHeaders([
                    'X-Flywire-Digest' => 'G6kcHrGlKQGepZMsQ5IVfaykeLW5cwSgGmbz5HMwYHM=',
                    'Content-Type' => 'application/json',
                ]);
                $dataresps = $headers->post('https://gateway.flywire.com/v1/transfers.json', $data);

                $url = $dataresps->json();
                $pay_url =  $dataresps['url'];

                if (isset($pay_url) && !empty($pay_url)) {

                    try {

                        $user_id = session()->get('emp_user_id') ?? session()->get('js_user_id');
                        $exists = is_exist($table, $where);


                        if ($exists === 1 && session()->has('js_username')) {

                            $data = ['order_id' => $order_id, 'js_id' => $user_id, 'plan_id' => $plan, 'pay_method' => 'Flywire', 'payment_amount' => $amount, 'status' => 1, 'created_at' => $this->time];

                            $create = JsPayement::insertGetId($data);
                        } elseif (
                            $exists === 1 && session()->has('emp_username')
                        ) {

                            $data = ['order_id' => $order_id, 'emp_id' => $user_id, 'plan_id' => $plan, 'pay_method' => 'Flywire', 'payment_amount' => $amount, 'status' => 1, 'created_at' => $this->time];
                            $create = EmpPayments::insertGetId($data);
                        }

                        if (isset($create) && $create > 0) {
                            // mail_send(9, ['#Name#', '#Cat#'], ['', $cat], session()->get('emp_username'));
                            return redirect($pay_url);
                        } else {
                            return redirect()->back()->with('msg', 'Something Went Wrong1');
                        }
                    } catch (\Throwable $th) {
                        // return "Someting Went Wrong" . $th;
                        return redirect()->back()->with('msg', 'Something Went Wrong');
                    }
                }
            } catch (\Throwable $th) {
                // return "Someting Went Wrong" . $th;
                // return "1 ";
                redirect()->back()->with('msg', 'Something Went Wrong3');
            }
        } else {
            // return "2";
            redirect()->back()->with('msg', 'Something Went Wrong4');
        }
    }
    public function filter_list(Request $req)
    {
        if (!empty($req->all())) {


            if ($req->list === '1') {
                $query =  DB::table('qualifications')->select('educational_qualification', 'id')->where('educational_qualification', 'like', '%' . $req->keyup_val . '%');
            }

            if ($req->list === '2') {
                $query =  DB::table('industries')->select('industries_name', 'id')->where('industries_name', 'like', '%' . $req->keyup_val . '%');
            }
            if ($req->list === '3') {
                $query =  DB::table('cities')->select('city_name', 'id')->where('city_name', 'like', '%' . $req->keyup_val . '%')->where('country_id', 32);
            }

            if ($req->list === '4') {
                $query =  DB::table('designations')->select('role_name', 'id')->where('role_name', 'like', '%' . $req->keyup_val . '%');
            }

            $data = $query->get();


            $html = '';
            $class = '';
            foreach ($data as $list) {
                if ($req->list === '1') {
                    $class = 'main_edu_list';
                    $html .= "<div class='form-check old_list'>
						<input class='form-check-input edu_fil' name='left_edu_fil[]' id='education$list->id'
							type='checkbox' value='$list->id'>
						<label class='form-check-label' for='education$list->id'
							id='left_edu_fil'>$list->educational_qualification
						</label>
					</div>";
                }
                if ($req->list === '2') {
                    $class = 'main_indus_list';
                    $html .= "<div class='form-check old_list'>
						<input class='form-check-input indus_fil' name='left_indus_fil[]' id='industry$list->id'
							type='checkbox' value='$list->id'>
						<label class='form-check-label' for='industry$list->id'
							id='left_indus_fil'>$list->industries_name
						</label>
					</div>";
                }
                
                if ($req->list === '3') {
                    $class = 'main_city_list';
                    $html .= "<div class='form-check old_list'>
						<input class='form-check-input loc_fil' name='left_loc_fil[]' id='location$list->id'
							type='checkbox' value='$list->id'>
						<label class='form-check-label' for='location$list->id'
							id='left_loc_fil'>$list->city_name
						</label>
					</div>";
                }

                if ($req->list === '4') {
                    $class = 'main_desig_list';
                    $html .= "<div class='form-check old_list'>
						<input class='form-check-input desig_fil' name='left_desig_fil[]' id='desig$list->id'
							type='checkbox' value='$list->id'>
						<label class='form-check-label' for='desig$list->id'
							id='left_desig_fil'>$list->role_name
						</label>
					</div>";
                }

            }

            return json_encode(['code' => 200, 'html' => $html, 'class' => $class]);
        }
    }
    public function newLetter(Request $req)
    {
        if ($req->isMethod('POST') && $req->ajax()) {
            $email = isset($req->email) ? $req->email : 'Invalid';
            $exists = DB::table('newsletter')->where('mail', $email)->count();


            if ($exists === 0) {
                try {
                    $mail = DB::table('newsletter')->insert(['mail' => $email]);
                    echo json_encode(['code' => 200, 'message' => 'Successfully Subscribed',  "icon" => "success"]);
                } catch (\Exception $e) {
                    echo json_encode(['code' => 205, 'message' => 'Unable to Subscribe', 'text' => "", "icon" => "error"]);
                }
            } else {

                echo json_encode(['code' => 205, 'message' => 'Invalid OR Duplicate Email', 'text' => "", "icon" => "error"]);
            }
        }
    }
    public function grivance(Request $req)
    {

        if ($req->isMethod('POST') && !empty($req->all())) {

            $name = isset($req->name) ? $req->input('name') : '';
            $country_code = isset($req->country_code) ? $req->input('country_code') : '';
            $contact_no = isset($req->contact_no) ? $req->input('contact_no') : '';
            $email = isset($req->email) ? $req->input('email') : '';
            $address = isset($req->address) ? $req->input('address') : '';
            $report_url = isset($req->report_url) ? $req->input('report_url') : '';
            $date_oc = isset($req->date_oc) ? $req->input('date_oc') : '';
            $confirm = isset($req->confirm) ? $req->input('confirm') : 'No';
            $message = isset($req->message) ? $req->input('message') : '';
            $tnc = isset($req->tnc) ? $req->input('tnc') : 'No';


            $grfile = $req->has('grfile') ? $req->file('grfile') : '';
            $grfile_name = $req->hasFile('grfile') ? time() . "." . $grfile->getClientOriginalExtension() :  'NA';

            $rules = [
                'name' => 'required|min:3',
                'country_code' => 'required',
                'contact_no' => 'required',
                'grfile' => 'max:3072',
            ];

            $validate = Validator::make($req->only(['name', 'country_code', 'contact_no', 'grfile']), $rules);
            if (!$validate->fails()) {

                if ($req->hasFile('grfile')) {
                    $logo_uploaded = file_upload($req->file('grfile'), 'storage/grivance_doc', $grfile_name, '');
                }
                // if ($logo_uploaded === TRUE) {
                try {
                    DB::table('grievance')->insert(['name' => $name, 'country_code' => $country_code, 'contact_no' => $contact_no, 'email' => $email, 'address' => $address, 'report_url' => $report_url, 'date_oc' => $date_oc, 'confirm' => $confirm, 'message' => $message, 'tnc' => $tnc]);


                    // mail_send(9, ['#Name#', '#Cat#'], ['', $cat], session()->get('emp_username'));
                    return  redirect()->back()->with(['code' => 200, 'message' => 'Successfully Submitted']);
                } catch (\Exception $e) {
                    return  redirect()->back()->with(['code' => 201, 'message' => 'Unable to Upload', 'text' => "Try Again", "icon" => "error"]);
                }
            } else {
                return redirect()->back()->with(['code' => 203, 'message' => 'Invalid File', 'text' => "File Should be JPG, PNG & Less then 3MB", "icon" => "error"]);
            }
        }
    }
}