<?php $this->layout('layouts/hero', [
    'title' => 'Restringido',
]) ?>

<div class="box has-text-centered">
    <form action="<?= $this->url('/staff/login') ?>" method="POST">
        <div class="field">
            <label class="label">Username</label>
            <div class="control">
                <input class="input" name="username" type="text">
            </div>
        </div>

        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input class="input" name="password" type="password">
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="button is-link">Login</button>
            </div>
        </div>
    </form>
</div>
