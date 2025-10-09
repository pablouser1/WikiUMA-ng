<?php

namespace App\Console\Modules;

use App\Console\Base;
use App\Console\IModule;
use App\Models\User;

/**
 * Staff Module.
 */
class UsersModule extends Base implements IModule
{
    /**
     * {@inheritdoc}
     */
    public function entrypoint(): void
    {
        $this->cli->bold()->out("Users");
        $this->radioSection();
    }

    /**
     * Get all available staff.
     */
    public function list(): void
    {
        $users = User::all();

        foreach ($users as $i => $user) {
            $this->cli->inline($i + 1);
            $this->cli->inline(". ");
            $this->cli->out("{$user->full_name} ({$user->username})");
        }
    }

    /**
     * Add a staff.
     *
     * @todo Figure out how to avoid showing password in cleartext.
     */
    public function add(): void
    {
        // First name
        $in = $this->cli->input("Write the first name:");
        $firstName = $in->prompt();

        // Last name
        $in = $this->cli->input("Write the last name:");
        $lastName = $in->prompt();

        // Username
        $in = $this->cli->input("Write the username:");
        $username = $in->prompt();

        // Password
        $in = $this->cli->input("Write the password:");
        $plainPassword = $in->prompt();

        $user = new User([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $username,
        ]);

        $user->password = password_hash($plainPassword, PASSWORD_BCRYPT);

        $ok = $user->save();
        if (!$ok) {
            $this->cli->backgroundRed()->error("Could not create user!");
            return;
        }

        $this->cli->backgroundGreen()->out("User created!");
    }

    /**
     * Delete staff.
     */
    public function delete(): void
    {
        $users = User::all();
        $index = $this->radioModel($users, "full_name");
        $user = $users[$index];
        $ok = $user->delete();
        if (!$ok) {
            $this->cli->backgroundRed()->error("Could not delete user!");
        }

        $this->cli->backgroundGreen()->out("Deleted!");
    }
}
