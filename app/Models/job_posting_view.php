<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class job_posting_view extends Model
{
    use HasFactory;
    public $table = 'job_posting_view';

    public function topSearchJobs($curr_date, $req, $filters = '')
    {
       
        $query = DB::table('job_posting_view')
        ->select('id', 'job_title', 'location_hiring', 'job_type_name', 'start_date', 'location_hiring_name', 'country', 'job_salary_to_name', 'profile_img', 'company_name', 'experiance', 'posted_on', 'salary_hide', 'posted_by','key_skill_name','skill_keyword')->where('status', 'Live')->where('is_deleted', 'No')->where('job_expired_on', '>=', $curr_date)->orderBy('posted_on', 'DESC');

        // print_r($query->all());
        // exit;

        // Main Filters Search Bar
        if (isset($req->search_skills) && is_array($req->search_skills)) {
            $query->where(function ($q) use ($req) {
                foreach ($req->search_skills as $searchSkill) {
                    $q->orWhere('skill_keyword', 'like', '%' . $searchSkill . '%');
                }
            });
        } else {
            $query->whereNotNull('skill_keyword');
        }

        if (isset($req->search_city) && is_array($req->search_city)) {
            // $query->where('location_hiring', $search_city);
            $query->whereIn(
                'location_hiring',
                $req->search_city
            );
        } else {
            $query->whereNotNull('location_hiring');
        }

        if (isset($req->search_job_type) && is_array($req->search_job_type)) {
            $query->whereIn('job_type', $req->search_job_type);
        } else {
            $query->whereNotNull('job_type');
        }

        // Left Filters


        // Job Type Filter
        if (isset($filters['job_type_fil']) && $filters['job_type_fil'] != 0) {
            $query->whereIn('job_type', $filters['job_type_fil']);
        } else {
            $query->whereNotNull('job_type');
        }


        // Educations filter
        if (isset($filters['edu_fil']) &&  $filters['edu_fil'] != 0) {

            $edu_fil[] = $filters['edu_fil'];
            foreach ($edu_fil as $key) {
                $query->whereIn('job_education', $key);
            }
        } else {
            $query->whereNotNull('job_education');
        }

        // Industry Filter 

        if (isset($filters['indus_fil']) &&  $filters['indus_fil'] != 0) {

            $indus_fil[] = $filters['indus_fil'];
            foreach ($indus_fil as $key) {
                $query->whereIn('job_industry', $key);
            }
        } else {
            $query->whereNotNull('job_industry');
        }
        // Location filter
        if (isset($filters['loc_fil']) && !empty($filters['loc_fil'])) {
            $query->whereIn('location_hiring', $filters['loc_fil']);
        } else {
            $query->whereNotNull('location_hiring');
        }

        // designation Filter
        // if (isset($filters['desig_fil']) && $filters['desig_fil'] != 0) {
        //     $query->where('job_designation', $filters['desig_fil']);
        // } else {
        //     $query->whereNotNull('job_designation');
        // }

        // Expriance Filter
        if (isset($filters['exp_fil']) && $filters['exp_fil'] != 0) {
            $query->where('work_experience_from', $filters['exp_fil']);
        } else {
            $query->whereNotNull('work_experience_from');
        }
        // Salary Filter
        if (isset($filters['sal_fil']) && $filters['sal_fil'] != 0) {
            $query->whereIn('job_salary_to', $filters['sal_fil'])->where('salary_hide', 'No');
        } 
 
        
        // designation Filter
        if (isset($filters['desig_fil']) && $filters['desig_fil'] != 0) {
            $query->whereIn('job_designation', $filters['desig_fil']);
        } 
        return  $query;
    }
}