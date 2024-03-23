<?php
namespace App\Dto\ProjectDetail;

class DispPrjDetailDto
{   
    // プロジェクトID
    public $project_id;

    // 進捗ステータス
    public $status;

    // プロジェクト概要
    public $project_overview;

    // 日付
    public $date;

    public function __construct($project_id, $status, $project_overview, $date)
    {   
        $this->project_id = $project_id;
        $this->status = $status;
        $this->project_overview = $project_overview;
        $this->date = $date;
    }
}
