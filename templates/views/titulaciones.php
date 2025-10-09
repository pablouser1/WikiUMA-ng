<?php $this->layout('layouts/default', [
    'title' => 'Titulaciones',
    'uri' => $uri,
    'withSearch' => true,
]) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Titulaciones',
    'subtitle' => $titulaciones[0]->CENTRO,
]) ?>

<section class="section">
    <?php $this->insert('partials/search-client') ?>
    <div class="columns is-centered is-vcentered is-multiline">
        <?php foreach ($titulaciones as $titulacion): ?>
            <div class="column item is-narrow" data-name="<?= $this->e($titulacion->PLAN) ?>">
                <?php $this->insert('partials/card', [
                    'name' => $titulacion->PLAN,
                    'url' => $this->url('/planes/' . $titulacion->COD_PLAN)
                ]) ?>
            </div>
        <?php endforeach ?>
    </div>
</section>
