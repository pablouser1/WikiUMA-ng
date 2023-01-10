<?php $this->layout('layouts/hero', ['title' => 'Iniciar sesión']) ?>

<div class="columns is-centered">
    <div class="column is-5-tablet is-4-desktop is-3-widescreen">
        <div class="box">
            <form action="<?=$this->url('/login')?>" method="POST">
                <div class="field">
                    <label class="label">
                        <?= $this->insert('components/icon/main', ['icon' => 'user', 'text' => 'NIU']) ?>
                    </label>
                    <div class="control">
                        <input name="niu" type="text" class="input" placeholder="061..." required />
                    </div>
                </div>
                <div class="field">
                    <label class="label">
                        <?= $this->insert('components/icon/main', ['icon' => 'lock', 'text' => 'Contraseña']) ?>
                    </label>
                    <div class="control">
                        <input name="password" type="password" placeholder="*******" class="input" required />
                    </div>
                </div>
                <div class="field">
                    <button type="submit" class="button is-success">Iniciar sesión</button>
                </div>
            </form>
        </div>
    </div>
</div>
