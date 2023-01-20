<?php $this->layout('layouts/hero', ['title' => $title]) ?>

<div class="content">
    <p class="title"><?= $this->e($title) ?></p>
	<p class="subtitle">HTTP <?=$this->e($code) ?> (<?= $this->code($code) ?>)</p>
    <?php if (isset($body) && !empty($body)): ?>
        <p><?= $this->e($body) ?></p>
    <?php endif ?>
</div>
