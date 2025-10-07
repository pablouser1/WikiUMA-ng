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

    public function displayName(): string
    {
        return match ($this) {
            self::PENDING => 'Pendiente',
            self::ACCEPTED => 'Aceptado',
            self::DENIED => 'Rechazado',
        };
    }

    public function actionTaken(): string
    {
        return match ($this) {
            self::ACCEPTED => 'eliminar esta valoración de la plataforma',
            self::DENIED => 'mantener esta valoración en la plataforma',
            default => '???',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'is-primary',
            self::ACCEPTED => 'is-success',
            self::DENIED => 'is-danger',
        };
    }
}
