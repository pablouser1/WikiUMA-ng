<?php
namespace App\Console\Users;

use Ahc\Cli\Input\Command;
use App\Models\User;

class UsersDeleteCommand extends Command
{
    public function __construct()
    {
        parent::__construct('users:delete', 'Delete admin from db');

        $this->argument('<id>', 'Id of user to be deleted');
    }

    /**
     * @param int $id
     *
     * @return int Return code
     */
    public function execute($id)
    {
        $writer = $this->app()->io()->writer();
        $user = User::find($id);
        if ($user === null) {
            $writer->error("Could not find user with id: $id", true);
            return 1;
        }

        $user->delete();
        $writer->ok('User deleted!', true);

        return 0;
    }
}
