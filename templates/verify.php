<?php $this->layout('layouts/hero', ['title' => 'Registro']) ?>

<div class="columns is-centered">
    <div class="column is-5-tablet is-4-desktop is-3-widescreen">
        <div class="box">
            <form action="<?=$this->url('/verify')?>" method="POST">
                <div class="field">
                    <label class="label">NIU</label>
                    <div class="control">
                        <input type="text" class="input" disabled value="<?= $this->e($verify->niu) ?>" />
                    </div>
                </div>
                <div class="field">
                    <label class="label">Contraseña</label>
                    <div class="control">
                        <input name="password" type="password" placeholder="*******" class="input" required />
                    </div>
                </div>
                <div class="field">
                    <label class="label">Repite tu contraseña</label>
                    <div class="control">
                        <input name="password_repeat" type="password" placeholder="*******" class="input" required />
                    </div>
                </div>
                <div class="field">
                    <button type="submit" class="button is-success">Registrar</button>
                </div>
                <input type="hidden" name="code" value="<?= $this->e($verify->code) ?>" />
            </form>
        </div>
    </div>
</div>
