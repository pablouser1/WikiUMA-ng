<?php

namespace App\Enums;

use App\Wrappers\Env;
use App\Wrappers\Misc;

/**
 * Enumarate all valid review types.
 */
enum ReviewTypesEnum: int
{
    case TEACHER = 0;
    case SUBJECT = 1;

    public function displayName(): string
    {
        return match ($this) {
            self::TEACHER => 'Profesor',
            self::SUBJECT => 'Asignatura',
        };
    }

    /**
     * Get valid url for redirection to page containing specific reviews.
     */
    public function url(string $target): ?string
    {
        if ($this === self::TEACHER) {
            return Env::app_url('/profesores', ['idnc' => $target]);
        } elseif ($this === self::SUBJECT) {
            $arr = Misc::planAsignaturaSplit($target);
            return Env::app_url('/planes/' . $arr[0] . '/asignaturas/' . $arr[1]);
        }

        return null;
    }
}
