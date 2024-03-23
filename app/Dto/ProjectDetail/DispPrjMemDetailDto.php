<?php

declare(strict_types=1);

namespace App\Dto\ProjectDetail;

class DispPrjMemDetailDto
{
    // ユーザーID
    public $id;

    // ユーザー氏名
    public $name;

    // 消費工数
    public $result_man_hour;

    // メンバー別プロジェクト概要
    public $member_overview;

    public function __construct($id, $name, $result_man_hour, $member_overview)
    {
        $this->id = $id;
        $this->name = $name;
        $this->result_man_hour = $result_man_hour;
        $this->member_overview = $member_overview;
    }
}
