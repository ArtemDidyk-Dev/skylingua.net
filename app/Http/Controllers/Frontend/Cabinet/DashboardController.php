<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Pay\PayOut;
use App\Models\Project\ProjectHireds;
use App\Models\Project\Projects;
use App\Models\ProjectProposals;
use App\Models\User;
use App\Services\CommonService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __construct()
    {

    }

    public function index(Request $request)
    {
     
        $user_id = (int)Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
       
        if ($user->role_id == 3) {
            return redirect()->route('frontend.dashboard.employer');
        } else {
           
            return redirect()->route('frontend.dashboard.freelancer');
        }
    }

    public function employer(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        $projects_count = [
            'allProjects' => 0,
            'pendingProjects' => 0,
            'ongoingProjects' => 0,
            'completedProjects' => 0,
            'cancelledProjects' => 0,
        ];

        $projects_percent = [
            'allProjects' => 0,
            'pendingProjects' => 0,
            'ongoingProjects' => 0,
            'completedProjects' => 0,
            'cancelledProjects' => 0,
        ];

        for ($i=1; $i <= 12; $i++) {
            $mountly_counts[$i] = 0;
        }

        $allProjects = 0;
        $pendingProjects = 0;
        $ongoingProjects = 0;
        $completedProjects = 0;
        $cancelledProjects = 0;

        $project_filter = [
            'language_id' => $request->languageID,
            'employer_id' => $user_id,
        ];
        $projects = Projects::getTotalProjects($project_filter);
        $allProjects = count($projects);
        if ($projects && $allProjects > 0) {
            foreach ($projects as $project) {

                for ($i=1; $i <= 12; $i++) {
                    $mountly_counts[$i] = ($i == Carbon::parse($project->created_at)->format('n') ? $mountly_counts[$i]+1 : $mountly_counts[$i]);
                }

                if ($project->status == 2) { $pendingProjects++; }
                if ($project->status == 3) { $ongoingProjects++; }
                if ($project->status == 4) { $completedProjects++; }
                if ($project->status == 5) { $cancelledProjects++; }

            }

            $projects_count = [
                'allProjects' => $allProjects,
                'pendingProjects' => $pendingProjects,
                'ongoingProjects' => $ongoingProjects,
                'completedProjects' => $completedProjects,
                'cancelledProjects' => $cancelledProjects,
            ];

            $projects_percent = [
                'pendingProjects' => 100*(int)$pendingProjects/$allProjects,
                'ongoingProjects' => 100*(int)$ongoingProjects/$allProjects,
                'completedProjects' => 100*(int)$completedProjects/$allProjects,
                'cancelledProjects' => 100*(int)$cancelledProjects/$allProjects,
            ];
        }

//        @dd($mountly_counts);


        $project_filter = [
            'language_id' => $request->languageID,
            'employer_id' => $user_id,
        ];
        $getProjects = Projects::getProjects($project_filter);
        $projects = [];
        if ($getProjects) {
            foreach ($getProjects as $getProject) {
                $getProject->user_country_image = $getProject->user_country_image ? asset($getProject->user_country_image) : "";
                $getProject->links = $getProject->links ? json_decode($getProject->links) : [];
                $getProject->description = $getProject->description ? htmlspecialchars($getProject->description) : "";
                $getProject->price = $getProject->price ? number_format($getProject->price, 2, ".", " ") : 0;
                $getProject->proposals_count = 0;
                $getProposalsCount = ProjectProposals::getProposalsCountByProjectId($getProject->id);
                if ($getProposalsCount) {
                    $getProject->proposals_count = $getProposalsCount;
                }

                $projects[] = $getProject;
            }
        }

//        @dd($projects);



        return view('frontend.dashboard.employer.dashboard', compact(
            'auth_user',
            'user',
            'projects_count',
            'mountly_counts',
            'projects_percent',
            'projects'
        ));

    }

    public function freelancer(Request $request)
    {
       
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;

        $projects_count = [
            'allProjects' => 0,
            'myProposals' => 0,
            'ongoingProjects' => 0,
            'completedProjects' => 0,
            'cancelledProjects' => 0,
        ];

        $projects_percent = [
            'allProjects' => 0,
            'myProposals' => 0,
            'ongoingProjects' => 0,
            'completedProjects' => 0,
            'cancelledProjects' => 0,
        ];

        for ($i=1; $i <= 12; $i++) {
            $mountly_counts[$i] = 0;
        }

        $allProjects = 0;
        $myProposals = 0;
        $ongoingProjects = 0;
        $completedProjects = 0;
        $cancelledProjects = 0;

        $project_filter = [
            'language_id' => $request->languageID,
            'freelancer_id' => $user_id,
            'project_hired' => true,
        ];
        $projects = Projects::getTotalProjects($project_filter);
        $allProjects = count($projects);
        if ($projects && $allProjects > 0) {

            $proposals = ProjectProposals::getProposals($user_id);
            if ($proposals) {
                $myProposals = count($proposals);
            }


            foreach ($projects as $project) {

                for ($i=1; $i <= 12; $i++) {
                    $mountly_counts[$i] = ($i == Carbon::parse($project->created_at)->format('n') ? $mountly_counts[$i]+1 : $mountly_counts[$i]);
                }

                if ($project->status == 3) { $ongoingProjects++; }
                if ($project->status == 4) { $completedProjects++; }
                if ($project->status == 5) { $cancelledProjects++; }

            }

            $projects_count = [
                'allProjects' => $allProjects,
                'myProposals' => $myProposals,
                'ongoingProjects' => $ongoingProjects,
                'completedProjects' => $completedProjects,
                'cancelledProjects' => $cancelledProjects,
            ];

            $projects_percent = [
                'myProposals' => 100*(int)$myProposals/$allProjects,
                'ongoingProjects' => 100*(int)$ongoingProjects/$allProjects,
                'completedProjects' => 100*(int)$completedProjects/$allProjects,
                'cancelledProjects' => 100*(int)$cancelledProjects/$allProjects,
            ];
        }




        $hired_project_filter = [
            'language_id' => $request->languageID,
            'freelancer_id' => $user_id,
            'project_hired' => true,
            'status' => 2,
            'limit' => 5
        ];
        $getHiredProjects = Projects::getProjects($hired_project_filter);
        $hired_projects = [];
        if ($getHiredProjects) {
            foreach ($getHiredProjects as $getHiredProject) {
                $getHiredProject->user_country_image = $getHiredProject->user_country_image ? asset($getHiredProject->user_country_image) : "";
                $getHiredProject->links = $getHiredProject->links ? json_decode($getHiredProject->links) : [];
                $getHiredProject->description = $getHiredProject->description ? htmlspecialchars($getHiredProject->description) : "";
                $getHiredProject->price = $getHiredProject->price ? number_format($getHiredProject->price, 2, ".", " ") : 0;
                $getHiredProject->proposals_count = 0;
                $getProposalsCount = ProjectProposals::getProposalsCountByProjectId($getHiredProject->id);
                if ($getProposalsCount) {
                    $getHiredProject->proposals_count = $getProposalsCount;
                }

                $hired_projects[] = $getHiredProject;
            }
        }

//        @dd($hired_projects);




        $project_filter = [
            'language_id' => $request->languageID,
            'freelancer_id' => $user_id,
            'project_hired' => true,
            'status' => 3,
            'limit' => 5
        ];
        $getProjects = Projects::getProjects($project_filter);
        $projects = [];
        if ($getProjects) {
            foreach ($getProjects as $getProject) {
                $getProject->user_country_image = $getProject->user_country_image ? asset($getProject->user_country_image) : "";
                $getProject->links = $getProject->links ? json_decode($getProject->links) : [];
                $getProject->description = $getProject->description ? htmlspecialchars($getProject->description) : "";
                $getProject->price = $getProject->price ? number_format($getProject->price, 2, ".", " ") : 0;
                $getProject->proposals_count = 0;
                $getProposalsCount = ProjectProposals::getProposalsCountByProjectId($getProject->id);
                if ($getProposalsCount) {
                    $getProject->proposals_count = $getProposalsCount;
                }

                $projects[] = $getProject;
            }
        }


        $pays = PayOut::getByUserIdNoStatus($user_id, 5);
        if ($pays) {
            foreach ($pays as $pay_key => $pay) {

                if($pay->status == 4) {
                    $pay->status_text = '<span class="badge bg-success-light">'. language('frontend.common.success') .'</span>';
                } elseif($pay->status == 3) {
                    $pay->status_text = '<span class="badge bg-warning-light">'. language('frontend.common.progress') .'</span>';
                } elseif($pay->status == 2) {
                    $pay->status_text = '<span class="badge bg-danger-light">'. language('frontend.common.error') .'</span>';
                } else {
                    $pay->status_text = '<span class="badge bg-info-light">'. language('frontend.common.created') .'</span>';
                }

                $diffInDays = \Carbon\Carbon::parse($pay->created_at)->diffInDays();
                $showDiff = \Carbon\Carbon::parse($pay->created_at)->diffForHumans();
                if($diffInDays > 0) {
                    $showDiff .= ', ' . \Carbon\Carbon::parse($pay->created_at)->addDays($diffInDays)->diffInHours() . ' Hours';
                }

                $pay->date = $showDiff;

                $pays[$pay_key] = $pay;

            } // foreach
        } // if

  
        return view('frontend.dashboard.freelancer.dashboard', compact(
            'auth_user',
            'user',
            'projects_count',
            'mountly_counts',
            'projects_percent',
            'hired_projects',
            'projects',
            'pays'
        ));

    }

}
