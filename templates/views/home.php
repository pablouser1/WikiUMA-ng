<?php $this->layout('layouts/hero', [
    'title' => 'Inicio',
]) ?>

<div class="box">
    <p class="title">¡Bienvenid@ a WikiUMA <small title="nueva generación">ng</small>!</p>
    <p class="subtitle">Califica a tus profesores de forma anónima y más</p>
    <div class="buttons is-centered is-responsive">
        <?php foreach ($this->links() as $link) : ?>
            <a class="button <?= $this->e($link['color']) ?>" href="<?= $this->url($link['path']) ?>">
                <span class="icon-text">
                    <span class="icon">
                        <?php $this->insert('partials/icon', ['icon' => $this->e($link['icon'])]) ?>
                    </span>
                    <span><?= $this->e($link['name']) ?></span>
                </span>
            </a>
        <?php endforeach ?>
    </div>
    <?php $this->insert('partials/search-server') ?>
    <hr />
    <div class="field is-grouped is-grouped-multiline is-grouped-centered">
        <?php $this->insert('partials/stat', ['title' => 'Valoraciones totales', 'value' => $stats->total, 'size' => 'medium']) ?>
    </div>
</div>
