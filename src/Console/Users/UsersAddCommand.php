<?php
namespace App\Console\Users;

use Ahc\Cli\Input\Command;
use Ahc\Cli\IO\Interactor;
use App\Models\User;

class UsersAddCommand extends Command
{
    public function __construct()
    {
        parent::__construct('users:add', 'Add admin to db');

        $this
            ->option('--username', 'Username')
            ->option('--password', 'Password')
            ->option('--firstName', 'First name')
            ->option('--lastName', 'Last name')
            ->option('--email', 'Email');
    }

    public function interact(Interactor $io) : void
    {
        if (!$this->username) {
            $this->set('username', $io->prompt('Enter username'));
        }

        if (!$this->password) {
            $this->set('password', $io->promptHidden('Enter password'));
        }

        if (!$this->firstName) {
            $this->set('firstName', $io->prompt('Enter first name'));
        }

        if (!$this->lastName) {
            $this->set('lastName', $io->prompt('Enter last name'));
        }

        if (!$this->email) {
            $this->set('email', $io->prompt('Enter email'));
        }
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     */
    public function execute($username, $password, $firstName, $lastName, $email)
    {
        $writer = $this->app()->io()->writer();

        $user = new User();
        $user->username = $username;
        $user->password = password_hash($password, PASSWORD_BCRYPT);
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;
        $user->save();

        $writer->ok('Saved', true);
    }
}
