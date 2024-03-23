<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
    use HasFactory;

    /**
     * プロジェクト詳細を所有しているプロジェクトを取得
     */
    public function project(){
        return $this->belongsTo(Project::class);
    }

    /**
     * メンバー別プロジェクト詳細を取得
     */
    public function projectMemberDetails(){
        return $this->hasMany(ProjectMemberDetail::class);
    }
}
