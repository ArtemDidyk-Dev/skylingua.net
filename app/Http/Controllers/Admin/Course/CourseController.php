<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseAdmin;
use App\Models\Access;
use App\Models\Course;
use App\Models\CourseFile;
use App\Models\User;
use App\Services\CourseServices;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{

    public function __construct(
        private CourseServices $courseServices,
    )
    {
    }

    public function index()
    {
        $courses = Course::orderBy('id', 'DESC')->paginate(10);

        return view('admin.course.index', compact('courses'));
    }

    public function create()
    {
        $users = User::with('roles')
            ->whereHas('roles', function ($q) {
                $q->where('id', 4);
            })->where(['status' => 1, 'approve' => 1])->get();
        $accessTypes = Access::getAccessTypes();
        $access_select = Access::getAccessDefault();
        return view('admin.course.create', compact('users', 'accessTypes', 'access_select'));
    }

    public function update(CourseAdmin $request, Course $course)
    {
        try {
            $data = $request->validated();
            $this->courseServices->updateCourse($data, $request->files->get('file'), $course);
            return response()->json(['message' => 'Saved']);
        }
        catch (\Exception $exception){
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

    }

    public function store(CourseAdmin $request)
    {
        try {
            $data = $request->validated();
            $this->courseServices->addCourse($data, $request->files->get('file'));
            return response()->json(['message' => 'Saved']);
        }
        catch (\Exception $exception){
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function delete($id): JsonResponse
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return response()->json(['success' => true], 200);
    }

    public function edit(Course $course)
    {
        $course->load(['access', 'files']);
        $users = User::with('roles')
            ->whereHas('roles', function ($q) {
                $q->where('id', 4);
            })->where(['status' => 1, 'approve' => 1])->get();
        $files = $course->files->map(function ($file) use ($course) {
            $file->link = route('admin.courses.delete.file', [$course->id, $file->id]);
            return $file;
        });

        $accessTypes = Access::getAccessTypes();
        $access_select = $course->access;
        $imgPromo = $course?->promo_img;
        return view('admin.course.edit', compact('course', 'users', 'files', 'accessTypes', 'access_select', 'imgPromo'));
    }

    public function deleteFile(Course $course, CourseFile $file): JsonResponse
    {
        try {
            $file->delete();
            return response()->json([], 204);
        } catch (\InvalidArgumentException $exception) {
            return response()->json($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }

    }
}
