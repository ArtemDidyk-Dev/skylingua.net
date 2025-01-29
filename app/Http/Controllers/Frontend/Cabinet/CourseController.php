<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Requests\Course\CourseAdmin;
use App\Http\Requests\Course\CourseRequest;
use App\Http\Resources\CoursesResources;
use App\Models\Access;
use App\Models\Course;
use App\Models\CourseFile;
use App\Models\User;
use App\Services\CourseServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CourseController
{
    public function __construct(
        private CourseServices $courseServices,
    )
    {
    }

    public function index()
    {

        $courses = CoursesResources::collection(Course::with(['files', 'access'])->where('user_id', Auth::id())->orderByDesc('id')->get());
        $user = Auth::user();

        return view('frontend.dashboard.freelancer.courses', compact('courses', 'user'));
    }

    public function create()
    {
        $accessTypes = Access::getAccessTypes();
        $access_select = Access::getAccessDefault();
        $user = Auth::user();
        return view('frontend.dashboard.freelancer.courses-create', compact('user', 'accessTypes', 'access_select'));
    }

    public function update(CourseRequest $request, Course $course)
    {

        try {
            $data = $request->validated();
            $data['user'] = Auth::id();
            $this->courseServices->updateCourse($data, $request->files->get('file'), $course);
            return response()->json(['message' => 'Saved']);
        }
        catch (\Exception $exception){
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

    }

    public function store(CourseRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user'] = Auth::id();
            $this->courseServices->addCourse($data, $request->files->get('file'));
            return response()->json(['message' => 'Saved']);
        }
        catch (\Exception $exception){
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function destroy(Course $course): JsonResponse
    {

        try {
            $course->delete();
            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (\InvalidArgumentException $exception) {
            return response()->json($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }

    }

    public function edit(Course $course)
    {
        $course->load(['access', 'files']);
        $files = $course->files->map(function ($file) use ($course) {
            $file->link = route('frontend.dashboard.courses.deleteFile', [$course->id, $file->id]);
            return $file;
        });
        $user = Auth::user();
        $accessTypes = Access::getAccessTypes();
        $access_select = $course->access;
        $imgPromo = $course?->promo_img;
        return view('frontend.dashboard.freelancer.course-update', compact('course', 'user', 'files', 'accessTypes', 'access_select', 'imgPromo'));
    }

    public function deleteFile(int $courseId, string $fileId): JsonResponse|AnonymousResourceCollection
    {

        $file = CourseFile::find($fileId);
        if (!$file->course_id == $courseId) {
            throw new NotFoundHttpException();
        }
        try {
            $file->delete();
            return CoursesResources::collection(Course::where('user_id', Auth::id())->orderByDesc('id')->get());
        } catch (\InvalidArgumentException $exception) {
            return response()->json($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }

    }
}
