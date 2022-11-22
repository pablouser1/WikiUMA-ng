<?php $this->layout('layouts/hero', ['title' => 'Inicio']) ?>

<div class="content">
    <p class="title">WikiUMA <small>ng</small></p>
    <p class="subtitle">Califica a tus profesores de forma anónima</p>
    <div class="buttons is-centered is-responsive">
        <?php foreach($this->links() as $link): ?>
        <a class="button <?=$this->e($link['color'])?>" href="<?=$this->url($link['endpoint'])?>"><?=$this->e($link['name'])?></a>
        <?php endforeach ?>
    </div>
</div>
