<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectAddRequest;
use App\Http\Requests\Project\ProjectEditRequest;
use App\Http\Requests\Project\ProjectProposalRequest;
use App\Http\Requests\Project\ProjectAcceptCancelRequest;
use App\Models\Country\Country;
use App\Models\Notification\Notification;
use App\Models\Pay\Pay;
use App\Models\Project\ProjectHireds;
use App\Models\Project\Projects;
use App\Models\Project\ProjectsCategories;
use App\Models\ProjectFavourites;
use App\Models\ProjectProposals;
use App\Models\Reviews\Reviews;
use App\Models\Setting\Setting;
use App\Models\User;
use App\Models\UserCategory\UserCategory;
use App\Services\CommonService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isNull;

class ProjectsController extends Controller
{

    public function freelancer(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        $proposals = [];
        $getProposals = ProjectProposals::getProposals($user_id);
        if ($getProposals) {
            foreach ($getProposals as $getProposal) {
                $project_filter = [
                    'language_id' => $request->languageID
                ];
                $getProject = Projects::getProject($getProposal->project_id, $project_filter);
                if ($getProject) {
                    $getProject->name = html_entity_decode($getProject->name, ENT_QUOTES, 'UTF-8');
                    $getProject->user_profile_photo = $getProject->user_profile_photo ? asset('storage/profile/'. $getProject->user_profile_photo) : asset('storage/no-image.jpg');
                    $getProject->price_view = ($getProject->price ? number_format($getProject->price, 2, ".", " ") : 0);
                    $getProject->proposal_price = $getProposal->price;
                    $getProject->proposal_price_view = ($getProposal->price ? number_format($getProposal->price, 2, ".", " ") : 0);
                    $getProject->proposal_hours = $getProposal->hours;
                    $getProject->proposal_letter = $getProposal->letter;
                    $proposals[] = $getProject;
                }
            } // foraech
        } // if


        return view('frontend.dashboard.freelancer.project-proposals', compact(
            'auth_user',
            'user',
            'proposals',
        ));
    }

    public function freelancerProposalStore(ProjectProposalRequest $request)
    {
        $user_id = Auth::id();
        $project_id = (int)$request->project_id;
        $price = (float)$request->price;
        $hours = (int)$request->hours;
        $letter = stripinput(strip_tags($request->letter));
       
        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        if ($user->role_id != 4) {
            return redirect()->back();
        }

        $project_filter = [
            'language_id' => $request->languageID,
            'status' => 1
        ];
        $project = Projects::getProject($project_id, $project_filter);
        if ($project == null) {
            return redirect()->back();
        }


        $proposal = ProjectProposals::getProposal($user_id, $project_id);
        if ($proposal != null) {
            return redirect()->back();
        }


        $data = [
            'freelancer_id' => $user_id,
            'project_id' => $project_id,
            'price' => $price,
            'hours' => $hours,
            'letter' => $letter
        ];
        $proposal = ProjectProposals::addProposals($data);

        return redirect()->route('frontend.dashboard.freelancer.project-proposals')->with('message', language('Project successfully proposaled.'));

    }



    public function freelancerProposalStoreAjax(ProjectProposalRequest $request)
    {
        $success = true;
        $message = "";
        $data = [];
        $user_id = Auth::id();
        $project_id = (int)$request->project_id;
        $price = (float)$request->price;
        $hours = (int)$request->hours;
        $letter = stripinput(strip_tags($request->letter));

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        if ($user->role_id != 4) {

            $success = false;
            $message = language('User roles error.');

            return response()->json([
                'success' => $success,
                'message' => $message
            ]);
        }

        $project_filter = [
            'language_id' => $request->languageID,
            'status' => 1
        ];
        $project = Projects::getProject($project_id, $project_filter);
        if ($project == null) {

            $success = false;
            $message = language('Project not found.');

            return response()->json([
                'success' => $success,
                'message' => $message
            ]);
        }


        $proposal = ProjectProposals::getProposal($user_id, $project_id);
        if ($proposal != null) {

            $success = false;
            $message = language('Your Proposalled.');

            return response()->json([
                'success' => $success,
                'message' => $message
            ]);
        }

        $data = [
            'freelancer_id' => $user_id,
            'project_id' => $project_id,
            'price' => $price,
            'hours' => $hours,
            'letter' => $letter
        ];
        $proposal = ProjectProposals::addProposals($data);

//        dd($proposal);


        $data['proposal_id'] = $proposal->id;
        $data['employer_id'] = $project->employer_id;
        $data['freelancer_id'] = $user_id;
        $data['project_id'] = $project_id;
        $data['project_url'] = route('frontend.pay.link', $proposal->id);

       
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ]);
    }



    public function freelancerProposalEdit(ProjectProposalRequest $request)
    {
        $user_id = Auth::id();
        $project_id = (int)$request->project_id;
        $price = (float)$request->price;
        $hours = (int)$request->hours;
        $letter = stripinput(strip_tags($request->letter));

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        if ($user->role_id != 4) {
            return redirect()->back();
        }

        $project_filter = [
            'language_id' => $request->languageID
        ];
        $project = Projects::getProject($project_id, $project_filter);
        if ($project == null || $project->status != 1) {
            return redirect()->back();
        }

        $data = [
            'freelancer_id' => $user_id,
            'project_id' => $project_id,
            'price' => $price,
            'hours' => $hours,
            'letter' => $letter
        ];
        $proposal = ProjectProposals::editProposals($data);

        return redirect()->route('frontend.dashboard.freelancer.project-proposals')->with('message', language('Proposal successfully edited.'));

    }

    public function freelancerProposalDelete(Request $request)
    {
        $user_id = Auth::id();
        $project_id = (int)$request->id;

        $getProposal = ProjectProposals::getProposal($user_id, $project_id);
        if ($getProposal == null) {
            return redirect()->back();
        }

        $proposal = ProjectProposals::removeProposal($user_id, $project_id);

        return redirect()->route('frontend.dashboard.freelancer.project-proposals')->with('message', language('Proposal successfully deleted.'));

    }

    public function freelancerHireds(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;



        $project_filter = [
            'language_id' => $request->languageID,
            'freelancer_id' => $user_id,
            'project_hired' => true,
            'status' => 2,
        ];
        $getProjects = Projects::getProjects($project_filter);

        $projects = [];
        if ($getProjects) {
            foreach ($getProjects as $getProject) {
                $review_count = Reviews::getReviewsCountByUserId($getProject->employer_id);

                $getProject->user_profile_photo = !empty($getProject->user_profile_photo) ? asset('storage/profile/'. $getProject->user_profile_photo) : asset('storage/no-photo.jpg');
                $getProject->user_country_image = $getProject->user_country_image ? asset($getProject->user_country_image) : "";
                $getProject->links = $getProject->links ? json_decode($getProject->links) : [];
                $getProject->description = $getProject->description ? htmlspecialchars($getProject->description) : "";
                $getProject->price = $getProject->price ? number_format($getProject->price, 2, ".", " ") : 0;
                $getProject->user_created_at_view = Carbon::parse($getProject->user_created_at)->format('M d, Y');
                $getProject->hired_created_at_view = Carbon::parse($getProject->hired_created_at)->format('M d, Y');
                $getProject->hired_updated_at_view = Carbon::parse($getProject->hired_updated_at)->format('M d, Y');
                $getProject->review_count = ($review_count ? $review_count : 0);

                $projects[] = $getProject;
            }
        }

//        @dd($projects);


        return view('frontend.dashboard.freelancer.project-hireds', compact(
            'auth_user',
            'user',
            'projects',
            'getProjects'
        ));
    }

    public function freelancerHiredsAccept(ProjectAcceptCancelRequest $request)
    {
        $user_id = Auth::id();
        $project_id = (int)$request->project_id;


        if(CommonService::userRoleId($user_id) != 4) {
            return redirect()->back();
        }


        $hired = ProjectHireds::getHired($user_id, $project_id);
        if($hired == null) {
            return redirect()->back();
        }

        $project_filter = [
            'language_id' => $request->languageID,
            'status' => 2
        ];
        $project = Projects::getProject($project_id, $project_filter);
        if ($project == null) {
            return redirect()->back();
        }

        Projects::editStatus($project_id, 3);

//        Projects::setFreelancer($project_id, $user_id);

        $data = [
            'freelancer_id' => $user_id,
            'project_id' => $project_id,
            'status' => 1,
            'updated_at' => Carbon::today()
        ];
        ProjectHireds::editHireds($data);

        ProjectProposals::removeProposalsByProjectId($project_id);

        $pay_info = Pay::getByFreelancerIdAndProjectId($user_id, $project_id);
        if($pay_info) {
            $data = [
                'status' => 5
            ];
            $editPay = Pay::editPay($pay_info->id, $data);
        }

        return redirect()->route('frontend.dashboard.freelancer.project-ongoing')->with('message', language('Project successfully accepted.'));

    }

    public function freelancerHiredsComplete(ProjectAcceptCancelRequest $request)
    {
        $user_id = Auth::id();
        $project_id = (int)$request->project_id;


        if(CommonService::userRoleId($user_id) != 4) {
            return redirect()->back();
        }


        $hired = ProjectHireds::getHired($user_id, $project_id);
        if($hired == null) {
            return redirect()->back();
        }

        $project_filter = [
            'language_id' => $request->languageID,
            'status' => 3
        ];
        $project = Projects::getProject($project_id, $project_filter);
        if ($project == null) {
            return redirect()->back();
        }

        Projects::editStatus($project_id, 4);

//        Projects::setFreelancer($project_id, $user_id);

        $data = [
            'freelancer_id' => $user_id,
            'project_id' => $project_id,
            'status' => 2,
            'updated_at' => Carbon::today()
        ];
        ProjectHireds::editHireds($data);

        return redirect()->route('frontend.dashboard.freelancer.project-completed')->with('message', language('Project successfully completed.'));

    }

    public function freelancerHiredsCancel(ProjectAcceptCancelRequest $request)
    {
        $user_id = Auth::id();
        $project_id = (int)$request->project_id;


        if(CommonService::userRoleId($user_id) != 4) {
            return redirect()->back();
        }


        $hired = ProjectHireds::getHired($user_id, $project_id);
        if($hired == null) {
            return redirect()->back();
        }

        $project_filter = [
            'language_id' => $request->languageID,
            'status' => 2
        ];
        $project = Projects::getProject($project_id, $project_filter);
        if ($project == null) {
            return redirect()->back();
        }

        $pay = Pay::getByFreelancerIdAndProjectId($user_id, $project_id);
        if ($pay == null) {
            return redirect()->back();
        }


        $amount = (int)$pay->amount * 100;
        $curl_url = config('pay.base_url') . '/epg/rest/refund.do?userName=' . config('pay.username') . '&password=' . config('pay.password') . '&orderId=' . $pay->orderId . '&amount=' . $amount;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $curl_url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $response_arr = json_decode($response);

//        @dd($response_arr);

        if ($response_arr && $response_arr->errorCode == 0) {
            Projects::editStatus($project_id, 5);

            $data = [
                'freelancer_id' => $user_id,
                'project_id' => $project_id,
                'status' => 3,
                'updated_at' => Carbon::today()
            ];
            ProjectHireds::editHireds($data);

            $data = [
                'status' => 4,
            ];
            Pay::editPay($pay->id, $data);

            $employer_text = language('The freelancer abandoned the project, the money was returned to your account.');
            $freelancer_text = language('You abandoned the project.');

            Notification::addNotification($pay->employer_id, $employer_text, $request->languageID);
            Notification::addNotification($pay->freelancer_id, $freelancer_text, $request->languageID);

        }

        return redirect()->route('frontend.dashboard.freelancer.project-cancelled')->with('message', language('Project successfully cancelled.'));

    }

    public function freelancerOngoing(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;




        $project_filter = [
            'language_id' => $request->languageID,
            'freelancer_id' => $user_id,
            'project_hired' => true,
            'status' => 3,
        ];
        $getProjects = Projects::getProjects($project_filter);

        $projects = [];
        if ($getProjects) {
            foreach ($getProjects as $getProject) {
                $review_count = Reviews::getReviewsCountByUserId($getProject->employer_id);

                $getProject->user_profile_photo = !empty($getProject->user_profile_photo) ? asset('storage/profile/'. $getProject->user_profile_photo) : asset('storage/no-photo.jpg');
                $getProject->user_country_image = $getProject->user_country_image ? asset($getProject->user_country_image) : "";
                $getProject->links = $getProject->links ? json_decode($getProject->links) : [];
                $getProject->description = $getProject->description ? htmlspecialchars($getProject->description) : "";
                $getProject->price = $getProject->price ? number_format($getProject->price, 2, ".", " ") : 0;
                $getProject->user_created_at_view = Carbon::parse($getProject->user_created_at)->format('M d, Y');
                $getProject->hired_created_at_view = Carbon::parse($getProject->hired_created_at)->format('M d, Y');
                $getProject->hired_updated_at_view = Carbon::parse($getProject->hired_updated_at)->format('M d, Y');
                $getProject->review_count = ($review_count ? $review_count : 0);

                $projects[] = $getProject;
            }
        }

//        @dd($projects);


        return view('frontend.dashboard.freelancer.project-ongoing', compact(
            'auth_user',
            'user',
            'projects',
            'getProjects'
        ));
    }

    public function freelancerCompleted(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;

        $project_filter = [
            'language_id' => $request->languageID,
            'freelancer_id' => $user_id,
            'project_hired' => true,
            'status' => 4,
        ];
        $getProjects = Projects::getProjects($project_filter);

        $projects = [];
        if ($getProjects) {
            foreach ($getProjects as $getProject) {
                $review_count = Reviews::getReviewsCountByUserId($getProject->employer_id);
                $review_true = Reviews::getReviewsCountByFromTo($user_id, $getProject->employer_id, $getProject->id);

                $getProject->user_profile_photo = !empty($getProject->user_profile_photo) ? asset('storage/profile/'. $getProject->user_profile_photo) : asset('storage/no-photo.jpg');
                $getProject->user_country_image = $getProject->user_country_image ? asset($getProject->user_country_image) : "";
                $getProject->links = $getProject->links ? json_decode($getProject->links) : [];
                $getProject->description = $getProject->description ? htmlspecialchars($getProject->description) : "";
                $getProject->price = $getProject->price ? number_format($getProject->price, 2, ".", " ") : 0;
                $getProject->user_created_at_view = Carbon::parse($getProject->user_created_at)->format('M d, Y');
                $getProject->hired_created_at_view = Carbon::parse($getProject->hired_created_at)->format('M d, Y');
                $getProject->hired_updated_at_view = Carbon::parse($getProject->hired_updated_at)->format('M d, Y');
                $getProject->review_count = ($review_count ? $review_count : 0);
                $getProject->review_true = ($review_true ? true : false);

                $projects[] = $getProject;
            }
        }

//        @dd($projects);

        return view('frontend.dashboard.freelancer.project-completed', compact(
            'auth_user',
            'user',
            'projects',
            'getProjects'
        ));
    }

    public function freelancerCancelled(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        $project_filter = [
            'language_id' => $request->languageID,
            'freelancer_id' => $user_id,
//            'project_hired' => true,
//            'status' => 5,
        ];
        $getProjects = Projects::getProjects($project_filter);
        $projects = [];
        if ($getProjects) {
            foreach ($getProjects as $getProject) {
                $review_count = Reviews::getReviewsCountByUserId($getProject->employer_id);

                $getProject->user_profile_photo = !empty($getProject->user_profile_photo) ? asset('storage/profile/'. $getProject->user_profile_photo) : asset('storage/no-photo.jpg');
                $getProject->user_country_image = $getProject->user_country_image ? asset($getProject->user_country_image) : "";
                $getProject->links = $getProject->links ? json_decode($getProject->links) : [];
                $getProject->description = $getProject->description ? htmlspecialchars($getProject->description) : "";
                $getProject->price = $getProject->price ? number_format($getProject->price, 2, ".", " ") : 0;
                $getProject->user_created_at_view = Carbon::parse($getProject->user_created_at)->format('M d, Y');
                $getProject->hired_created_at_view = Carbon::parse($getProject->hired_created_at)->format('M d, Y');
                $getProject->hired_updated_at_view = Carbon::parse($getProject->hired_updated_at)->format('M d, Y');
                $getProject->review_count = ($review_count ? $review_count : 0);

                $projects[] = $getProject;
            }
        }

//        @dd($projects);

        return view('frontend.dashboard.freelancer.project-cancelled', compact(
            'auth_user',
            'user',
            'projects',
            'getProjects'
        ));
    }

    public function freelancerCompletedReview(Request $request)
    {
        $user_id = Auth::id();
        $project_id = (int)$request->project_id;
        $rating = (float)$request->rating;
        $review = stripinput(strip_tags($request->review));


        if(CommonService::userRoleId($user_id) != 4) {
            return redirect()->back();
        }


        $hired = ProjectHireds::getHiredByProjectId($project_id);
        if($hired == null || ($hired->status != 2 && $hired->status != 3)) {
            return redirect()->back();
        }


        $project_filter = [
            'language_id' => $request->languageID,
            'freelancer_id' => $user_id,
            'status' => 4,
            'project_hired' => true
        ];
        $project = Projects::getProject($project_id, $project_filter);
        if ($project == null) {
            return redirect()->back();
        }

        $employer_id = $project->employer_id;


        $ReviewsCount = Reviews::getReviewsCount($employer_id, $project_id);
        if ($ReviewsCount) {
            return redirect()->back();
        }

        if ($rating > 0 || !empty($review)) {
            $data = [
                'from' => $user_id,
                'to' => $employer_id,
                'project_id' => $project_id,
                'rating' => $rating,
                'review' => $review,
            ];
            Reviews::addReview($data);
        }


        return redirect()->route('frontend.dashboard.freelancer.project-completed')->with('message', language('Review successfully sended.'));

    }



    public function employer(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        $project_filter = [
            'language_id' => $request->languageID,
            'employer_id' => $user_id,
        ];
        $getProjects = Projects::getProjects($project_filter);
        $projects = [];
        if ($getProjects) {
            foreach ($getProjects as $getProject) {
                $getProject->name = html_entity_decode($getProject->name, ENT_QUOTES, 'UTF-8');
                $getProject->user_country_image = $getProject->user_country_image ? asset($getProject->user_country_image) : "";
                $getProject->links = $getProject->links ? json_decode($getProject->links) : [];
                $getProject->description = $getProject->description ? htmlspecialchars($getProject->description) : "";
                $getProject->price = $getProject->price ? number_format($getProject->price, 2, ".", " ") : 0;
                $getProject->proposals_count = 0;
                $getProposalsCount = ProjectProposals::getProposalsCountByProjectId($getProject->id);
                if ($getProposalsCount) {
                    $getProject->proposals_count = $getProposalsCount;
                }

                $getProject->hired = [];
                if ( $getProject->status >= 2 ) {
                    $getHired = ProjectHireds::getHiredByProjectId($getProject->id);
                    if ($getHired) {
                        $getProject->hired = $getHired;
                    }
                }


                $projects[] = $getProject;
            }
        }

//        @dd($projects);


        return view('frontend.dashboard.employer.projects-all', compact(
            'auth_user',
            'user',
            'projects',
            'getProjects'
        ));
    }

    public function employerPending(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        $project_filter = [
            'language_id' => $request->languageID,
            'employer_id' => $user_id,
            'project_hired' => true,
            'status' => 2
        ];
        $getProjects = Projects::getProjects($project_filter);
        $projects = [];
        if ($getProjects) {
            foreach ($getProjects as $getProject) {
                $getProject->user_country_image = $getProject->user_country_image ? asset($getProject->user_country_image) : "";
                $getProject->links = $getProject->links ? json_decode($getProject->links) : [];
                $getProject->description = $getProject->description ? htmlspecialchars($getProject->description) : "";
                $getProject->price = $getProject->price ? number_format($getProject->price, 2, ".", " ") : 0;

                $getProject->hired = [];
                if ( $getProject->status >= 2 ) {
                    $getHired = ProjectHireds::getHiredByProjectId($getProject->id);
                    if ($getHired) {
                        $getProject->hired = $getHired;
                    }
                }


                $projects[] = $getProject;
            }
        }


//        @dd($projects);


        return view('frontend.dashboard.employer.projects-pending', compact(
            'auth_user',
            'user',
            'projects',
            'getProjects'
        ));
    }

    public function employerOngoing(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;

        $project_filter = [
            'language_id' => $request->languageID,
            'employer_id' => $user_id,
            'project_hired' => true,
            'status' => 3
        ];
        $getProjects = Projects::getProjects($project_filter);
        $projects = [];
        if ($getProjects) {
            foreach ($getProjects as $getProject) {
                $getProject->user_country_image = $getProject->user_country_image ? asset($getProject->user_country_image) : "";
                $getProject->links = $getProject->links ? json_decode($getProject->links) : [];
                $getProject->description = $getProject->description ? htmlspecialchars($getProject->description) : "";
                $getProject->price = $getProject->price ? number_format($getProject->price, 2, ".", " ") : 0;

                $getProject->hired = [];
                if ( $getProject->status >= 2 ) {
                    $getHired = ProjectHireds::getHiredByProjectId($getProject->id);
                    if ($getHired) {
                        $getProject->hired = $getHired;
                    }
                }


                $projects[] = $getProject;
            }
        }


        return view('frontend.dashboard.employer.projects-ongoing', compact(
            'auth_user',
            'user',
            'projects',
            'getProjects'
        ));
    }

    public function employerCompleted(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        $project_filter = [
            'language_id' => $request->languageID,
            'employer_id' => $user_id,
            'project_hired' => true,
            'status' => 4
        ];
        $getProjects = Projects::getProjects($project_filter);
        $projects = [];
        if ($getProjects) {
            foreach ($getProjects as $getProject) {
                $getProject->user_country_image = $getProject->user_country_image ? asset($getProject->user_country_image) : "";
                $getProject->links = $getProject->links ? json_decode($getProject->links) : [];
                $getProject->description = $getProject->description ? htmlspecialchars($getProject->description) : "";
                $getProject->price = $getProject->price ? number_format($getProject->price, 2, ".", " ") : 0;

                $getProject->hired = [];
                if ( $getProject->status >= 2 ) {
                    $getHired = ProjectHireds::getHiredByProjectId($getProject->id);
                    if ($getHired) {
                        $getProject->hired = $getHired;
                    }
                }


                $projects[] = $getProject;
            }
        }

        return view('frontend.dashboard.employer.projects-completed', compact(
            'auth_user',
            'user',
            'projects',
            'getProjects'
        ));
    }

    public function employerCancelled(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;

        $project_filter = [
            'language_id' => $request->languageID,
            'employer_id' => $user_id,
            'project_hired' => true,
            'status' => 5
        ];
        $getProjects = Projects::getProjects($project_filter);
        $projects = [];
        if ($getProjects) {
            foreach ($getProjects as $getProject) {
                $getProject->user_country_image = $getProject->user_country_image ? asset($getProject->user_country_image) : "";
                $getProject->links = $getProject->links ? json_decode($getProject->links) : [];
                $getProject->description = $getProject->description ? htmlspecialchars($getProject->description) : "";
                $getProject->price = $getProject->price ? number_format($getProject->price, 2, ".", " ") : 0;

                $getProject->hired = [];
                if ( $getProject->status >= 2 ) {
                    $getHired = ProjectHireds::getHiredByProjectId($getProject->id);
                    if ($getHired) {
                        $getProject->hired = $getHired;
                    }
                }


                $projects[] = $getProject;
            }
        }

        return view('frontend.dashboard.employer.projects-cancelled', compact(
            'auth_user',
            'user',
            'projects',
            'getProjects'
        ));
    }

    public function employerProposals(Request $request)
    {
        $user_id = Auth::id();
        $project_id = (int)$request->id;

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        $project_filter = [
            'language_id' => $request->languageID,
            'status' => 1
        ];
        $project = Projects::getProject($project_id, $project_filter);
        if ($project == null) {
            return redirect()->back();
        }


        $project->user_country_image = $project->user_country_image ? asset($project->user_country_image) : "";
        $project->price_view = $project->price ? number_format($project->price, 2, ".", " ") : 0;


        $project->proposals_count = 0;
        $getProposalsCount = ProjectProposals::getProposalsCountByProjectId($project->id);
        if ($getProposalsCount) {
            $project->proposals_count = $getProposalsCount;
        }


        $projects_categories_filter = [
            'language_id' => $request->languageID,
        ];
        $project->projects_categories = [];
        $projects_categories = ProjectsCategories::get($project_id, $projects_categories_filter);
        if ($projects_categories) {
            $project->projects_categories = $projects_categories;
        }


        $getProposals = ProjectProposals::getProposalsByProjectId($project_id);
        $proposals = [];
        if ($getProposals) {
            foreach ($getProposals as $proposal) {
                $proposal->user_profile_photo = !empty($proposal->user_profile_photo) ? asset('storage/profile/'. $proposal->user_profile_photo) : asset('storage/no-photo.jpg');
                $proposal->price_view = ($proposal->price ? number_format($proposal->price, 2, ".", " ") : 0);
                $proposal->updated_at_view = Carbon::parse($proposal->updated_at)->format('M d, Y');
                $proposals[] = $proposal;
            }
        }



        return view('frontend.dashboard.employer.projects-proposals', compact(
            'auth_user',
            'user',
            'project',
            'proposals'
        ));
    }

    public function employerProjectAdd(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        $userCategories_filter = [
            'languageID' => $request->languageID,
            'limit' => 9999,
            'role_id' => 4
        ];
        $user_categories = UserCategory::getUserCategories($userCategories_filter);


        $countries_filter = [
            'languageID' => $request->languageID,
            'limit' => 9999,
        ];
        $countries = Country::getCountries($countries_filter);


        return view('frontend.dashboard.employer.projects-add', compact(
            'auth_user',
            'user',
            'user_categories',
            'countries'
        ));

    }

    public function employerProjectStore(ProjectAddRequest $request)
    {
        $user_id = Auth::id();

        $country_id = (int)$request->country_id;
        $name = stripinput($request->name);
        $price_type = (int)$request->price_type;
        $price = (float)$request->price;
        $deadline = stripinput($request->deadline);
        $links = $request->links;
        $userCategoryID = $request->user_category_id;
        $description = htmlentities($request->description);



        $project = [
            'country_id' => $country_id,
            'name' => $name,
            'price_type' => $price_type,
            'price' => $price,
            'deadline' => $deadline,
            'document' => "",
            'links' => $links,
            'description' => $description,
            'user_category_id' => ($userCategoryID ? $userCategoryID : [])
        ];
        $addProject = Projects::addProject($project);



        if ($addProject && $request->document) {
            $fileNames = [];
            foreach ($request->document as $fileName) {
                $fileName = stripinput($fileName);
                $filePathOld = "public/tmp/" . $user_id . "/" . $fileName;
                $filePathNew = $addProject->id . "/" . $fileName;
                if (Storage::exists($filePathOld)) {
                    Storage::move($filePathOld, "public/project-documents/".  $filePathNew);
                    $fileNames[] = $filePathNew;
                } // if
            } // foreach

            $fileNames = implode("|", $fileNames);

            $project = Projects::where('id', $addProject->id)->first();

            $project->document = $fileNames;
            $project->save();
        } // if

//        @dd($request);

        return redirect()->route('frontend.dashboard.employer.projects-all')->with('message', language('Project successfully added.'));

    }

    public function employerProjectEdit(Request $request)
    {

        $project_id = (int)$request->id;


        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;

        $project_filter = [
            'language_id' => $request->languageID,
            'employer_id' => $user_id,
        ];
        $project = Projects::getProject($project_id, $project_filter);
        if ($project == null || $project->status > 1) {
            return redirect()->back();
        }

        $project->user_country_image = $project->user_country_image ? asset($project->user_country_image) : "";
        $project->user_profile_photo = $project->user_profile_photo ? asset('storage/profile/'. $project->user_profile_photo) : asset('storage/no-image.jpg');
        $project->links = $project->links ? json_decode($project->links) : [];
        $project->user_social = $project->user_social ? json_decode($project->user_social) : [];
        $project->description = $project->description ? htmlspecialchars_decode($project->description) : "";
        $project->price_view = $project->price ? number_format($project->price, 2, ".", " ") : 0;
        $project->document = $project->document ? explode("|", $project->document) : [];

        $diffInDays = \Carbon\Carbon::parse($project->created_at)->diffInDays();
        $showDiff = \Carbon\Carbon::parse($project->created_at)->diffForHumans();
        if ($diffInDays > 0) {
            $showDiff .= ', ' . \Carbon\Carbon::parse($project->created_at)->addDays($diffInDays)->diffInHours() . ' Hours';
        }
        $project->created_at_view = $showDiff;



        $projects_categories_filter = [
            'language_id' => $request->languageID,
        ];
        $projects_categories = [];
        $projectsCategories = ProjectsCategories::get($project_id, $projects_categories_filter);
        if ($projectsCategories != null) {
            foreach ($projectsCategories as $projects_category) {
                $projects_categories[] = $projects_category->user_category_id;
            }
        }

        $userCategories_filter = [
            'languageID' => $request->languageID,
            'limit' => 9999,
            'role_id' => 4
        ];
        $user_categories = UserCategory::getUserCategories($userCategories_filter);


        $countries_filter = [
            'languageID' => $request->languageID,
            'limit' => 9999,
        ];
        $countries = Country::getCountries($countries_filter);


        return view('frontend.dashboard.employer.projects-edit', compact(
            'auth_user',
            'user',
            'user_categories',
            'countries',
            'project',
            'projects_categories'
        ));

    }

    public function employerProjectUpdate(ProjectEditRequest $request)
    {
        $user_id = Auth::id();

        $project_id = (int)$request->id;
        $country_id = (int)$request->country_id;
        $name = stripinput($request->name);
        $price_type = (int)$request->price_type;
        $price = (float)$request->price;
        $deadline = stripinput($request->deadline);
        $links = $request->links;
        $userCategoryID = $request->user_category_id;
        $description = htmlentities($request->description);


        $project = Projects::where('id', $project_id)
            ->where('employer_id', $user_id)
            ->first();
        if ($project == null) {
            return redirect()->back();
        }
        if ($project->status > 1) {
            return redirect()->back();
        }

        if (isset($request->publish)) {
            $project->status = ((int)$request->publish > 0 ? 1 : 0);
            $project->save();

            if ((int)$request->publish > 0) {
                return redirect()->route('frontend.dashboard.employer.projects-all')->with('message', language('Project successfully puplished.'));
            } else {
                return redirect()->route('frontend.dashboard.employer.projects-all')->with('message', language('Project successfully unpuplished.'));
            }
        }

        if ($project->status > 0) {
            return redirect()->back();
        }

        $project = [
            'country_id' => $country_id,
            'name' => $name,
            'price_type' => $price_type,
            'price' => $price,
            'deadline' => $deadline,
            'document' => "",
            'links' => $links,
            'description' => $description,
            'user_category_id' => ($userCategoryID ? $userCategoryID : [])
        ];
        $editProject = Projects::editProject($project_id, $project);


        if ($editProject) {
            if ($editProject && $request->delete_document) {
                foreach ($request->delete_document as $fileName) {
                    if (Storage::exists("public/project-documents/" . $fileName)) {
                        Storage::delete("public/project-documents/" . $fileName);
                    } // if
                } // foreach
            }

            if ($request->document) {
                $fileNames = [];
                foreach ($request->document as $fileName) {
                    $fileName = stripinput($fileName);
                    $filePathOld = "public/tmp/" . $user_id . "/" . $fileName;
                    $filePathNew = $fileName;
                    if (Storage::exists($filePathOld)) {
                        $filePathNew = $project_id . "/" . $fileName;
                        Storage::move($filePathOld, "public/project-documents/" . $filePathNew);
                    } // if
                    $fileNames[] = $filePathNew;
                } // foreach

                $fileNames = implode("|", $fileNames);

                $project = Projects::where('id', $project_id)
                    ->where('employer_id', $user_id)
                    ->first();
                $project->document = $fileNames;
                $project->save();
            } // if
        }


        return redirect()->route('frontend.dashboard.employer.projects-all')->with('message', language('Project successfully edited.'));

    }

    public function employerProjectPublish(Request $request)
    {
        $user_id = Auth::id();

        $project_id = (int)$request->id;

        $project = Projects::where('id', $project_id)
            ->where('employer_id', $user_id)
            ->where('status', '<', 2)
            ->first();
        if ($project == null) {
            return redirect()->back();
        }

        $project->status = ((int)$request->publish > 0 ? 1 : 0);
        $project->save();

        if ($project->status === 0) {
            return redirect()->route('frontend.dashboard.employer.projects-all')->with('message', language('Project successfully unpublished.'));
        } else {
            return redirect()->route('frontend.dashboard.employer.projects-all')->with('message', language('Project successfully published.'));
        }
    }

    public function employerProjectAccept(Request $request)
    {
        $user_id = Auth::id();
        $project_id = (int)$request->project_id;
        $rating = (float)$request->rating;
        $review = stripinput(strip_tags($request->review));


        if(CommonService::userRoleId($user_id) != 3) {
            return redirect()->back();
        }


        $hired = ProjectHireds::getHiredByProjectId($project_id);
        if($hired == null || $hired->status != 2) {
            return redirect()->back();
        }

        $freelancer_id = $hired->freelancer_id;

        $project_filter = [
            'language_id' => $request->languageID,
            'employer_id' => $user_id,
            'status' => 4
        ];
        $project = Projects::getProject($project_id, $project_filter);
        if ($project == null) {
            return redirect()->back();
        }

        $data = [
            'freelancer_id' => $freelancer_id,
            'project_id' => $project_id,
            'status' => 3,
            'letter' => language('I accepted this work and left a comment.')
        ];
        $editHireds = ProjectHireds::editHireds($data);
        if($editHireds) {

            if ($rating > 0 || !empty($review)) {
                $data = [
                    'from' => $user_id,
                    'to' => $freelancer_id,
                    'project_id' => $project_id,
                    'rating' => $rating,
                    'review' => $review,
                ];
                Reviews::addReview($data);
            }

            $user_freelancer = User::where('id', $freelancer_id)->first();
            if ($user_freelancer) {
                $user_freelancer->balance = (float)$user_freelancer->balance + (float)$hired->price;
                $user_freelancer->save();

                $pay_info = Pay::getByFreelancerIdAndProjectId($freelancer_id, $project_id);
                if($pay_info) {
                    $data = [
                        'status' => 6,
                        'paid_on' => Carbon::now()->toDateTimeString()
                    ];
                    $editPay = Pay::editPay($pay_info->id, $data);

                    $freelancer_text = language('The employer accepted your job, you have been transferred money in the amount of ') . number_format((float)$hired->price, 2, ".", " ") . language('frontend.currency');

                    Notification::addNotification($freelancer_id, $freelancer_text, $request->languageID);
                }
            }
        }


        return redirect()->route('frontend.dashboard.employer.projects-completed')->with('message', language('Project successfully accepted.'));

    }

    public function employerProjectCorrect(Request $request)
    {
        $user_id = Auth::id();
        $project_id = (int)$request->project_id;
        $letter = stripinput(strip_tags($request->letter));


        if(CommonService::userRoleId($user_id) != 3) {
            return redirect()->back();
        }


        $hired = ProjectHireds::getHiredByProjectId($project_id);
        if($hired == null || $hired->status != 2) {
            return redirect()->back();
        }

        $freelancer_id = $hired->freelancer_id;

        $project_filter = [
            'language_id' => $request->languageID,
            'employer_id' => $user_id,
            'status' => 4
        ];
        $project = Projects::getProject($project_id, $project_filter);
        if ($project == null) {
            return redirect()->back();
        }


        $data = [
            'freelancer_id' => $freelancer_id,
            'project_id' => $project_id,
            'status' => 1,
            'letter' => $letter
        ];
        $editHireds = ProjectHireds::editHireds($data);


        Projects::editStatus($data['project_id'], 3);


        return redirect()->route('frontend.dashboard.employer.projects-ongoing')->with('message', language('Project successfully submitted for revision.'));

    }

    public function employerProjectRepost(Request $request)
    {
        $user_id = Auth::id();
        $project_id = (int)$request->project_id;


        if(CommonService::userRoleId($user_id) != 3) {
            return redirect()->back();
        }


        $project_filter = [
            'language_id' => $request->languageID,
            'employer_id' => $user_id,
            'status' => 5
        ];
        $project = Projects::getProject($project_id, $project_filter);
        if ($project == null) {
            return redirect()->back();
        }

        ProjectHireds::removeHiredByProjectId($project_id);

        ProjectProposals::removeProposalsByProjectId($project_id);


        Projects::editStatus($project_id, 0);


        return redirect()->route('frontend.dashboard.employer.employerProjectEdit', $project_id)->with('message', language('Project successfully reposted.'));

    }

    public function employerInviteStore(ProjectProposalRequest $request)
    {
        $user_id = Auth::id();

        $freelancer_id = (int)$request->freelancer_id;
        $project_id = (int)$request->project_id;
        $price = (float)$request->price;
        $hours = (int)$request->hours;
        $letter = stripinput(strip_tags($request->letter));

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($freelancer_id, $user_filter);
        if ($user->role_id != 4) {
            return redirect()->back();
        }

        $project_filter = [
            'language_id' => $request->languageID,
            'employer_id' => $user_id,
            'status' => 1
        ];
        $project = Projects::getProject($project_id, $project_filter);
        if ($project == null) {
            return redirect()->back();
        }

        $data = [
            'freelancer_id' => $freelancer_id,
            'project_id' => $project_id,
            'price' => $price,
            'hours' => $hours,
            'letter' => $letter
        ];
        ProjectProposals::addProposals($data);

        return redirect()->route('frontend.dashboard.employer.project.proposals', $project_id)->with('message', language('Project successfully invited.'));

    }


    public function ajaxAddProjectFavourites(Request $request)
    {
        $success = false;
        $data = [];

        if (Auth::check()) {

            $freelancer_id = (int)Auth::id();
            $project_id = (int)$request->project_id;

            $project_filter = [
                'language_id' => $request->languageID
            ];
            $project = Projects::getProject($project_id, $project_filter);
            if ($project && CommonService::userRoleId($freelancer_id) == 4) {
                $getFavourite = ProjectFavourites::getFavourite($freelancer_id, $project_id);
                if ($getFavourite) {
                    $removeFavourites = ProjectFavourites::removeFavourites($freelancer_id, $project_id);
                    if ($removeFavourites) {
                        $success = true;
                        $data = [
                            'title' => language('Project Favourites'),
                            'text' => language('Project successfully removed favorites list'),
                            'icon' => '<i class="fa fa-check-circle"></i>',
                        ];
                    }
                } else {
                    $addFavourites = ProjectFavourites::addFavourites($freelancer_id, $project_id);
                    if ($addFavourites) {
                        $success = true;
                        $data = [
                            'title' => language('Project Favourites'),
                            'text' => language('Freelancer successfully added favorites list'),
                            'icon' => '<i class="fa fa-check-circle"></i>',
                        ];
                    }
                }
            }
        }

        return response()->json([
            'success' => $success,
            'data' => $data
        ]);
    }


    public function ajaxProjectsCount(Request $request)
    {
        $success = false;
        $data = [];

        if (Auth::check()) {

            $projects = null;
            $user_id = (int)Auth::id();

            $myProposals = 0;
            $hiredsProjects = 0;

            $allProjects = 0;
            $pendingProjects = 0;
            $ongoingProjects = 0;
            $completedProjects = 0;
            $cancelledProjects = 0;

            if (CommonService::userRoleId($user_id) == 3) {
                $project_filter = [
                    'language_id' => $request->languageID,
                    'employer_id' => $user_id,
                ];
                $projects = Projects::getTotalProjects($project_filter);
            } elseif(CommonService::userRoleId($user_id) == 4) {
                $project_filter = [
                    'language_id' => $request->languageID,
                    'freelancer_id' => $user_id,
                    'project_hired' => true,
                ];
                $projects = Projects::getTotalProjects($project_filter);

                $proposals = ProjectProposals::getProposals($user_id);
                if ($proposals) {
                    $myProposals = count($proposals);
                }
            }
            if ($projects) {
                $success = true;

                $allProjects = count($projects);


                foreach ($projects as $project) {

                    if ($project->status == 2) { $hiredsProjects++; }
                    if ($project->status == 2) { $pendingProjects++; }
                    if ($project->status == 3) { $ongoingProjects++; }
                    if ($project->status == 4) { $completedProjects++; }
                    if ($project->status == 5) { $cancelledProjects++; }

                    $data = [
                        'allProjects' => $allProjects,
                        'myProposals' => $myProposals,
                        'hiredsProjects' => $hiredsProjects,
                        'pendingProjects' => $pendingProjects,
                        'ongoingProjects' => $ongoingProjects,
                        'completedProjects' => $completedProjects,
                        'cancelledProjects' => $cancelledProjects,
                    ];

                }
            }

        }

        return response()->json([
            'success' => $success,
            'data' => $data
        ]);
    }

}
