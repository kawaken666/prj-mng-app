<?php

namespace App\Enums;

enum EnumProjectStatus:int
{
    case オンスケ = 0;
    case 遅延 = 1;
    case 前倒し = 2;
    case 登録なし = 3;
}