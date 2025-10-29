<?php $this->layout('layouts/hero', [
    'title' => 'Inicio',
    'uri' => $uri,
]) ?>

<div class="box has-text-centered">
    <p class="title">¡Bienvenid@ a WikiUMA <small title="nueva generación">ng</small>!</p>
    <p class="subtitle">Califica a tus profesores de forma anónima y más</p>
    <div class="buttons is-centered is-responsive">
        <a class="button is-primary" href="<?= $this->url('/centros') ?>">
            <span class="icon-text">
                <span class="icon">
                    <?php $this->insert('partials/icon', ['icon' => 'building']) ?>
                </span>
                <span>Encontrar profesor en directorio</span>
            </span>
        </a>
    </div>
    <?php $this->insert('partials/search-duma') ?>
    <?php if ($stats->total > 0): ?>
        <hr />
        <div class="field is-grouped is-grouped-multiline is-grouped-centered">
            <?php $this->insert('partials/stat', ['title' => 'Valoraciones totales', 'value' => $stats->total, 'size' => 'medium']) ?>
            <?php $this->insert('partials/stat', ['title' => 'Nota media', 'value' => $stats->avg, 'size' => 'medium', 'withColor' => true]) ?>
        </div>
    <?php endif ?>
</div>
