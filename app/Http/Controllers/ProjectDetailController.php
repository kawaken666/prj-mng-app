<?php

namespace App\Http\Controllers;

use App\Enums\EnumProjectStatus;
use App\Http\Requests\Project\ProjectDetailRequest;
use App\Http\Requests\Project\ProjectDetailEditRequest;
use App\Http\Requests\Project\ProjectDetailUpdateRequest;
use App\Models\Project;
use App\Models\ProjectDetail;
use App\Models\ProjectMember;
use App\Models\ProjectMemberDetail;
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

        if($project_detail->isNotEmpty()){
            // 対象日付のプロジェクト詳細が存在する場合
            return view('project.detail', ['project_detail' => $project_detail]);
        }else{
            // 対象日付のプロジェクト詳細が存在しない場合
            // プロジェクトメンバー情報を取得
            $project_member = ProjectMember::
                                leftjoin('users', 'project_members.user_id', '=', 'users.id')
                                ->select('name', 'users.id')
                                ->where('project_id', $request->project_id)
                                ->get();

            // 画面表示用の配列生成
            foreach($project_member as $member){
                $project_detail_not_existed[] = [
                        'project_id' => $request->project_id,
                        'date' => $date,
                        'status' => EnumProjectStatus::登録なし->name,
                        'project_overview' => '',
                        'name' => $member->name,
                        'id' => $member->id,
                        'result_man_hour' => '',
                        'member_overview' => ''
                ];
            }
            return view('project.detail-not-existed', ['project_detail_not_existed' => $project_detail_not_existed]);
        }
    }

     /**
     * 詳細編集画面表示メソッド
     */
    public function edit(ProjectDetailEditRequest $request){
        // コンテキストをセッションに保存
        session(['project_id' => $request->project_id]);
        session(['date' => $request->date]);
        
        // 対象プロジェクト存在チェック
        $this->existsProject($request->project_id);

        // プロジェクト詳細取得
        $project_detail = $this->getProjectDetail($request->project_id, $request->date);

        if($project_detail->isNotEmpty()){
            // 対象日付のプロジェクト詳細が存在する場合
            // 戻るボタンURL生成
            $back_url = 'location.href=\'./?project_id=' . $project_detail[0]->project_id . '&date=' . $project_detail[0]->date . '\'';
            return view('project.edit', ['project_detail' => $project_detail, 'back_url' => $back_url]);
        }else{
            // 対象日付のプロジェクト詳細が存在しない場合
            // プロジェクトメンバー情報を取得
            $project_member = ProjectMember::
                                leftjoin('users', 'project_members.user_id', '=', 'users.id')
                                ->select('name', 'users.id')
                                ->where('project_id', $request->project_id)
                                ->get();

            // 画面表示用の配列生成
            foreach($project_member as $member){
                $project_detail_not_existed[] = [
                        'project_id' => $request->project_id,
                        'date' => $request->date,
                        'status' => EnumProjectStatus::登録なし->name,
                        'project_overview' => '',
                        'name' => $member->name,
                        'id' => $member->id,
                        'result_man_hour' => '',
                        'member_overview' => ''
                ];
            }

            // 戻るボタンURL生成
            $back_url = 'location.href=\'./?project_id=' . $project_detail_not_existed[0]['project_id'] . '&date=' . $project_detail_not_existed[0]['date'] . '\'';

            return view('project.edit-not-existed', ['project_detail_not_existed' => $project_detail_not_existed, 'back_url' => $back_url]);
        }
    }

    /**
     * 詳細更新メソッド
     */
    public function update(ProjectDetailUpdateRequest $request){
         // プロジェクト存在チェック
        $this->existsProject(session('project_id'));

        // DB更新（プロジェクト詳細）
        // プロジェクト詳細存在チェック
        $project_detail = ProjectDetail::where('project_id', session('project_id'))
                                        ->where('date', session('date'))
                                        ->get();

        if($project_detail->isEmpty()){
            // プロジェクト詳細が存在しない場合、INSERT
            $project_detail = new ProjectDetail();
            $project_detail->project_id = session('project_id');
            $project_detail->status = $request->status;
            $project_detail->overview = $request->overview;
            $project_detail->date = session('date');
            $project_detail->save();
            
            // 後続処理のために$project_detailをINSERTしたもので上書き
            $project_detail = ProjectDetail::where('project_id', session('project_id'))
            ->where('date', session('date'))
            ->get();

        }else{
            // プロジェクト詳細が存在する場合、UPDATE
            ProjectDetail::where('project_id', session('project_id'))
                            ->where('date', session('date'))
                            ->update(['status' => $request->status, 'overview' => $request->overview]);
        }

        // DB更新（メンバー別プロジェクト詳細）
        // メンバー別プロジェクト詳細存在チェック
        foreach(array_map(null, $request->result_man_hour, $request->member_overview, $request->user_id) as $array){
            $project_member_detail = ProjectMemberDetail::where('project_detail_id', $project_detail->first()->project_detail_id)
                                                        ->where('user_id', $array[2])
                                                        ->get();

            if($project_member_detail->isEmpty()){
                // メンバー別プロジェクト詳細が存在しない場合、INSERT
                $project_member_detail = new ProjectMemberDetail();
                $project_member_detail->project_detail_id = $project_detail->first()->project_detail_id;
                $project_member_detail->result_man_hour = $array[0];
                $project_member_detail->overview = $array[1];
                $project_member_detail->user_id = $array[2];
                $project_member_detail->save();
            }else{
                // メンバー別プロジェクト詳細が存在する場合、UPDATE
                ProjectMemberDetail::where('project_detail_id', $project_detail->first()->project_detail_id)
                            ->where('user_id', $array[2])
                            ->update(['result_man_hour' => $array[0], 'overview' => $array[1]]);
            }
        }

        return redirect()->route('project.detail', ['project_id' => session('project_id'), 'date' => session('date')])->with('status', '更新されました');
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
            return redirect()->route('dashboard');
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
            ->select('project_id', 'project_details.status', 'project_details.overview as project_overview', 'project_details.date', 'project_member_details.result_man_hour', 'project_member_details.overview as member_overview', 'users.name', 'users.id')
            ->where('project_details.project_id', $project_id)
            ->where('date', $date)
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
        }
        return $project_detail;
    }
}