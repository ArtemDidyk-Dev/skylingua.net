<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserCategory\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CabinetController extends Controller
{
    public $validatorCheck;

    public function __construct()
    {


    }

    public function index(Request $request)
    {

        $user_id = Auth::id();

        $user = User::getParentUser($user_id);
        $auth_user = $user;


        return view('frontend.cabinet.cabinet', compact(
            'auth_user',
            'user'
        ));

    }

    public function edit(Request $request)
    {
        $auth_user_id = (int)Auth::id();
        $auth_user = User::getParentUser($auth_user_id);

        $user_id = (int)$request->id;
        $user = User::getParentUser($user_id);


        if ($user == null) {
            return redirect()->back();
        }


        if (Auth::user()->roles[0]->id == 3) {
            if ($user->parent == 0) {
                if ($user->id != $auth_user_id) {
                    return redirect()->back();
                }
            } else {
                if ($user->parent != $auth_user_id) {
                    return redirect()->back();
                }
            }
        } else {
            if ($user->id != $auth_user_id) {
                return redirect()->back();
            }
        }

        $userCategories_filter = [
            'languageID' => $request->languageID,
            'limit' => 9999,
            'role_id' => $user->role_id
        ];
        $user_categories = UserCategory::getUserCategories($userCategories_filter);


        return view('frontend.cabinet.edit', compact(
            'auth_user',
            'user',
            'user_categories'
        ));

    }


    public function store(Request $request)
    {
        $user_id = (int)$request->id;


        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        $user = User::getParentUser($user_id);
        if ($user == null) {
            $this->validateCheck( language('frontend.edit_profile.error_refererID') );
        }

        if (Auth::user()->roles[0]->id == 3) {
            if ($user->parent == 0) {
                if ($user->id != Auth::id()) {
                    $this->validateCheck('roles', language('frontend.edit_profile.error_roles'));
                }
            } else {
                if ($user->parent != Auth::id()) {
                    $this->validateCheck('roles', language('frontend.edit_profile.error_roles'));
                }
            }
        } else {
            if ($user->id != Auth::id()) {
                $this->validateCheck('roles', language('frontend.edit_profile.error_roles'));
            }
        }

        //foto format check
        $image_64 = $request->profile_photo_upload; //your base64 encoded data
        if (!empty($image_64)) {
            if (!is_base64($image_64)) {
                $this->validateCheck('profile_photo', language('frontend.edit_profile.error_profile_photo'));
            }

        }


        $this->validatorCheck->validate();



        $id = $request->id;
        $name = stripinput($request->name);
        $email = stripinput($request->email);
        $password = $request->password;

        $user_category = (int)$request->user_category;
        $phone = stripinput($request->phone);
        $description = stripinput($request->description);


        $address = $user->role_id == 3 ? stripinput($request->address) : "";
        $longitude = $user->role_id == 3 ? (float)$request->longitude : "";
        $latitude = $user->role_id == 3 ? (float)$request->latitude : "";
        $postalcode = $user->role_id == 3 ? stripinput($request->postalcode) : "";

        $gender = $user->role_id == 4 ? (int)$request->gender : 0;
        $date_of_birth =  $user->role_id == 4 ? stripinput($request->date_of_birth) : "";
        $status = ($user->role_id == 3 ? ($request->status == 1 ? 1 : 0) : 1);




        $customMessagesPassword = [];
        $customMessagesUsername = [];
        $customMessagesInstitution = [];
        $customMessagesEmployee = [];

        $rulesUSername = [];
        $rulesPassword = [];
        $rulesInstitution = [];
        $rulesEmployee = [];

        //Usernam validate unique
        $rulesUSername = [
            'email' => 'required|email|unique:users,email,' . $id . '|min:3|max:255',
            'name' => 'required',
            'profile_photo' => 'mimes:jpg,png',
            'user_category' => 'required',
            'phone' => 'required',
        ];

        $customMessagesUsername = [
            /*   e-mail   */
            'email.required' => language('frontend.edit_profile.error_email_required'),
            'email.unique' => language('frontend.edit_profile.error_email_unique'),
            'email.email' => language('frontend.edit_profile.error_email_email'),
            'email.min' => language('frontend.edit_profile.error_email_min'),
            'email.max' => language('frontend.edit_profile.error_email_max'),

            /*   name   */
            'name.required' => language('frontend.edit_profile.error_name_required'),

            /*   user_category   */
            'user_category.required' => language('frontend.edit_profile.error_user_category_required'),

            /*   phone   */
            'phone.required' => language('frontend.edit_profile.error_phone_required'),

            /*   profile_photo   */
            'profile_photo.mimes' => language('frontend.edit_profile.error_profile_photo_mimes'),

        ];


        if ($user->role_id == 3) {


            //Institution validate unique
            $rulesInstitution = [
                'address' => 'required',
            ];

            $customMessagesInstitution = [
                /*   address   */
                'address.required' => language('frontend.edit_profile.error_address_required'),
            ];
        } else if ($user->role_id == 4) {
            //Employee validate unique
            $rulesEmployee = [
                'gender' => 'required',
                'date_of_birth' => 'required',
            ];

            $customMessagesEmployee = [
                /*   gender   */
                'gender.required' => language('frontend.edit_profile.error_gender_required'),

                /*   date_of_birth   */
                'date_of_birth.required' => language('frontend.edit_profile.error_date_of_birth_required'),
            ];
        }

        //Password Check
        if (!empty($password)) {
            $rulesPassword = [
                'password' => 'min:8|max:50',
                'password_confirmation' => 'same:password'
            ];

            $customMessagesPassword = [
                /*  password   */
                'password.min' => language('frontend.edit_profile.error_password_min'),
                'password.max' => language('frontend.edit_profile.error_password_max'),

                /*  password_confirmation   */
                'password_confirmation.required' => language('frontend.edit_profile.error_password_confirmation_required'),
                'password_confirmation.same' => language('frontend.edit_profile.error_password_confirmation_same'),
            ];


        }


        $rules = array_merge($rulesPassword, $rulesUSername, $rulesInstitution, $rulesEmployee);
        $customMessages = array_merge($customMessagesPassword, $customMessagesUsername, $customMessagesInstitution, $customMessagesEmployee);


        $request->validate($rules, $customMessages);
        //CUSTOM VALIDATE END


        $user = User::where('id', $user_id)->first();

        $user->name = $name;
        $user->email = $email;


        $user->user_category = $user_category;
        $user->phone = $phone;
        $user->description = $description;


        $user->address = $address;
//        $user->longitude = $longitude;
//        $user->latitude = $latitude;
        $user->postalcode = $postalcode;

        $user->gender = $gender;
        $user->date_of_birth = $date_of_birth;


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

        if (!empty($password)) {
            $user->password = bcrypt($password);
        }

        $user->status = $status;


        $user->save();

        return redirect()->route('frontend.cabinet.edit', $id)->with('message', language('frontend.edit_profile.success_updated'));

    }

    public function add(Request $request)
    {

        $user_id = (int)Auth::id();

        $user = User::getParentUser($user_id);
        $auth_user = $user;


        $userAdd['role_id'] = ($request->role ? (int)$request->role : 4);
        $userAdd['profile_photo'] = "";
        $userAdd['name'] = "";
        $userAdd['user_category'] = "";
        $userAdd['gender'] = "";
        $userAdd['date_of_birth'] = "";
        $userAdd['address'] = "";
        $userAdd['postalcode'] = "";
        $userAdd['email'] = "";
        $userAdd['phone'] = "";
        $userAdd['description'] = "";
        $userAdd['status'] = 1;


        if (Auth::user()->roles[0]->id != 3) {
            return redirect()->back();
        } // if roles


        $userAdd = (object) $userAdd;

        $userCategories_filter = [
            'languageID' => $request->languageID,
            'limit' => 9999,
            'role_id' => $userAdd->role_id
        ];
        $user_categories = UserCategory::getUserCategories($userCategories_filter);


        return view('frontend.cabinet.add', compact(
            'auth_user',
            'user',
            'userAdd',
            'user_categories'
        ));

    }


    public function addStore(Request $request)
    {
        $user_id = (int)Auth::id();


        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);



        if (Auth::user()->roles[0]->id != 3) {
            $this->validateCheck('roles', language('frontend.edit_profile.error_roles') );
        }

        //foto format check
        $image_64 = $request->profile_photo_upload; //your base64 encoded data
        if (!empty($image_64)) {
            if (!is_base64($image_64)) {
                $this->validateCheck('profile_photo', language('frontend.edit_profile.error_profile_photo'));
            }
        }


        $this->validatorCheck->validate();



        $role_id = $request->role_id;
        $name = stripinput($request->name);
        $email = stripinput($request->email);
        $password = $request->password;

        $user_category = (int)$request->user_category;
        $phone = stripinput($request->phone);
        $description = stripinput($request->description);


        $address = $role_id == 3 ? stripinput($request->address) : "";
        $longitude = $role_id == 3 ? (float)$request->longitude : "";
        $latitude = $role_id == 3 ? (float)$request->latitude : "";
        $postalcode = $role_id == 3 ? stripinput($request->postalcode) : "";

        $gender = $role_id == 4 ? (int)$request->gender : 0;
        $date_of_birth =  $role_id == 4 ? stripinput($request->date_of_birth) : "";

        $status = $request->status == 1 ? 1 : 0;




        $customMessagesPassword = [];
        $customMessagesUsername = [];
        $customMessagesInstitution = [];
        $customMessagesEmployee = [];

        $rulesUSername = [];
        $rulesPassword = [];
        $rulesInstitution = [];
        $rulesEmployee = [];

        //Usernam validate unique
        $rulesUSername = [
            'role_id' => 'required',
            'email' => 'required|email|unique:users|min:3|max:255',
            'name' => 'required',
            'profile_photo' => 'mimes:jpg,png',
            'user_category' => 'required',
            'phone' => 'required',
        ];

        $customMessagesUsername = [

            /*   role_id   */
            'role_id.required' => language('frontend.edit_profile.error_role_id_required'),

            /*   e-mail   */
            'email.required' => language('frontend.edit_profile.error_email_required'),
            'email.unique' => language('frontend.edit_profile.error_email_unique'),
            'email.email' => language('frontend.edit_profile.error_email_email'),
            'email.min' => language('frontend.edit_profile.error_email_min'),
            'email.max' => language('frontend.edit_profile.error_email_max'),

            /*   name   */
            'name.required' => language('frontend.edit_profile.error_name_required'),

            /*   user_category   */
            'user_category.required' => language('frontend.edit_profile.error_user_category_required'),

            /*   phone   */
            'phone.required' => language('frontend.edit_profile.error_phone_required'),

            /*   profile_photo   */
            'profile_photo.mimes' => language('frontend.edit_profile.error_profile_photo_mimes'),

        ];


        if ($role_id == 3) {


            //Institution validate unique
            $rulesInstitution = [
                'address' => 'required',
            ];

            $customMessagesInstitution = [
                /*   address   */
                'address.required' => language('frontend.edit_profile.error_address_required'),
            ];
        } else if ($role_id == 4) {
            //Employee validate unique
            $rulesEmployee = [
                'gender' => 'required',
                'date_of_birth' => 'required',
            ];

            $customMessagesEmployee = [
                /*   gender   */
                'gender.required' => language('frontend.edit_profile.error_gender_required'),

                /*   date_of_birth   */
                'date_of_birth.required' => language('frontend.edit_profile.error_date_of_birth_required'),
            ];
        }

        //Password Check
        $rulesPassword = [
            'password' => 'min:8|max:50',
            'password_confirmation' => 'same:password'
        ];

        $customMessagesPassword = [
            /*  password   */
            'password.min' => language('frontend.edit_profile.error_password_min'),
            'password.max' => language('frontend.edit_profile.error_password_max'),

            /*  password_confirmation   */
            'password_confirmation.required' => language('frontend.edit_profile.error_password_confirmation_required'),
            'password_confirmation.same' => language('frontend.edit_profile.error_password_confirmation_same'),
        ];



        $rules = array_merge($rulesPassword, $rulesUSername, $rulesInstitution, $rulesEmployee);
        $customMessages = array_merge($customMessagesPassword, $customMessagesUsername, $customMessagesInstitution, $customMessagesEmployee);


        $request->validate($rules, $customMessages);
        //CUSTOM VALIDATE END


        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'status' => $status,
        ]);

        $user->syncRoles($role_id);


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
            $imageName = Auth::id() . '-' . Str::random(20) . '.jpg';
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

//        if (!empty($password)) {
//            $user->password = bcrypt($password);
//        }

        $user->parent = Auth::id();
        $user->user_category = $user_category;
        $user->phone = $phone;
        $user->description = $description;

        $user->address = $address;
        $user->longitude = $longitude;
        $user->latitude = $latitude;
        $user->postalcode = $postalcode;

        $user->gender = $gender;
        $user->date_of_birth = $date_of_birth;

        $user->save();

        if ($role_id == 3) {
            return redirect()->route('frontend.cabinet.institution')->with('message', language('frontend.edit_profile.success_updated'));
        } else {
            return redirect()->route('frontend.cabinet.employee')->with('message', language('frontend.edit_profile.success_updated'));
        }


    }


    public function employee(Request $request)
    {

        $user_id = Auth::id();

        $user = User::getParentUser($user_id);
        $auth_user = $user;


        $employee_filter = [
            'languageID' => $request->languageID,
            'parent' => $user_id,
            'limit' => 9999
        ];
        $employees = User::getParentEmployee($employee_filter);


        return view('frontend.cabinet.employee', compact(
            'auth_user',
            'user',
            'employees',
        ));

    }

    public function institution(Request $request)
    {
        $user_id = Auth::id();

        $user = User::getParentUser($user_id);
        $auth_user = $user;

        $institution_filter = [
            'languageID' => $request->languageID,
            'parent' => $user_id,
            'limit' => 9,
        ];
        $institutions = User::getParentInstitution($institution_filter);


        return view('frontend.cabinet.institution', compact(
            'auth_user',
            'user',
            'institutions',
        ));

    }



    public function validateCheck($inputName, $text)
    {
        $this->validatorCheck->after(function ($validator) use ($inputName, $text) {
            $validator->errors()->add($inputName, $text);
        });
    }


}
