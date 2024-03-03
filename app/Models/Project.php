<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * プロジェクト詳細を取得
     */
    public function projectDetails(){
        return $this->hasMany(ProjectDetail::class);
    }

    /**
     * プロジェクトメンバーを取得
     */
    public function projectMembers(){
        return $this->hasMany(ProjectMember::class);
    }
}
