<?php

namespace App\Enums;

use App\Wrappers\Env;
use App\Wrappers\Misc;
use Ramsey\Uuid\Uuid;

/**
 * Enumarate all valid review types.
 */
enum ReviewTypesEnum: int
{
    case TEACHER = 0;
    case SUBJECT = 1;
    case LEGEND = 2;

    public function displayName(): string
    {
        return match ($this) {
            self::TEACHER, self::LEGEND => 'Profesor',
            self::SUBJECT => 'Asignatura',
        };
    }

    public function isValidTarget(string $target): bool
    {
        return match ($this) {
            self::TEACHER => Uuid::isValid($target),
            self::SUBJECT => preg_match('/^\d+;\d+$/', $target) === 1,
            self::LEGEND => is_numeric($target),
        };
    }

    public function isReadOnly(): bool {
        return match ($this) {
            self::LEGEND => true,
            default => false,
        };
    }

    /**
     * Get valid url for redirection to page containing specific reviews.
     */
    public function url(string $target): ?string
    {
        if ($this === self::TEACHER) {
            return Env::app_url('/profesores', ['idnc' => $target]);
        } elseif ($this === Self::LEGEND) {
            return Env::app_url('/legends/' . $target);
        } elseif ($this === self::SUBJECT) {
            $arr = Misc::planAsignaturaSplit($target);
            if ($arr === null) {
                return null;
            }

            return Env::app_url('/planes/' . $arr[0] . '/asignaturas/' . $arr[1]);
        }

        return null;
    }
}
