<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var \UMA\Models\Titulacion[] $titulaciones
 */
?>

<?php $this->layout('layouts/default', [
    'title' => 'Titulaciones',
    'uri' => $uri,
    'withSearch' => true,
]) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Titulaciones',
    'subtitle' => $titulaciones[0]->centro,
]) ?>

<section class="section">
    <?php $this->insert('partials/search-client') ?>
    <div class="columns is-centered is-vcentered is-multiline">
        <?php foreach ($titulaciones as $titulacion): ?>
            <div class="column item is-narrow" data-name="<?= $this->e($titulacion->plan) ?>">
                <?php $this->insert('partials/card', [
                    'name' => $titulacion->plan,
                    'url' => $this->url('/planes/' . $titulacion->codigoPlan)
                ]) ?>
            </div>
        <?php endforeach ?>
    </div>
</section>
