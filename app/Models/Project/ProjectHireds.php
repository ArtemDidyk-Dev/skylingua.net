<?php

namespace App\Models\Project;

use App\Models\ProjectProposals;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectHireds extends Model
{
    use HasFactory;

    protected $table = 'project_hireds';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public static function getHireds($freelancer_id, $filter) {
        $hireds = ProjectHireds::where('freelancer_id', $freelancer_id)
            ->where('status', $filter['status'])
            ->get();

        return $hireds;
    }

    public static function getHiredsByEmployer($employer_id, $filter) {
        $hireds = ProjectHireds::where('employer_id', $employer_id)
            ->where('status', $filter['status'])
            ->get();

        return $hireds;
    }


    public static function getHiredsCount($freelancer_id) {
        $hiredsCount = ProjectHireds::where('freelancer_id', $freelancer_id)
            ->count();

        return $hiredsCount;
    }



    public static function getHiredByProjectId($project_id) {
        $hired = ProjectHireds::select(
            'project_hireds.*',
            'users.id as user_id',
            'users.name as user_name',
            'users.profile_photo as user_profile_photo'
        )
            ->leftJoin('users', 'project_hireds.freelancer_id', '=', 'users.id')
            ->where('project_hireds.project_id', $project_id)
            ->first();

        return $hired;
    }

    public static function getHiredsCountByProjectId($project_id) {
        $hiredsCount = ProjectHireds::where('project_id', $project_id)
            ->count();

        return $hiredsCount;
    }

    public static function getHired($freelancer_id, $employer_id) {
        $hired = ProjectHireds::where('freelancer_id', $freelancer_id)
            ->where('employer_id', $employer_id)
            ->first();

        return $hired;
    }

    public static function addHireds($data = [], $proposal = null) {

        $freelancer_id = (int)$data['freelancer_id'];
        $project_id = $data['project_id'] ?? null;
        $price = (float)$data['price'];
        $hours = (int)$data['hours'];
        $letter = stripinput(strip_tags($data['letter']));
        $employer_id = (int)$data['employer_id'];
        $status = $data['status'];

        $hireds = ProjectHireds::create([
            'freelancer_id' => $freelancer_id,
            'project_id' => $project_id,
            'employer_id' => $employer_id,
            'price' => $price,
            'hours' => $hours,
            'letter' => $letter,
            'status' => $status,
        ]);

        if($proposal) {
            $proposal->delete();
        }
        elseif ($hireds) {
            ProjectProposals::removeProposal($data['freelancer_id'], $data['employer_id']);
        }

        return $hireds;

    }

    public static function editHireds($data = []) {

        $freelancer_id = (int)$data['freelancer_id'];
        $employer_id = (int)$data['employer_id'];
        $hired = ProjectHireds::getHired($freelancer_id, $employer_id);
        if ($hired == null) {
            return false;
        } else {

            $price = (isset($data['price']) && !empty($data['price']) ? (float)$data['price'] : $hired->price);
            $hours = (isset($data['hours']) && !empty($data['hours']) ? (int)$data['hours'] : $hired->hours);
            $letter = (isset($data['letter']) && !empty($data['letter']) ? stripinput(strip_tags($data['letter'])) : $hired->letter);
            $status = (isset($data['status']) && !empty($data['status']) ? (int)$data['status'] : $hired->status);
            $accept =  (isset($data['accept']) && !empty($data['accept']) ? (bool)$data['accept'] : $hired->accept);
            $hired->price = $price;
            $hired->hours = $hours;
            $hired->letter = $letter;
            $hired->status = $status;
            $hired->accept = $accept;
            if(isset($data['updated_at']) && !empty($data['updated_at_false'])) {
                $hired->updated_at = stripinput($data['updated_at']);
            }

            $hired->save();
        }

        return $hired;

    }

    public static function removeHireds($freelancer_id, $project_id, $employer_id) {
        $hired = ProjectHireds::where('freelancer_id', $freelancer_id)
            ->where('$employer_id', $employer_id)
            ->delete();

        return $hired;
    }

    public static function removeHiredByProjectId($project_id) {
        $hired = ProjectHireds::where('project_id', $project_id)
            ->delete();

        return $hired;
    }

}
