<?php $this->layout('layouts/hero', [
    'title' => 'Informes',
    'withNavbar' => true,
    'withCaptcha' => true,
]) ?>

<div class="box">
    <p class="title">Consulta de estado de informe</p>
    <form action="<?= $this->url('/reports') ?>" method="POST">
        <div class="field">
            <label class="label">
                <span class="icon-text">
                    <span class="icon">
                        <?php $this->insert('partials/icon', ['icon' => 'user-scan']) ?>
                    </span>
                    <span>UUID</span>
                </span>
            </label>
            <div class="control">
                <input name="uuid" class="input" type="text" autocomplete="off" />
            </div>
        </div>
        <div class="field">
            <altcha-widget challengeurl="<?= $this->url('/challenge') ?>"></altcha-widget>
        </div>
        <div class="field">
            <div class="control">
                <button type="submit" class="button is-success">
                    <span class="icon-text">
                        <span class="icon">
                            <?php $this->insert('partials/icon', ['icon' => 'send']) ?>
                        </span>
                        <span>Consultar</span>
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>
