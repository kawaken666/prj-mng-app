<?php
namespace App\Dto\ProjectDetail;

class DispPrjMemDetailDto
{   
    // メンバー氏名
    public $name;

    // 消費工数
    public $result_man_hour;

    // メンバー別プロジェクト概要
    public $member_overview;

    public function __construct($name, $result_man_hour, $member_overview)
    {   
        $this->name = $name;
        $this->result_man_hour = $result_man_hour;
        $this->member_overview = $member_overview;
    }
}