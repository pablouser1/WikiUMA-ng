<?php $this->layout('layouts/hero', ['title' => 'Inicio']) ?>

<div class="box">
    <p class="title"><?=$this->e($title)?></p>
    <?php if (isset($body)): ?>
        <p><?=$this->e($body)?></p>
    <?php endif ?>
</div>
