<?php

namespace App\Console;

interface IModule extends IBase
{
    /**
     * List available data on table
     */
    public function list(): void;
    /**
     * Add element to table
     */
    public function add(): void;
    /**
     * Delete element from table
     */
    public function delete(): void;
}
