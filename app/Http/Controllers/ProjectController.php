<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Project\ProjectStoreRequest;
use App\Models\Project;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

const FIRST_DAY_OF_THE_MONTH = '-01';

/**
 * プロジェクトコントローラー
 */
class ProjectController extends Controller
{
    /**
     * 登録画面表示
     */
    public function create()
    {
        return view('project.register', ['users' => User::all()]);
    }

    /**
     * 登録処理
     */
    public function store(ProjectStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            // プロジェクトの登録
            $project = new Project();
            $project->project_name = $request->project_name;
            $project->estimation = $request->estimation;
            $project->release_date = $request->release_date;
            $project->work_date = $request->work_date . FIRST_DAY_OF_THE_MONTH;
            $project->save();

            // 登録したプロジェクトを取得
            $project = Project::find($project->id);

            // プロジェクト、ユーザー間の中間テーブルへの登録
            foreach ($request->user_id as $user_id) {
                $project->users()->attach($user_id);
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            dump($e->getMessage()); // デバッグ用
        }

        return redirect('dashboard');
    }
}
