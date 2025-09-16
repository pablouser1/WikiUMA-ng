<?php
namespace App\Enums;

enum ReportStatusEnum: int
{
    case PENDING = 0;
    case ACCEPTED = 1;
    case DENIED = 2;
}
