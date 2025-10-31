<?php $this->layout('layouts/hero', [
    'title' => 'Salón de la fama',
    'uri' => $uri,
]) ?>

<div class="has-text-centered">
    <p class="title">Salón de la fama</p>
    <?php foreach ($hall as $item): ?>
        <div class="card">
            <div class="card-content">
                <div class="media">
                    <div class="media-content">
                        <p class="title is-4"><?= $this->e($item->teacher->nombre) ?></p>
                        <?php if (isset($item->teacher->departamentos[0])): ?>
                            <p class="subtitle is-6"><?= $this->e($item->teacher->departamentos[0][0]->nombre) ?></p>
                        <?php endif ?>
                    </div>
                </div>

                <div class="field is-grouped is-grouped-multiline is-grouped-centered">
                    <?php $this->insert('partials/stat', ['title' => 'Nº de valoraciones', 'value' => $item->total]) ?>
                    <?php $this->insert('partials/stat', ['title' => 'Nota media', 'value' => $item->avg, 'withColor' => true]) ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
