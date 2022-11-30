<?php $this->layout('layouts/hero', ['title' => 'Inicio']) ?>

<div class="content">
    <p class="title">¡Bienvenido a WikiUMA <small>ng</small>!</p>
    <p class="subtitle">Califica a tus profesores de la UMA de forma anónima</p>
    <p>Total de reseñas: <?= $stats->total ?> | Nota media: <?= $stats->med ?></p>
    <div class="buttons is-centered is-responsive">
        <?php foreach($this->links() as $link): ?>
        <a class="button <?=$this->e($link['color'])?>" href="<?=$this->url($link['endpoint'])?>"><?=$this->e($link['name'])?></a>
        <?php endforeach ?>
    </div>
    <?= $this->insert('components/search_server') ?>
</div>
