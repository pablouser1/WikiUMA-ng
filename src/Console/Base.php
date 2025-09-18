<?php
namespace App\Console;
use Illuminate\Database\Eloquent\Collection;
use League\CLImate\CLImate;

abstract class Base
{
    protected CLImate $cli;

    public function __construct(CLImate $cli)
    {
        $this->cli = $cli;
    }

    protected function radio(array $options): void
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

        call_user_func($runner);
    }

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

    protected function radioModel(Collection $m, string $key): int
    {
        $names = array_column($m->toArray(), $key);
        $input = $this->cli->radio("Choose an option:", $names);
        $res = $input->prompt();

        $index = array_search($res, $names);
        return $index;
    }

    protected function radioEnum(array $enum): int
    {
        $names = array_column($enum, "name");
        $input = $this->cli->radio("Choose an option:", $names);
        $res = $input->prompt();

        $index = array_search($res, $names);
        return $enum[$index]->value;
    }
}
