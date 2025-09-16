<?php $this->layout('layouts/hero', ['title' => 'Inicio', 'withNavbar' => true,]) ?>

<?php if (isset($reaction) && !empty($reaction)): ?>
    <figure class="image is-inline-block is-1by1 mb-2" style="width: 216px; height: 216px;">
        <img src="<?= $this->url('/img/' . $reaction->name) ?>" />
    </figure>
<?php endif ?>

<p class="title"><?= $this->e($title) ?></p>

<?php if (isset($body)): ?>
    <p class="mb-4"><?= $this->e($body) ?></p>
<?php endif ?>

<button type="button" class="button is-link" onclick="history.back();">Atrás</a>
