<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AdminAddUserRequest;
use App\Http\Requests\User\UserRegisterRequest;
use App\Models\Country\Country;
use App\Models\Language\Languages;
use App\Models\User;
use App\Models\UserCategory\UserCategory;
use App\Services\CommonService;
use App\Services\Timezones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\Chats\ChatMessages;
use App\Models\Chats\Chats;
class UserController extends Controller
{

    public $defaultLanguage;
    public $validatorCheck;

    public function __construct()
    {

        //Hansi dil defaultdursa onu caqir
        $this->defaultLanguage = cache('language-defaultID') == null ? Languages::where('default', 1)
            ->first()->id : cache('language-defaultID');

    }

    public function index(Request $request)
    {


        $users = User::with('roles')
            ->orderBy('id', 'DESC')
            ->paginate(10);

//        @dd($users);


        return view('admin.user.index', compact('users'));
    }


    public function add(Request $request)
    {
        //Super admin olmuyanlari getir
        $roles = Role::whereNotIn('id', [1])->get();


        $user_categories = UserCategory::where('language_id', $this->defaultLanguage)
            ->join('user_categories_translations', 'user_categories.id', '=', 'user_categories_translations.user_category_id')
            ->where('role_id', old('roles'))
            ->orderBy('user_categories_translations.name', 'ASC')
            ->get();


        $countries = Country::where('language_id', $this->defaultLanguage)
            ->join('countries_translations', 'countries.id', '=', 'countries_translations.country_id')
            ->where('countries.status', 1)
            ->orderBy('countries_translations.name', 'ASC')
            ->get();


        return view('admin.user.add', compact(
            'roles',
            'user_categories',
            'countries'
        ));
    }

    public function store(AdminAddUserRequest $request)
    {
        $name = stripinput($request->name);
        $email = stripinput($request->email);
        $password = $request->password;
        $roles = $request->roles;
        $status = $request->status > 0 ? (int)$request->status : 0;
        $approve = $request->approve > 0 ? (int)$request->approve : 0;

        $user_category = (int)$request->user_category;
        $phone = stripinput($request->phone);
        $description = strip_tags($request->description);

        $address = $roles == 3 ? stripinput($request->address) : "";
        $longitude = $roles == 3 ? (float)$request->longitude : "";
        $latitude = $roles == 3 ? (float)$request->latitude : "";
        $postalcode = $roles == 3 ? stripinput($request->postalcode) : "";

        $gender = $roles == 4 ? (int)$request->gender : 0;
//        $date_of_birth =  $roles == 4 ? stripinput($request->date_of_birth) : "";




        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        if (!in_array($status, [0, 1, 2])) {
            $this->validateCheck('status', 'Status error.');
        }


        if ($roles == 1) {
            $this->validateCheck('roles', 'Bu icazə sistemdə mövcud deyil.');
        }


        //foto format check
        $image_64 = $request->profile_photo_upload; //your base64 encoded data
        if (!empty($image_64)) {
            if (!is_base64($image_64)) {
                $this->validateCheck('profile_photo', 'Wrong photo format. Allowed formats (jpg, jpeg and png)');
            }

        }

        $this->validatorCheck->validate();
        //CUSTOM VALIDATE END


        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'status' => $status,
            'approve' => $approve,

//            'user_category' => $user_category,
//            'phone' => $phone,
//
//            'address' => $address,
//            'longitude' => $longitude,
//            'latitude' => $latitude,
//            'postalcode' => $postalcode,
//
//            'gender' => $gender,
//            'date_of_birth' => $date_of_birth,
        ]);

        $user->syncRoles($roles);


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

        if (!empty($password)) {
            $user->password = bcrypt($password);
        }

        $user->user_category = $user_category;
        $user->phone = $phone;
        $user->description = $description;

        $user->address = $address;
        $user->longitude = $longitude;
        $user->latitude = $latitude;
        $user->postalcode = $postalcode;

        $user->gender = $gender;
//        $user->date_of_birth = $date_of_birth;

        $user->save();
        $user_from = 1;
        $user_to = (int)$user->id;
        $message = language('Welcome to our platform, if you have any questions write to us.');
        $file = "";
        $chat = Chats::getChat($user_from, $user_to);
        if (!$chat) {
            Chats::createChat($user_from, $user_to);
        }
        ChatMessages::addMessages($user_from, $user_to, $message, $file);

        $request->session()->put('chat_user_to', $user_to);

        $data['status'] = true;
        $data['message'] = language('frontend.register.verified');


        return redirect()->route('admin.user.index');
    }


    public function edit(Request $request)
    {
        $id = (int)$request->id;

        $user = User::with('roles')
            ->where('id', $id)->first();


        if (!$user) {
            return redirect()->route('admin.user.index');
        }


        //Super admin olmuyanlari getir
        $roles = Role::whereNotIn('id', [1])->get();

        if ($user->hasRole(1)) {
            return redirect()->route('admin.user.index');
        }



        $user_categories = UserCategory::where('language_id', $this->defaultLanguage)
            ->join('user_categories_translations', 'user_categories.id', '=', 'user_categories_translations.user_category_id')
            ->where('role_id', $user->roles[0]->id)
            ->orderBy('user_categories_translations.name', 'ASC')
            ->get();

        $countries = Country::where('language_id', $this->defaultLanguage)
            ->join('countries_translations', 'countries.id', '=', 'countries_translations.country_id')
            ->where('countries.status', 1)
            ->orderBy('countries_translations.name', 'ASC')
            ->get();


        return view('admin.user.edit', compact(
            'user',
            'roles',
            'user_categories',
            'countries'
        ));


    }


    public function update(Request $request)
    {

//        @dd($request);

        $id = $request->id;
        $name = stripinput($request->name);
        $email = stripinput($request->email);
        $password = $request->password;
        $roles = $request->roles;
        $status = $request->status > 0 ? (int)$request->status : 0;
        $approve = $request->approve > 0 ? (int)$request->approve : 0;

        $user_category = (int)$request->user_category;
        $phone = stripinput($request->phone);
        $description = stripinput($request->description);
        $country = (int)$request->country;
        $address = stripinput($request->address);
        $postalcode = stripinput($request->postalcode);


        $owner =  $roles == 3 ? stripinput($request->owner) : "";
        $established =  $roles == 3 ? stripinput($request->established) : "";
        $longitude = $roles == 3 ? (float)$request->longitude : "";
        $latitude = $roles == 3 ? (float)$request->latitude : "";

        $gender = $roles == 4 ? (int)$request->gender : 0;
        $hourly_rate =  $roles == 4 ? (float)$request->hourly_rate : "";
        $time_rate =  $roles == 4 ? stripinput($request->time_rate) : "";

        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        //Eger gonderilen ID sehfdirse
        $refererError = CommonService::refererError($id);
        if ($refererError) {
            $this->validateCheck('refererID', 'You used the wrong ID!');
        }


        if (!in_array($status, [0, 1, 2])) {
            $this->validateCheck('status', 'Status error.');
        }


        if ($roles == 1) {
            $this->validateCheck('roles', 'This permission is not available in the system.');
        }

        //foto format check
        $image_64 = $request->profile_photo_upload; //your base64 encoded data
        if (!empty($image_64)) {
            if (!is_base64($image_64)) {
                $this->validateCheck('profile_photo', 'Wrong photo format. Allowed formats (jpg, jpeg and png)');
            }

        }

        //banner format check
        $image_64 = $request->banner_image_upload; //your base64 encoded data
        if (!empty($image_64)) {
            if (!is_base64($image_64)) {
                $this->validateCheck('banner_image', 'Wrong banner format. Allowed formats (jpg, jpeg and png)');
            }

        }

        $this->validatorCheck->validate();


        $customMessagesPassword = [];
        $customMessagesUsername = [];
        $rulesUSername = [];
        $rulesPassword = [];

        //Usernam validate unique
        $rulesUSername = [
            'roles' => 'required|exists:roles,id',
            'email' => 'required|email|unique:users,email,' . $id . '|min:3|max:255',
            'name' => 'required',
            'profile_photo' => 'mimes:jpg,png',
            'banner_image' => 'mimes:jpg,png',
        ];

        $customMessagesUsername = [
            /*   ROLES   */
            'roles.required' => 'Roles required.',
            'roles.exists' => 'This permission is not available in the system.',

            /*   e-mail   */
            'email.required' => 'E-mail required.',
            'email.unique' => 'The e-mail address '. $email .' is available in the system, please check another e-mail address.',
            'email.email' => 'Use the correct email format.',
            'email.min' => 'Email must be at least 3 characters long.',
            'email.max' => 'Email must be a maximum of 255 characters.',

            /*   name   */
            'name.required' => 'Name required.',

            /*   profile_photo   */
            'profile_photo.mimes' => 'Wrong photo format. Allowed formats (jpg, jpeg and png)',

            /*   profile_photo   */
            'banner_image.mimes' => 'Wrong banner format. Allowed formats (jpg, jpeg and png)',

        ];

        //Password Check
        if (!empty($password)) {
            $rulesPassword = [
                'password' => 'min:8|max:50',
                'password_confirmation' => 'same:password'
            ];

            $customMessagesPassword = [
                /*  password   */
                'password.min' => 'The password must be at least 8 characters long.',
                'password.max' => 'The password must be a maximum of 50 characters.',

                /*  password_confirmation   */
                'password_confirmation.required' => 'Confirm password is required.',
                'password_confirmation.same' => 'Confirm password is incorrect',
            ];


        }

        $rules = array_merge($rulesPassword, $rulesUSername);
        $customMessages = array_merge($customMessagesPassword, $customMessagesUsername);


        $request->validate($rules, $customMessages);
        //CUSTOM VALIDATE END


        $user = User::where('id', $id)->first();
        $user->name = $name;
        $user->email = $email;
        $user->status = $status;
        $user->approve = $approve;

        $user->user_category = $user_category;
        $user->phone = $phone;
        $user->description = $description;

        $user->owner = $owner;
        $user->established = $established;

        $user->country = $country;
        $user->address = $address;
        $user->longitude = $longitude;
        $user->latitude = $latitude;
        $user->postalcode = $postalcode;

        $user->gender = $gender;
        $user->hourly_rate = $hourly_rate;
        $user->time_rate = $time_rate;


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
            $imageName = Auth::id() . '-' . Str::random(20) . '.jpg';
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

        //Banner Legv olunmushsa
        if($request->not_photoBanner == '1') {

            if (!empty($user->banner_image)) {
                Storage::delete('public/profile/' . $user->banner_image);
            }
            $user->banner_image = '';

        }

        if (!empty($password)) {
            $user->password = bcrypt($password);
        }


        $user->save();

        $user->removeRole($roles);
        $user->syncRoles($roles);

        return redirect()->route('admin.user.index');

    }


    public function profilEdit(Request $request)
    {
        $id = $request->id;

        $user = User::where('id', $id)->first();


        if ($id != Auth::id()) {
            return redirect()->route('admin.index');
        }


        return view('admin.user.profil.edit', compact('user'));

    }


    public function profilUpdate(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        //Eger gonderilen ID sehfdirse
        $refererError = CommonService::refererError($id);
        if ($refererError) {
            $this->validateCheck('refererID', 'Səhf ID istifadə etdiniz!');

        }


        //foto format check
        $image_64 = $request->profile_photo_upload; //your base64 encoded data
        if (!empty($image_64)) {
            if (!is_base64($image_64)) {
                $this->validateCheck('profile_photo', 'Sehf foto formatı.İcazə verilən formatlar (jpg,jpeg və png)');
            }

        }

        //Foto Legv olunmushsa
        if($request->not_photo == '1'){

                $user = User::where('id', Auth::id())
                    ->first();

                if (!empty($user->profile_photo)) {
                    Storage::delete('public/profile/' . $user->profile_photo);
                }
                $user->profile_photo = '';
                $user->save();

        }


        $this->validatorCheck->validate();


        $customMessagesPassword = [];
        $customMessagesUsername = [];
        $rulesUSername = [];
        $rulesPassword = [];

        //Usernam validate unique
        $rulesUSername = [
//            'username' => 'required|unique:users,username,' . $id . '|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $id . '|min:3|max:255',
            'name' => 'required',
            'profile_photo' => 'mimes:jpg,png',
        ];

        $customMessagesUsername = [

            /*   profile_photo   */
            'profile_photo.mimes' => 'You have selected the wrong image format for the photo. Allowed formats (jpg, jpeg, png)',

            /*   e-mail   */
            'email.required' => 'E-mail required.',
            'email.unique' => 'The e-mail address '. $email .' is available in the system, please check another e-mail address.',
            'email.email' => 'Use the correct email format.',
            'email.min' => 'Email must be at least 3 characters long.',
            'email.max' => 'Email must be a maximum of 255 characters.',

            /*   name   */
            'name.required' => 'Name required.',

        ];

        //Password Check
        if (!empty($password)) {
            $rulesPassword = [
                'password' => 'min:8|max:50',
                'password_confirmation' => 'same:password'
            ];

            $customMessagesPassword = [
                /*  password   */
                'password.min' => 'The password must be at least 8 characters long.',
                'password.max' => 'The password must be a maximum of 50 characters.',

                /*  password_confirmation   */
                'password_confirmation.required' => 'Confirm password is required.',
                'password_confirmation.same' => 'Confirm password is incorrect',
            ];


        }

        $rules = array_merge($rulesPassword, $rulesUSername);
        $customMessages = array_merge($customMessagesPassword, $customMessagesUsername);


        $request->validate($rules, $customMessages);
        //CUSTOM VALIDATE END


        //profile_photo
        if ($request->hasFile('profile_photo')) {

            $user = User::where('id', Auth::id())
                ->first();

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
            $user->save();


        }


        $user = User::where('id', $id)->first();
//        $user->username = $username;
        $user->name = $name;
        $user->email = $email;
        if (!empty($password)) {
            $user->password = bcrypt($password);
        }
        $user->save();


        return redirect()->back();

    }


    public function search(Request $request)
    {
        $search = $request->search;


        $users = User::with('roles')
            ->where(function ($query) use ($search) {
                $query->orWhere('users.name', 'like', '%' . $search . '%');
                $query->orWhere('users.email', 'like', '%' . $search . '%');
            })->orderby('id', 'DESC')
            ->paginate(10);


        return view('admin.user.index', compact('users', 'search'));
    }


    public function statusAjax(Request $request)
    {
        $id = intval($request->id);
        $statusActive = intval($request->statusActive);

        $user = User::with('roles')
            ->where('id', $id)->first();

        if ($user->roles[0]->id != 1) {


            $data = '';
            $success = '';

            if ($user) {
                $user->status = $statusActive;
                $user->save();

                if ($statusActive == 1) {
                    $data = 1;
                } else {
                    $data = 0;
                }

                $success = true;
            } else {
                $success = false;

            }
        } else {
            $success = false;
            return response()->json(['success' => $success]);
        }

        return response()->json(['success' => $success, 'data' => $data]);
    }


    public function deleteAjax(Request $request)
    {
        $id = $request->id;

        $user = User::where('id', $id)
            ->first();

        if ($user->hasRole(1)) {
            return response()->json(['checkAdmin' => true, 'name' => $user->name], 200);
        } else {
            return response()->json(['success' => true, 'name' => $user->name], 200);
        }


    }

    public function delete(Request $request)
    {

        //istifadecinin ozunu silir
        $id = intval($request->id);

        //Eger BU id admindirse silme
        $user = User::where('id', $id)
            ->first();
        if ($user->hasRole(1)) {
            return response()->json(['checkAdmin' => true, 'name' => $user->name], 200);
        }

        Storage::delete('public/profile/' . $user->profile_photo);


        User::where('id', $id)->delete();

        //bu id li userin roleni silir
        DB::delete("DELETE FROM model_has_roles WHERE model_id = " . $id);

        return response()->json(['success' => true], 200);


    }


    public function validateCheck($inputName, $text)
    {
        $this->validatorCheck->after(function ($validator) use ($inputName, $text) {
            $validator->errors()->add($inputName, $text);
        });
    }

    public function getUserCategoriesAjax(Request $request)
    {
        $role_id = (int)$request->role_id;

        $user_categories = UserCategory::where('language_id', $this->defaultLanguage)
            ->join('user_categories_translations', 'user_categories.id', '=', 'user_categories_translations.user_category_id')
            ->select('user_categories.id', 'user_categories_translations.name')
            ->where('role_id', $role_id)
            ->orderBy('user_categories_translations.name', 'ASC')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $user_categories
        ]);
    }


}
