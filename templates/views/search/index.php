<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 */
?>

<?php $this->layout('layouts/hero', [
    'title' => 'Valorar profesores',
    'uri' => $uri,
]) ?>

<div class="box has-text-centered">
    <p class="title">Buscador de profesores</p>
    <?php $this->insert('partials/search/duma') ?>
    <hr />
    <?php $this->insert('partials/search/email') ?>
</div>
