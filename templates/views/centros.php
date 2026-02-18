<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var \UMA\Models\Centro[] $centros
 */
?>

<?php $this->layout('layouts/default', [
    'title' => 'Centros',
    'uri' => $uri,
    'withSearch' => true,
]) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Centros',
]) ?>

<section class="section">
    <?php $this->insert('partials/search-client') ?>
    <div class="columns is-centered is-vcentered is-multiline">
        <?php foreach ($centros as $centro): ?>
            <?php if ($centro->alfilws !== ""): ?>
                <div class="column item is-narrow" data-name="<?= $this->e($centro->nombre) ?>">
                    <?php $this->insert('partials/card', [
                        'name' => $centro->nombre,
                        'url' => $this->url("/centros/{$centro->alfilws}/titulaciones"),
                    ]) ?>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>
</section>
