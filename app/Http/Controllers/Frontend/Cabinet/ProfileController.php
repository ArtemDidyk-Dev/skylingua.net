<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Mail\Frontend\AccountRecoveryMail;
use App\Mail\Frontend\PasswordResetsMail;
use App\Models\Country\Country;
use App\Models\FreelancerFavourites;
use App\Models\PasswordResets;
use App\Models\Portfolio\Portfolio;
use App\Models\Project\Projects;
use App\Models\ProjectProposals;
use App\Models\Reviews\Reviews;
use App\Models\User;
use App\Models\UserCategory\UserCategory;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public $validatorCheck;


    public function index(Request $request)
    {
       
        $user_id = (int)$request->id;

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        if ($user == null) {
            return redirect()->back();
        }

        if ($user->role_id == 3) {
            $user->profile_photo = !empty($user->profile_photo) ? asset('storage/profile/'. $user->profile_photo) : asset('storage/no-image.jpg');
            $user->banner_image = !empty($user->banner_image) ? asset('storage/profile/'. $user->banner_image) :
                asset('storage/company-bg.jpg');
        } else if ($user->role_id == 4) {
            $user->profile_photo = !empty($user->profile_photo) ? asset('storage/profile/' . $user->profile_photo) : asset('storage/no-photo.jpg');
            $user->banner_image = !empty($user->banner_image) ? asset('storage/profile/' . $user->banner_image) : asset('storage/profile-bg.jpg');
        }
        $user->user_country_image = !empty($user->user_country_image) ? asset($user->user_country_image) : "";
        $user->user_profile_link = $request->fullUrl();

        if($user->description) {
            $user->description = str_replace("\n", "<br />", html_entity_decode($user->description, ENT_QUOTES, 'UTF-8'));
           
        }

        if ($user->social) {
            $user->social = json_decode($user->social);
        }


        $user->favourites = false;
        if (Auth::check() && $user->role_id == 4) {
            $getFavourite = FreelancerFavourites::getFavourite(Auth::id(), $user->id);
            if ($getFavourite) {
                $user->favourites = true;
            }
        }

//        @dd($user);


        $projects_list = [];
        $auth_user = [];
        if (Auth::check()) {
            $auth_user = Auth::user();;

            if (CommonService::userRoleId($auth_user->id) == 3) {
                $project_filter = [
                    'employer_id' => $auth_user->id,
                    'status' => 1
                ];
                $getProjectsList = Projects::getTotalProjectsList($project_filter);
             
                if ($getProjectsList) {
                    foreach ($getProjectsList as $getProjectList) {
                        $proposal = ProjectProposals::getProposal($user->id, $getProjectList->id);
                        if (!$proposal) {
                            $projects_list[] = $getProjectList;
                        }

                    }
                }
            
            }
        }



        $getReviews = Reviews::getReviewsByUserId($user_id);
        $reviews = [];
        $average_rating = 0;
        if ($getReviews) {
            foreach ($getReviews as $review) {
                $diffInDays = \Carbon\Carbon::parse($review->created_at)->diffInDays();
                $showDiff = \Carbon\Carbon::parse($review->created_at)->diffForHumans();
                $review->review = str_replace("\r\n", "<br />", html_entity_decode($review->review, ENT_QUOTES, 'UTF-8'));
                $review->rating_view = number_format($review->rating, 1, ".", "" );
                $review->created_at_view =  \Carbon\Carbon::parse($review->created_at)->format('M d, Y');
              
                $review->user_profile_photo = !empty($review->user_profile_photo) ? asset('storage/profile/'. $review->user_profile_photo) : asset('storage/no-photo.jpg');
                $reviews[] = $review;

                $average_rating = $average_rating+(float)$review->rating;
            }
            $reviews_count = count($reviews);
            if($reviews_count > 0) {
                $average_rating = $average_rating / $reviews_count;
            }
            $average_rating = number_format($average_rating, 1, ".", "" );
        }





        if ($user->role_id == 3) {

            $project_filter = [
                'language_id' => $request->languageID,
                'employer_id' => $user_id,
                'approve' => 1,
                'status' => 1
            ];
            $getProjects = Projects::getProjects($project_filter);
            $projects = [];
            if ($getProjects) {
                foreach ($getProjects as $getProject) {

                    $proposals_count = 0;
                    $getProposalsCount = ProjectProposals::getProposalsCountByProjectId($getProject->id);
                    if ($getProposalsCount) {
                        $proposals_count = $getProposalsCount;
                    }

                    $getProject->user_country_image = $getProject->user_country_image ? asset($getProject->user_country_image) : "";
                    $getProject->links = $getProject->links ? json_decode($getProject->links) : [];
                    $getProject->description = $getProject->description ? htmlspecialchars($getProject->description) : "";
                    $getProject->price = $getProject->price ? number_format($getProject->price, 2, ".", " ") : 0;
                    $getProject->proposals_count = $proposals_count;
                    $projects[] = $getProject;
                }
            }
           
            return view('pages.employer.single', compact(
                'auth_user',
                'user',
                'projects',
                'getProjects',
                'reviews',
                'reviews_count',
                'average_rating'
            ));
        } else if ($user->role_id == 4) {
        
            $portfolios = Portfolio::getByUserId($user_id, 999);
            return view('pages.freelancers.single', compact(
                'auth_user',
                'user',
                'portfolios',
                'reviews',
                'average_rating',
                'projects_list',
                'reviews_count'
            ));
        }

    }

    public function editFrelancer(Request $request)
    {

        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        if ($user == null) {
            return redirect()->back();
        }


        $userCategories_filter = [
            'languageID' => $request->languageID,
            'limit' => 9999,
            'role_id' => $user->role_id
        ];
        $user_categories = UserCategory::getUserCategories($userCategories_filter);


        $countries_filter = [
            'languageID' => $request->languageID,
            'limit' => 9999,
            'role_id' => $user->role_id
        ];
        $countries = Country::getCountries($countries_filter);

        $user->description = html_entity_decode( $user->description, ENT_QUOTES, 'UTF-8');

        return view('frontend.dashboard.freelancer.profile-settings', compact(
            'auth_user',
            'user',
            'user_categories',
            'countries'
        ));

    }


    public function editFrelancerStore(Request $request)
    {
        $user_id = (int)$request->user_id;

        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        if ($user_id != Auth::id()) {
            $this->validateCheck( 'user_id', language('frontend.edit_profile.error_user_id') );
        }

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getParentUser($user_id, $user_filter);
        if ($user == null) {
            $this->validateCheck('user_id', language('frontend.edit_profile.error_user') );
        }


        //foto format check
        $image_64 = $request->profile_photo_upload; //your base64 encoded data
        if (!empty($image_64)) {
            if (!is_base64($image_64)) {
                $this->validateCheck('profile_photo', language('frontend.edit_profile.error_profile_photo'));
            }

        }

        //foto format check
        $image_64 = $request->banner_image_upload; //your base64 encoded data
        if (!empty($image_64)) {
            if (!is_base64($image_64)) {
                $this->validateCheck('banner_image', language('frontend.edit_profile.error_banner_image'));
            }
        }

        $this->validatorCheck->validate();



        $id = $user_id;
        $name = stripinput($request->name);
        $email = stripinput($request->email);
        $phone = stripinput($request->phone);
        $user_category = (int)$request->user_category;
        $hourly_rate = (float)$request->hourly_rate;
        $time_rate = stripinput($request->time_rate);
        $gender = (int)$request->gender;

        $country = (int)$request->country;
        $postalcode = stripinput($request->postalcode);
        $address = stripinput($request->address);

        $description = stripinput($request->description);


        $rules = [
            'email' => 'required|email|unique:users,email,' . $id . '|min:3|max:255',
            'name' => 'required',
            'profile_photo' => 'mimes:jpg,png',
            'banner_image' => 'mimes:jpg,png',
            'user_category' => 'required',
            'country' => 'required',
            'phone' => 'required',

            'gender' => 'required',
            'hourly_rate' => 'required',
            'time_rate' => 'required|max:50',
        ];

        $customMessages = [

        ];

        $request->validate($rules, $customMessages);
        //CUSTOM VALIDATE END


        $user = User::where('id', $user_id)->first();

        $user->name = $name;
        $user->email = $email;
        $user->phone = $phone;
        $user->user_category = $user_category;
        $user->hourly_rate = $hourly_rate;
        $user->time_rate = $time_rate;
        $user->country = $country;
        $user->postalcode = $postalcode;
        $user->address = $address;
        $user->gender = $gender;
        $user->description = html_entity_decode($description, ENT_QUOTES, 'UTF-8');;


        //profile_photo
        if ($request->hasFile('profile_photo')) {

            if (!empty($user->profile_photo)) {
                Storage::delete('public/profile/' . $user->profile_photo);
            }


            $image_64 = $request->profile_photo_upload; //your base64 encoded data
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);


            $destinationpath = "public/profile";
            $imageName = $id . '-' . Str::random(20) . '.jpg';
            Storage::put($destinationpath . '/' . $imageName, base64_decode($image));


            //foto yuklendikden sonra compres et
            $destinationPathStorage = "storage/profile";
            compressImgFile($destinationPathStorage . '/' . $imageName, $destinationPathStorage . '/' . $imageName, 80);


            //bazaya yaz
            $user->profile_photo = $imageName;
        }


        //banner_image
        if ($request->hasFile('banner_image')) {

            if (!empty($user->banner_image)) {
                Storage::delete('public/profile/' . $user->banner_image);
            }


            $image_64 = $request->banner_image_upload; //your base64 encoded data
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);


            $destinationpath = "public/profile";
            $imageName = $id . '-' . Str::random(20) . '.jpg';
            Storage::put($destinationpath . '/' . $imageName, base64_decode($image));


            //foto yuklendikden sonra compres et
            $destinationPathStorage = "storage/profile";
            compressImgFile($destinationPathStorage . '/' . $imageName, $destinationPathStorage . '/' . $imageName, 80);


            //bazaya yaz
            $user->banner_image = $imageName;
        }

        //Foto Legv olunmushsa
        if($request->not_photo == '1') {

            if (!empty($user->profile_photo)) {
                Storage::delete('public/profile/' . $user->profile_photo);
            }
            $user->profile_photo = '';

        }

        //Banner Image Legv olunmushsa
        if($request->not_photoBanner == '1') {

            if (!empty($user->banner_image)) {
                Storage::delete('public/profile/' . $user->banner_image);
            }
            $user->banner_image = '';

        }


        $user->save();


        return redirect()->route('frontend.dashboard.freelancer.profile-settings')->with('message', language('frontend.edit_profile.success_updated'));

    }

    public function editEmployer(Request $request)
    {

        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;

        if ($user->social) {
            $user->social = json_decode($user->social);
        }
        
        $user->description = html_entity_decode( $user->description, ENT_QUOTES, 'UTF-8');



        if ($user == null) {
            return redirect()->back();
        }


        $userCategories_filter = [
            'languageID' => $request->languageID,
            'limit' => 9999,
            'role_id' => $user->role_id
        ];
        $user_categories = UserCategory::getUserCategories($userCategories_filter);


        $countries_filter = [
            'languageID' => $request->languageID,
            'limit' => 9999,
            'role_id' => $user->role_id
        ];
        $countries = Country::getCountries($countries_filter);




        return view('frontend.dashboard.employer.profile-settings', compact(
            'auth_user',
            'user',
            'user_categories',
            'countries'
        ));

    }


    public function editEmployerStore(Request $request)
    {
       
        
        $user_id = (int)$request->user_id;

        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        if ($user_id != Auth::id()) {
            $this->validateCheck( 'user_id', language('frontend.edit_profile.error_user_id') );
        }

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getParentUser($user_id, $user_filter);
        if ($user == null) {
            $this->validateCheck('user_id', language('frontend.edit_profile.error_user') );
        }


        //foto format check
        $image_64 = $request->profile_photo_upload; //your base64 encoded data
        if (!empty($image_64)) {
            if (!is_base64($image_64)) {
                $this->validateCheck('profile_photo', language('frontend.edit_profile.error_profile_photo'));
            }

        }


        $this->validatorCheck->validate();



        $id = $user_id;
        $name = stripinput($request->name);
        $email = stripinput($request->email);
        $phone = stripinput($request->phone);

        $country = (int)$request->country;
        $postalcode = stripinput($request->postalcode);
        $address = stripinput($request->address);
        $owner = stripinput($request->owner);
        $established = stripinput($request->established);

        $description = stripinput(strip_tags($request->description));



        $rules = [
            'email' => 'required|email|unique:users,email,' . $id . '|min:3|max:255',
            'name' => 'required',
            'profile_photo' => 'mimes:jpg,png',
            'country' => 'required',
            'phone' => 'required',
        ];

        $customMessages = [

        ];

        $request->validate($rules, $customMessages);
        //CUSTOM VALIDATE END


        $user = User::where('id', $user_id)->first();

        $user->name = $name;
        $user->owner = $owner;
        $user->established = $established;
        $user->email = $email;
        $user->phone = $phone;
        $user->country = $country;
        $user->postalcode = $postalcode;
        $user->address = $address;
        $user->description = html_entity_decode($description, ENT_QUOTES, 'UTF-8');;




        //profile_photo
        if ($request->hasFile('profile_photo')) {

            if (!empty($user->profile_photo)) {
                Storage::delete('public/profile/' . $user->profile_photo);
            }


            $image_64 = $request->profile_photo_upload; //your base64 encoded data
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);


            $destinationpath = "public/profile";
            $imageName = $id . '-' . Str::random(20) . '.jpg';
            Storage::put($destinationpath . '/' . $imageName, base64_decode($image));


            //foto yuklendikden sonra compres et
            $destinationPathStorage = "storage/profile";
            compressImgFile($destinationPathStorage . '/' . $imageName, $destinationPathStorage . '/' . $imageName, 80);


            //bazaya yaz
            $user->profile_photo = $imageName;
        }


    
        //Foto Legv olunmushsa
        if($request->not_photo == '1') {

            if (!empty($user->profile_photo)) {
                Storage::delete('public/profile/' . $user->profile_photo);
            }
            $user->profile_photo = '';

        }
       
        $user->save();


        return redirect()->route('frontend.dashboard.employer.profile-settings')->with('message', language('frontend.edit_profile.success_updated'));

    }




    public function changePassword(Request $request)
    {

        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        return view('frontend.dashboard.change-password', compact(
            'auth_user',
            'user'
        ));

    }

    public function changePasswordStore(Request $request)
    {
        $user_id = (int)$request->user_id;
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $confirm_password = $request->confirm_password;


        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        if ($user_id != Auth::id()) {
            $this->validateCheck( 'user_id', language('frontend.edit_profile.error_user_id') );
        }

        $user = User::where('id', $user_id)->first();
        if ($user == null) {
            $this->validateCheck( 'user_id', language( 'frontend.edit_profile.error_user') );
        }

        if(!empty($old_password) && $user != null && !Hash::check($old_password, $user->password)) {
            $this->validateCheck( 'old_password', language( 'frontend.edit_profile.error_old_password') );
        }

        $this->validatorCheck->validate();

        $rules = [
            'old_password' => 'required|min:8|max:50',
            'new_password' => 'required|min:8|max:50',
            'confirm_password' => 'same:new_password'
        ];

        $customMessages = [
//            /*  password   */
//            'new_password.min' => language('frontend.edit_profile.error_password_min'),
//            'new_password.max' => language('frontend.edit_profile.error_password_max'),
//
//            /*  password_confirmation   */
//            'confirm_password.required' => language('frontend.edit_profile.error_password_confirmation_required'),
//            'confirm_password.same' => language('frontend.edit_profile.error_password_confirmation_same'),
        ];

        $request->validate($rules, $customMessages);
        //CUSTOM VALIDATE END


        $user->password = bcrypt($new_password);
        $user->save();

        return redirect()->route('frontend.dashboard.change-password')->with('message', language('frontend.edit_profile.success_password_changed'));

    }

    public function deleteAccount(Request $request)
    {

        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        return view('frontend.dashboard.delete-account', compact(
            'auth_user',
            'user'
        ));

    }

    public function deleteAccountStore(Request $request)
    {

        $verify = Str::random(100);

        $user_id = (int)$request->user_id;
        $reason = stripinput($request->reason);
        $password = $request->password;


        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        if ($user_id != Auth::id()) {
            $this->validateCheck( 'user_id', language('frontend.edit_profile.error_user_id') );
        }

        $user = User::getParentUser($user_id);
        if ($user == null) {
            $this->validateCheck( 'user_id', language( 'frontend.edit_profile.error_user') );
        }

        if(!empty($password) && $user != null && !Hash::check($password, $user->password)) {
            $this->validateCheck( 'password', language( 'frontend.edit_profile.error_old_password') );
        }

        $this->validatorCheck->validate();

        $rules = [
            'reason' => 'required|min:8',
            'password' => 'required|min:8|max:50'
        ];

        $customMessages = [

        ];

        $request->validate($rules, $customMessages);
        //CUSTOM VALIDATE END


        $user = User::where('id', $user_id)->first();
        $user->verify = $verify;
        $user->reason = $reason;
        $user->status = 2;
        $user->save();


//      MAIL SENT Begin
        $toMail = stripinput($user->email);
        $mail_data = [
            'verify' => $verify,
        ];
        Mail::to($toMail)
            ->send(new AccountRecoveryMail($mail_data));
//      MAIL SENT End

        Auth::logout();

        return redirect()->route('frontend.login.index')->with('success', language('frontend.edit_profile.success_accaunt_deleted'));

    }

    public function recoveryAccount(Request $request)
    {

        $verify = stripinput($request->token);
        if (!empty($verify)) {
            $user = User::getByVerify($verify);
        } else {
            $user = null;
        }
        if ($user) {

            $user->verify = "";
            $user->reason = "";
            $user->status = 1;
            $user->email_verified_at = date("Y-m-d H:i:s");
            $user->save();

            return redirect()->route('frontend.login.index')->with('success', language('frontend.profile.success_account_recovered'));

        } else {
            return redirect()->route('frontend.login.index')->with('error', language('frontend.profile.not_recovered'));
        }

    }


    public function ajaxAddFreelancerFavourites(Request $request)
    {
        $success = false;
        $data = [];

        if (Auth::check()) {

            $employer_id = (int)Auth::id();
            $freelancer_id = (int)$request->freelancer_id;

            $user = User::getUser($freelancer_id);
            if ($user && $user->role_id == 4) {
                $getFavourite = FreelancerFavourites::getFavourite($employer_id, $freelancer_id);
                if ($getFavourite) {
                    $removeFavourites = FreelancerFavourites::removeFavourites($employer_id, $freelancer_id);
                    if ($removeFavourites) {
                        $success = true;
                        $data = [
                            'title' => language('Freelancer Favourites'),
                            'text' => language('Freelancer successfully removed favorites list'),
                            'icon' => '<i class="fa fa-check-circle"></i>',
                        ];
                    }
                } else {
                    $addFavourites = FreelancerFavourites::addFavourites($employer_id, $freelancer_id);
                    if ($addFavourites) {
                        $success = true;
                        $data = [
                            'title' => language('Freelancer Favourites'),
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


    public function validateCheck($inputName, $text)
    {
        $this->validatorCheck->after(function ($validator) use ($inputName, $text) {
            $validator->errors()->add($inputName, $text);
        });
    }


}
