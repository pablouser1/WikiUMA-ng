<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 */
?>

<?php $this->layout('layouts/hero', [
    'title' => 'Consejos',
    'uri' => $uri,
]) ?>

<div class="box has-text-centered">
    <p class="title">Consejos</p>
    <div class="buttons is-centered is-responsive">
        <a class="button is-primary" href="<?= $this->url('/tips/email') ?>">
            <span class="icon">
                <?= icon('fa7-solid:envelope') ?>
            </span>
            <span>Dejar de recibir correos de ldestudiantes</span>
        </a>
    </div>
</div>
