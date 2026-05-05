<?php
namespace App\Console\Users;

use Ahc\Cli\Input\Command;
use App\Models\User;

class UsersListCommand extends Command
{
    public function __construct()
    {
        parent::__construct('users:list', 'Show all users');
    }

    public function execute()
    {
        $users = User::all()->toArray();
        $this->app()->io()->writer()->table($users);
    }
}
