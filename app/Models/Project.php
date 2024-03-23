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
     * プロジェクトに所属するユーザーを取得
     */
    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
