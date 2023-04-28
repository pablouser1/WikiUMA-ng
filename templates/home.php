<?php $this->layout('layouts/hero', ['title' => 'Inicio']) ?>

<div class="columns is-centered">
    <div class="column is-half">
        <div class="box">
            <p class="title">¡Bienvenido a WikiUMA <small title="nueva generación">ng</small>!</p>
            <p class="subtitle">Califica a tus profesores de forma anónima y más</p>
            <div class="buttons is-centered is-responsive">
                <?php foreach ($this->links() as $link) : ?>
                    <a class="button <?= $this->e($link['color']) ?>" href="<?= $this->url($link['endpoint']) ?>">
                        <?= $this->insert('components/icon/main', ['icon' => $this->e($link['icon']), 'text' => $this->e($link['name'])]) ?>
                    </a>
                <?php endforeach ?>
            </div>
            <?= $this->insert('components/search_server') ?>
        </div>
    </div>
</div>
<?= $this->insert('components/stats', ['stats' => $stats]) ?>
