<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Project\Projects;
class ProjectProposals extends Model
{
    use HasFactory;

    protected $table = 'project_proposals';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public static function getProposals($freelancer_id)
    {
        $proposals = ProjectProposals::where('freelancer_id', $freelancer_id)
            ->orderBy('id', 'DESC')
            ->get();

        return $proposals;
    }

    public static function getProposalsCount($freelancer_id)
    {
        $proposalsCount = ProjectProposals::where('freelancer_id', $freelancer_id)
            ->count();

        return $proposalsCount;
    }

    public static function getProposalsByProjectId($project_id)
    {
        $proposals = ProjectProposals::select(
            'project_proposals.*',
            'users.id as user_id',
            'users.name as user_name',
            'users.profile_photo as user_profile_photo',
            DB::raw("(
                SELECT
                    COUNT(reviews.id)
                FROM reviews
                WHERE reviews.to = users.id
            ) as reviews_count"),
        )
            ->leftJoin('users', 'project_proposals.freelancer_id', '=', 'users.id')
            ->where('project_proposals.project_id', $project_id)
            ->groupBy('project_proposals.id')
            ->get();

        return $proposals;
    }

    public static function getProposalsById($proposal_id)
    {
        $proposals = ProjectProposals::select(
            'project_proposals.*',
            'users.id as user_id',
            'users.name as user_name',
            'users.profile_photo as user_profile_photo'
        )
            ->leftJoin('users', 'project_proposals.freelancer_id', '=', 'users.id')
            ->where('project_proposals.id', $proposal_id)
            ->groupBy('project_proposals.id')
            ->first();

        return $proposals;
    }

    public static function getProposalsCountByProjectId($project_id)
    {
        $proposalsCount = ProjectProposals::where('project_id', $project_id)
            ->count();

        return $proposalsCount;
    }

    public static function getProposal($freelancer_id, $project_id)
    {
        $proposal = ProjectProposals::where('freelancer_id', $freelancer_id)
            ->where('project_id', $project_id)
            ->first();

        return $proposal;
    }

    public static function addProposals($data = [])
    {

        $freelancer_id = (int) $data['freelancer_id'];
        $project_id = (int) $data['project_id'];
        $price = (float) $data['price'];
        $hours = (int) $data['hours'];
        $letter = stripinput(strip_tags($data['letter']));
        $type = isset($data['type']) ? 1 : 0;

        $proposal = ProjectProposals::getProposal($freelancer_id, $project_id);
        if ($proposal) {
            return false;
        }

        $proposals = ProjectProposals::create([
            'freelancer_id' => $freelancer_id,
            'project_id' => $project_id,
            'price' => $price,
            'hours' => $hours,
            'letter' => $letter,
            'type' => $type
        ]);

        return $proposals;

    }

    public static function editProposals($data = [])
    {

        $freelancer_id = (int) $data['freelancer_id'];
        $project_id = (int) $data['project_id'];
        $price = (float) $data['price'];
        $hours = (int) $data['hours'];
        $letter = stripinput(strip_tags($data['letter']));

        $proposal = ProjectProposals::getProposal($freelancer_id, $project_id);
        if ($proposal == null) {
            return false;
        } else {
            $proposal->price = $price;
            $proposal->hours = $hours;
            $proposal->letter = $letter;
            $proposal->updated_at = Carbon::today();

            $proposal->save();
        }

        return $proposal;

    }

    public static function removeProposal($freelancer_id, $project_id, $type = "")
    {
        $proposal = ProjectProposals::where('freelancer_id', (int) $freelancer_id)
            ->where('project_id', (int) $project_id);

        if (isset($type) && $type !== "") {
            $proposal = $proposal->where('type', (int) $type);
        }

        $proposal = $proposal->delete();

        return $proposal;
    }

    public static function removeProposalsByProjectId($project_id)
    {
        $proposal = ProjectProposals::where('project_id', $project_id)
            ->delete();

        return $proposal;
    }

    public function project()
    {
        return $this->belongsTo(Projects::class);
    }
}