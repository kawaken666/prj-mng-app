<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ProjectDetailRequest;
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
        $project = Project::where('project_id', $request->project_id)->get();
        // 存在しない場合、ダッシュボードにリダイレクト                
        if($project->isEmpty()){
            Log::debug('プロジェクト未存在');
            return redirect('dashboard');
        }

        // 日付設定（フォームに対象日付がない場合は当日）
        $date = (isset($request->date)) ? $request->date : date('Y-m-d');

        // プロジェクト詳細とそれに紐づくメンバーごとの状況詳細を取得
        $project_detail = ProjectDetail::
                        leftjoin('project_member_details', 'project_details.project_detail_id', '=', 'project_member_details.project_detail_id')
                        ->join('users', 'project_member_details.user_id', '=', 'users.id')
                        ->select('project_id', 'project_details.status', 'project_details.overview as project_overview', 'project_details.date', 'project_member_details.result_man_hour', 'project_member_details.overview as member_overview', 'users.name')
                        ->where('project_details.project_detail_id', $request->project_id)
                        ->where('date', $date)
                        ->get();
        
        // プロジェクトメンバー情報を取得
        $project_member = ProjectMember::
                        leftjoin('users', 'project_members.user_id', '=', 'users.id')
                        ->select('name')
                        ->where('project_id', $request->project_id)
                        ->get();

        if($project_detail->isNotEmpty()){
            // 対象日付のプロジェクト詳細が登録されていた場合
            // statusのコード値をコード名称に変換
             switch ($project_detail[0]->status) {
                 case 0:
                     $project_detail[0]->status = 'オンスケ';
                     break;
                 case 1:
                     $project_detail[0]->status = '遅延';
                     break;
                 case 2:
                     $project_detail[0]->status = '前倒し';
                     break;
                 default:
                     $project_detail[0]->status = '登録なし';
                     break;
             }
        }else{
            // 対象日付のプロジェクト詳細が登録されてない場合
            foreach($project_member as $member){
                // 登録がなかった場合のモデルインスタンス生成処理
                $project_detail[] = new ProjectDetail([
                    'project_id' => $request->project_id,
                    'date' => $date,
                    'status' => '登録なし',
                    'project_overview' => '',
                    'name' => $member->name,
                    'result_man_hour' => '',
                    'member_overview' => ''
                ]);
            }
        }
        return view('project.detail', ['project_detail' => $project_detail]);
    }

     /**
     * 詳細編集画面表示メソッド
     */
    public function edit(ProjectDetailRequest $request){
        return view('project.detail.edit');
        //TODO 実装途中
    }

    // 以下、privateメソッド------------------------------

    /**
     * プロジェクト詳細取得
     */
    private function getProjectDetail($project_id, $date){
        return view('project.detail.edit');
        //TODO 実装途中
    }
}
