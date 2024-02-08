<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project\Projects;
class ProjectsCategories extends Model
{
    use HasFactory;

    protected $table = 'projects_categories';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public static function get($project_id, $filter = [])
    {
        $projectsCategories = ProjectsCategories::select(
            'projects_categories.*',
            'user_categories_translations.name as user_category_name',
        )
            ->leftJoin('user_categories_translations', function ($join) use ($filter) {
                $join->on('projects_categories.user_category_id', '=', 'user_categories_translations.user_category_id')
                    ->where('user_categories_translations.language_id', '=', $filter['language_id']);
            })
            ->where('projects_categories.project_id', $project_id)
            ->get();

        return $projectsCategories;
    }


    public static function add($project_id, $user_category_id)
    {
        $projectsCategory = ProjectsCategories::create([
            'project_id' => (int) $project_id,
            'user_category_id' => (int) $user_category_id,
        ]);

        return $projectsCategory;
    }


    public static function deleteByProjectId($project_id)
    {
        $project_id = (int) $project_id;
        if ($project_id < 1) {
            return false;
        } else {
            $projectsCategory = ProjectsCategories::where('project_id', $project_id)
                ->delete();
        }

        return $projectsCategory;
    }

    public function projects() {
        return $this->belongsToMany(Projects::class, 'projects_categories', 'user_category_id', 'project_id');
    }
}
