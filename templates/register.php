<?php $this->layout('layouts/hero', ['title' => 'Registro']) ?>

<div class="columns is-centered">
    <div class="column is-5-tablet is-4-desktop is-3-widescreen">
        <div class="box">
            <form action="<?=$this->url('/register')?>" method="POST">
                <div class="field">
                    <label class="label">
                        <?= $this->insert('components/icon/main', ['icon' => 'user', 'text' => 'NIU']) ?>
                    </label>
                    <div class="control">
                        <input name="niu" type="text" class="input" placeholder="061..." required />
                    </div>
                </div>
                <?= $this->insert('components/captcha') ?>
                <div class="field">
                    <button type="submit" class="button is-success">Comenzar</button>
                </div>
            </form>
        </div>
    </div>
</div>
