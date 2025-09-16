<?php
namespace App\Enums;

/**
 * Enumarate all valid report status.
 */
enum ReportStatusEnum: int
{
    case PENDING = 0;
    case ACCEPTED = 1;
    case DENIED = 2;
}
