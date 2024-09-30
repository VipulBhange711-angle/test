<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class jobseeker extends Model
{
 
    use HasFactory;
    protected $fillable = [
        'fullname',
        'email',
        'email_verified',
        'mob_code',
        'mobile',
        'reset_token',
        'password',
        'created_at'
    ];

    public function profileDetails($job_id = '')
    {


        $username =  Session::has('js_username') ? Session::get('js_username') : $job_id;
        $select = [
            'fullname', 'email', 'mob_code', 'mobile',  'curr_salary', 'role_name', 'skill', 'prefered_location', 'prefered_location_name', 'total_exp_year', 'total_exp_month', 'functional_area', 'functional_name', 'proflie_summary', 'dob', 'gender', 'martial_status_name', 'martial_status', 'nationality', 'country_name', 'country', 'city_name', 'city', 'postal_code', 'full_address', 'facebook_link', 'insta_link', 'twitter_link', 'linkedin', 'expected_salary', 'industries_name', 'industry', 'designaiton',
            'passport_no',
            'pref_job_type_name',
            'pref_indus_name',
            'work_permit',
            'lang_skills',
            'notice_name',
            'is_hadicaped',
            'prefered_job_type',
            'notice_period',
            'prefered_industry',
            'prefered_industry',
            'resume_link',
            'profile_img',
            'expected_salary_name',
            'experiance_name',
            'work_desination_name'
        ];
        $query = DB::table('jobseeker_view')->select($select);
        
        if (isset($job_id) && !empty($job_id)) {
            $query->where('js_id', $job_id);
        } else {
            $query->where('email', $username);
        }
        
        $jobseekerData =  $query->get();
        return $jobseekerData;
    }
    public function eduDetails($job_id = '')
    {
        $username =  Session::has('js_username') ? Session::get('js_username') : $job_id;
        $select = ['qul_id', 'professional_title', 'specilization', 'passing_year', 'qual_name', 'institute_name'];
        $query = DB::table('jobseeker_view')->select($select);
        if (isset($job_id) && !empty($job_id)) {
            $query->where('js_id', $username);
        } else {
            $query->where('email', $username);
        }
        $jobseekerData =  $query->get();
        return $jobseekerData;
    }
    public function expDetails($job_id = '')
    {
        $username =  Session::has('js_username') ? Session::get('js_username') : $job_id;
        $select = ['company_name', 'annual_salary', 'joining_date', 'ending_date', 'work_industry_id', 'work_industry_name', 'work_desination_id', 'work_desination_name', 'total_exp_year'];
        $query = DB::table('jobseeker_view')->select($select);
        if (isset($job_id) && !empty($job_id)) {
            $query->where('js_id', $username);
        } else {
            $query->where('email', $username);
        }
        $jobseekerData =  $query->get();
        return $jobseekerData;
    }
    public function searchJobseeker($curr_date, $req, $filters = '')
    {

        $select = [
            'js_id', 'fullname', 'email', 'mob_code', 'mobile',  'curr_salary', 'role_name', 'skill', 'prefered_location', 'prefered_location_name', 'total_exp_year', 'total_exp_month', 'functional_area', 'functional_name', 'proflie_summary', 'dob', 'gender', 'martial_status_name', 'martial_status', 'nationality', 'country_name', 'country', 'city_name', 'city', 'postal_code', 'full_address', 'facebook_link', 'insta_link', 'twitter_link', 'linkedin', 'expected_salary', 'industries_name', 'industry', 'designaiton',
            'passport_no',
            'pref_job_type_name',
            'pref_indus_name',
            'work_permit',
            'lang_skills',
            'notice_name',
            'is_hadicaped',
            'prefered_job_type',
            'notice_period',
            'prefered_industry',
            'prefered_industry',
            'resume_link',
            'profile_img',
            'expected_salary_name',
            'experiance_name',
            'work_desination_name',
            'company_name',
            'updated_at'
        ];
        $query = DB::table('jobseeker_view')
        ->select($select)->where('is_delete', 'No')->orderBy('updated_at', 'DESC');


        // // Main Filters Search Bar
        // if (isset($req->search_skills) && is_array($req->search_skills)) {
        //     $query->where(function ($q) use ($req) {
        //         foreach ($req->search_skills as $searchSkill) {
        //             $q->orWhere('skill_keyword', 'like', '%' . $searchSkill . '%');
        //         }
        //     });
        // } else {
        //     $query->whereNotNull('skill_keyword');
        // }

        // if (isset($req->search_city) && is_array($req->search_city)) {
        //     // $query->where('location_hiring', $search_city);
        //     $query->whereIn(
        //         'location_hiring',
        //         $req->search_city
        //     );
        // } else {
        //     $query->whereNotNull('location_hiring');
        // }

        // if (isset($req->search_job_type) && is_array($req->search_job_type)) {
        //     $query->whereIn('job_type', $req->search_job_type);
        // } else {
        //     $query->whereNotNull('job_type');
        // }

        // // Left Filters


        // Job Type Filter
        if (isset($filters['job_type_fil']) && $filters['job_type_fil'] != 0) {
            $query->whereIn('prefered_job_type', $filters['job_type_fil']);
        } else {
            $query->whereNotNull('prefered_job_type');
        }


        // Educations filter
        if (isset($filters['edu_fil']) &&  $filters['edu_fil'] != 0) {

            $edu_fil[] = $filters['edu_fil'];
            foreach ($edu_fil as $key) {
                $query->whereIn('qul_id', $key);
            }
        } else {
            $query->whereNotNull('qul_id');
        }

        // Notice Period Filter 

        if (isset($filters['notice_fil']) &&  $filters['notice_fil'] != 0) {

            $indus_fil[] = $filters['notice_fil'];
            foreach ($indus_fil as $key) {
                $query->whereIn('notice_period', $key);
            }
        } else {
            $query->whereNotNull('notice_period');
        }
        // Location filter
        if (isset($filters['loc_fil']) && !empty($filters['loc_fil'])) {
            $query->whereIn('prefered_location', $filters['loc_fil']);
        } else {
            $query->whereNotNull('prefered_location');
        }



        // Expriance Filter
        if (isset($filters['exp_fil']) && $filters['exp_fil'] != 0) {
            $query->where('total_exp_year', $filters['exp_fil']);
        } else {
            $query->whereNotNull('total_exp_year');
        }
        // Salary Filter
        if (isset($filters['sal_fil']) && $filters['sal_fil'] != 0) {
            $query->whereIn('expected_salary', $filters['sal_fil']);
        }

        return  $query;
    }

}