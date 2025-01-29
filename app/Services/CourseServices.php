<?php

namespace App\Services;

use App\Models\Access;
use App\Models\Course;
use App\Models\Pay\Pay;
use App\Models\User;


class CourseServices
{
    public function __construct(
        private FileServices $fileServices
    ) {
    }

    public function addCourse(array $data, ?array $files)
    {
        $user = User::find($data['user']);

        $course = $user->courses()->create([
            'name' => $data['title'],
            'description' => $data['description'],
        ]);
        if (isset($files, $files['promoImage'])) {
            $this->fileServices->savePromo($files['promoImage'], $course);
            unset($files['promoImage']);
        }

        if (isset($files)) {
            $this->fileServices->savaFiles($files, $course);
        }

        $access = $course->access()->create([
            'type' => $data['access_select'],
        ]);
        if ($data['access_select'] !== Access::OPEN_TO_EVERYONE && $data['access_select'] !== Access::SUBSCRIBERS_ONLY) {
            $access->update(['price' => $data['price']]);
        }

        return $course;
    }

    public function updateCourse(array $data, ?array $files, Course $course)
    {
        $course->update([
            'name' => $data['title'],
            'description' => $data['description'],
            'user_id' => $data['user'],
        ]);

        if ($data['access_select'] === Access::OPEN_TO_EVERYONE) {
            $course->update(['promo_img' => null]);
        }

        if (isset($files, $files['promoImage'])) {
            $this->fileServices->savePromo($files['promoImage'], $course);
            unset($files['promoImage']);
        }
        if (isset($files)) {
            $this->fileServices->savaFiles($files, $course);
        }

        $course->access()->update([
            'type' => $data['access_select'],
        ]);
        if ($data['access_select'] !== Access::OPEN_TO_EVERYONE && $data['access_select'] !== Access::SUBSCRIBERS_ONLY) {
            $course->access->update(['price' => $data['price']]);
        }


    }

    public function getCourses(User $teacher, ?int $userId)
    {
        $em = $this->findUser($userId);
        return $teacher->courses->map(function ($course) use ($em, $teacher) {
            $type = $course->access->type;
            $course->show = $this->shouldShowCourse($em, $teacher, $course, $type);
            if (!$course->show) {
                $course->linkPay = $this->getLinkAndTextCourse($course, $teacher);
            }

            return $course;
        });
    }

    private function findUser(?int $userId): ?User
    {
        return $userId ? User::find($userId) : null;
    }

    public function shouldShowCourse(?User $em, User $teacher, $course, string $type): bool
    {
        return match ($type) {
            Access::SUBSCRIBERS_OR_ONE_TIME_PAYMENT => $this->isSubscribedOrPaid($em, $teacher, $course),
            Access::SUBSCRIBERS_ONLY => $this->isSubscribed($em, $teacher),
            Access::ONE_TIME_PAYMENT_ONLY => $this->isPaid($em, $teacher, $course),
            default => true,
        };
    }

    public function isSubscribed(?User $em, User $teacher): bool
    {
        if (!$this->isValidUser($em) || !$teacher->subscription) {
            return false;
        }

        return $em?->subscriptions()->where([
            'subscription_id' => $teacher->subscription->id,
            'active' => true,
        ])->exists();
    }

    private function isSubscribedOrPaid(?User $em, User $teacher, $course): bool
    {
        return $this->isSubscribed($em, $teacher) || $this->isPaid($em, $teacher, $course);
    }

    private function isPaid(?User $em, User $teacher, $course): bool
    {
        if (!$this->isValidUser($em)) {
            return false;
        }

        return Pay::where([
            'employer_id' => $em->id,
            'freelancer_id' => $teacher->id,
            'access_id' => $course->access->id,
            'status' => 2,
        ])->exists();
    }

    private function isValidUser(?User $em): bool
    {
        return $em !== null;
    }

    private function getLinkAndTextCourse(Course $course, User $user): array
    {

        return match ($course->access->type) {
            Access::SUBSCRIBERS_OR_ONE_TIME_PAYMENT, Access::ONE_TIME_PAYMENT_ONLY => [
                'link' => route('frontend.pay.access',$course->access),
                'text' => "Get access (€{$course->access->price})"
            ],
            Access::SUBSCRIBERS_ONLY => [
                'link' => route('frontend.pay.subscribers', $user->subscription),
                'text' => 'Only Subscribe'
            ],
        };
    }
}
