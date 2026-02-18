<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 */
?>

<?php $this->layout('layouts/default', [
    'title' => 'Contacto',
    'uri' => $uri,
]) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Contacto',
])
?>

<section class="section">
    <div class="content">
        <p>¿Tienes alguna sugerencia, duda o has encontrado algún problema?</p>
        <p>Puedes ponerte en contacto con la administración directamente enviando un correo electrónico a <?= $this->contact() ?></p>
    </div>
</section>
