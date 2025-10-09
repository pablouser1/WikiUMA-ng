<?php

namespace App\Console;

use Illuminate\Database\Eloquent\Collection;
use League\CLImate\CLImate;

/**
 * Base class for all CLI modules.
 */
abstract class Base
{
    protected CLImate $cli;

    public function __construct(CLImate $cli)
    {
        $this->cli = $cli;
    }

    /**
     * Let user pick from multiple options and run function linked to it.
     */
    protected function radio(array $options, array $args = []): void
    {
        $names = array_column($options, 'name');
        $input = $this->cli->radio("Choose an option:", $names);
        $res = $input->prompt();

        $index = array_search($res, $names);
        $runner = $options[$index]["runner"];

        if (is_string($runner[0])) {
            $class = new $runner[0]($this->cli);

            $runner = [$class, $runner[1]];
        }

        call_user_func_array($runner, $args);
    }

    /**
     * Predefined radio with common options.
     *
     * @see Base::radio
     */
    protected function radioSection(): void
    {
        $this->radio([
            [
                "name" => "List",
                "runner" => [$this, "list"]
            ],
            [
                "name" => "Add",
                "runner" => [$this, "add"]
            ],
            [
                "name" => "Delete",
                "runner" => [$this, "delete"]
            ]
        ]);
    }

    /**
     * From a Eloquent Collection and a key,
     * Get index of item picked.
     */
    protected function radioModel(Collection $m, string $key): int
    {
        $names = array_column($m->toArray(), $key);
        $input = $this->cli->radio("Choose an option:", $names);
        $res = $input->prompt();

        $index = array_search($res, $names);
        return $index;
    }
}
