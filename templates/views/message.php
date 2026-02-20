<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var string $title
 * @var string $body
 * @var ?string $back
 * @var ?object{"name": string, "alt": string} $reaction
 * @todo Consider refactoring to avoid JS
 */
?>

<?php $this->layout('layouts/hero', [
    'title' => $title,
    'uri' => $uri,
]) ?>

<div class="box has-text-centered">
    <?php if (isset($reaction) && !empty($reaction)): ?>
        <figure class="image is-inline-block is-1by1 mb-2" style="width: 216px; height: 216px;">
            <img src="<?= $this->url("/img/{$reaction->name}") ?>" />
        </figure>
    <?php endif ?>

    <p class="title"><?= $this->e($title) ?></p>

    <?php if (isset($body)): ?>
        <p class="mb-4"><?= $this->e($body) ?></p>
    <?php endif ?>

    <?php if (isset($back)): ?>
        <a href="<?= $back ?>" class="button">Atrás</a>
    <?php else: ?>
        <button type="button" class="button is-link" onclick="history.back();">Atrás</a>
    <?php endif ?>
</div>
