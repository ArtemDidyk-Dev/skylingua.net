<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectAddRequestAdmin;
use App\Http\Requests\Project\ProjectEditRequest;
use App\Http\Requests\Project\ProjectEditRequestAdmin;
use App\Models\Country\Country;
use App\Models\Language\Languages;
use App\Models\Page\Page;
use App\Models\Project\ProjectHireds;
use App\Models\Project\Projects;
use App\Models\Project\ProjectsCategories;
use App\Models\ProjectProposals;
use App\Models\User;
use App\Models\UserCategory\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
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



        $project_filter = [
            'language_id' => $this->defaultLanguage,
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




        return view('admin.project.index', compact(
            'projects',
            'getProjects'
        ));
    }


    public function search(Request $request)
    {
        $search = $request->search;


        $project_filter = [
            'language_id' => $this->defaultLanguage,
            'search' => $search
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






        return view('admin.project.search', compact(
            'projects',
            'getProjects'
        ));





    }


    public function nameSearch(Request $request)
    {
        $data = $request->data;

        $user = User::where('name', 'like', '%' . $data . '%')
            ->orWhere('email', 'like', '%' . $data . '%')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);


    }


    public function add(Request $request)
    {


        $userCategories_filter = [
            'languageID' => $this->defaultLanguage,
            'limit' => 9999,
            'role_id' => 4
        ];
        $user_categories = UserCategory::getUserCategories($userCategories_filter);


        $countries_filter = [
            'languageID' => $this->defaultLanguage,
            'limit' => 9999,
        ];
        $countries = Country::getCountries($countries_filter);

        return view('admin.project.add',compact('countries','user_categories'));
    }


    public function store(ProjectAddRequestAdmin $request)
    {


        $user_id = $request->user_name;

        $status = $request->status;
        $approve = $request->approve;
        $country_id = (int)$request->country_id;
        $name = stripinput($request->name);
        $price_type = (int)$request->price_type;
        $price = (float)$request->price;
        $deadline = stripinput($request->deadline);
        $links = $request->links;
        $userCategoryID = $request->user_category_id;
        $description = htmlentities($request->description);



        $project = [
            'user_id' => $user_id,
            'status' => $status,
            'approve' => $approve,
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
                $filePathOld = "public/tmp/" . Auth::id() . "/" . $fileName;
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

        return redirect()->route('admin.project.index');
    }

    public function update(ProjectEditRequestAdmin $request)
    {


        $user_id = $request->user_name;


        $project_id = (int)$request->id;
        $status = $request->status;
        $approve = $request->approve;
        $country_id = (int)$request->country_id;
        $name = stripinput($request->name);
        $price_type = (int)$request->price_type;
        $price = (float)$request->price;
        $deadline = stripinput($request->deadline);
        $links = $request->links;
        $userCategoryID = $request->user_category_id;
        $description = htmlentities($request->description);



        $project = [
            'user_id' => $user_id,
            'status' => $status,
            'approve' => $approve,
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
        $editProject = Projects::editProjectForAdmin($project_id, $project);




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
                    $filePathOld = "public/tmp/" . Auth::id() . "/" . $fileName;
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

        return redirect()->route('admin.project.index');
    }





    public function edit(Request $request)
    {

        $project_id = (int)$request->id;


        $project_filter = [
            'language_id' => $this->defaultLanguage,
        ];
        $project = Projects::getProject($project_id, $project_filter);


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
            'language_id' => $this->defaultLanguage,
        ];
        $projects_categories = [];
        $projectsCategories = ProjectsCategories::get($project_id, $projects_categories_filter);
        if ($projectsCategories != null) {
            foreach ($projectsCategories as $projects_category) {
                $projects_categories[] = $projects_category->user_category_id;
            }
        }

        $userCategories_filter = [
            'languageID' => $this->defaultLanguage,
            'limit' => 9999,
            'role_id' => 4
        ];
        $user_categories = UserCategory::getUserCategories($userCategories_filter);


        $countries_filter = [
            'languageID' => $this->defaultLanguage,
            'limit' => 9999,
        ];
        $countries = Country::getCountries($countries_filter);


        return view('admin.project.edit', compact(
            'user_categories',
            'countries',
            'project',
            'projects_categories'
        ));

    }








    public function deleteAjax(Request $request)
    {
        $id = $request->id;
        Projects::where('id', $id)
            ->first();

        return response()->json(['success' => true], 200);

    }


    public function delete(Request $request)
    {

        $id = intval($request->id);

        Projects::where('id', $id)->delete();

        return response()->json(['success' => true], 200);

    }


    public function fileUploadAjax(Request $request)
    {
        $user_id = Auth::id();

        $request->validate([
            'filedata' => 'required|mimes:pdf,xlx,csv,doc,docx,jpg,jpeg,png,gif|max:2048',
        ]);


        $fileName = stripinput( $request->filedata->getClientOriginalName() );
        $request->filedata->move(public_path('storage/tmp/'. $user_id), $fileName);


        $data = [];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }


    public function fileDeleteAjax(Request $request)
    {
        $user_id = Auth::id();

        $fileName = stripinput( $request->file );
        if (isset($request->patch)) {
            $filePatch = stripinput( $request->patch );
        } else {
            $filePatch = "tmp/". $user_id;
        }
        $filePath = "public/". $filePatch ."/". $fileName;

        $data = [];

        if(Storage::exists($filePath)) {
            $data['message'] = "Success";
            Storage::delete($filePath);
        } else {
            $data['message'] = "File does not exists.";
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }


}
