<?php

namespace App\Http\Controllers;

use App\Enums\EnumProjectStatus;
use App\Http\Requests\Project\ProjectDetailRequest;
use App\Http\Requests\Project\ProjectDetailEditRequest;
use App\Models\Project;
use App\Models\ProjectDetail;
use App\Models\ProjectMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectDetailController extends Controller
{
    /**
     * 詳細画面表示メソッド
     */
    public function index(ProjectDetailRequest $request){
        // 対象プロジェクト存在チェック
        $this->existsProject($request->project_id);

        // 日付設定（フォームに対象日付がない場合は当日）
        $date = (isset($request->date)) ? $request->date : date('Y-m-d');

        // プロジェクト詳細取得
        $project_detail = $this->getProjectDetail($request->project_id, $date);

        return view('project.detail', ['project_detail' => $project_detail]);
    }

     /**
     * 詳細編集画面表示メソッド
     */
    public function edit(ProjectDetailEditRequest $request){
        // 対象プロジェクト存在チェック
        $this->existsProject($request->project_id);

        // プロジェクト詳細取得
        $project_detail = $this->getProjectDetail($request->project_id, $request->date);

        return view('project.edit', ['project_detail' => $project_detail]);
    }
    
    // 以下、privateメソッド------------------------------

    /**
     * 対象プロジェクト存在チェック
     */
    private function existsProject($project_id){
        $project = Project::where('project_id', $project_id)->get();
        // 存在しない場合、ダッシュボードにリダイレクト                
        if($project->isEmpty()){
            Log::debug('プロジェクト未存在');
            return redirect('dashboard');
        }
    }

    /**
     * プロジェクト詳細取得メソッド
     */
    private function getProjectDetail($project_id, $date){
        // プロジェクト詳細とそれに紐づくメンバーごとの状況詳細を取得
        $project_detail = ProjectDetail::
        leftjoin('project_member_details', 'project_details.project_detail_id', '=', 'project_member_details.project_detail_id')
        ->join('users', 'project_member_details.user_id', '=', 'users.id')
        ->select('project_id', 'project_details.status', 'project_details.overview as project_overview', 'project_details.date', 'project_member_details.result_man_hour', 'project_member_details.overview as member_overview', 'users.name')
        ->where('project_details.project_detail_id', $project_id)
        ->where('date', $date)
        ->get();

        // プロジェクトメンバー情報を取得
        $project_member = ProjectMember::
                        leftjoin('users', 'project_members.user_id', '=', 'users.id')
                        ->select('name')
                        ->where('project_id', $project_id)
                        ->get();

        if($project_detail->isNotEmpty()){
            // 対象日付のプロジェクト詳細が登録されていた場合
            // statusのコード値をコード名称に変換
            switch ($project_detail[0]->status) {
                case EnumProjectStatus::オンスケ->value:
                    $project_detail[0]->status = EnumProjectStatus::オンスケ->name;
                    break;
                case EnumProjectStatus::遅延->value:
                    $project_detail[0]->status = EnumProjectStatus::遅延->name;
                    break;
                case EnumProjectStatus::前倒し->value:
                    $project_detail[0]->status = EnumProjectStatus::前倒し->name;
                    break;
                default:
                    $project_detail[0]->status = EnumProjectStatus::登録なし->name;
                    break;
            }
        }else{
            // 対象日付のプロジェクト詳細が登録されてない場合
            foreach($project_member as $member){
                // 登録がなかった場合のモデルインスタンス生成処理
                $project_detail[] = new ProjectDetail([
                    'project_id' => $project_id,
                    'date' => $date,
                    'status' => EnumProjectStatus::登録なし->name,
                    'project_overview' => '',
                    'name' => $member->name,
                    'result_man_hour' => '',
                    'member_overview' => ''
                ]);
            }
        }
        return $project_detail;
    }
}
