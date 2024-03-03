<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    use HasFactory;

    /**
     * プロジェクトメンバーを所有しているプロジェクトを取得
     */
    public function projectMember(){
        return $this->belongsTo(Project::class);
    }

    /**
     * プロジェクトメンバーを所有しているユーザーを取得
     */
    public function User(){
        return $this->belongsTo(User::class);
    }
}
