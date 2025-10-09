<?php

namespace App\Console;

interface IBase
{
    /**
     * Function that gets run when the module is chosen.
     */
    public function entrypoint(): void;
}
