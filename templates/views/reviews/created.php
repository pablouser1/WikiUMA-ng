<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var \App\Models\Review $review
 * @var string $back
 */
?>

<?php $this->layout('layouts/hero', [
    'title' => 'Valoración creada',
    'uri' => $uri,
]) ?>

<div class="box has-text-centered">
    <p class="title">Tu valoración ha sido registrada.</p>
    <p>
        Gracias por contribuir a WikiUMA, <b><?= $this->e($review->username) ?></b>
        <span style="color: #e25555;">&#9829;</span>
    </p>
    <hr />
    <a href="<?= $back ?>" class="button is-link">
        <span class="icon">
            <?= icon('fa7-solid:arrow-left') ?>
        </span>
        <span>Volver a página de <?= $this->e($review->type->displayName()) ?></span>
    </a>
</div>
