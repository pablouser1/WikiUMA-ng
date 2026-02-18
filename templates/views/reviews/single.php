<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var \App\Models\Review $review
 */
?>

<?php $this->layout('layouts/hero', [
    'title' => "Valoración de {$review->username}",
    'uri' => $uri,
    'withReviews' => true,
    'withForm' => $this->loggedin(),
]) ?>

<div class="box">
    <?php $this->insert('partials/reviews/single', [
        'review' => $review,
        'linkToOriginal' => true,
        'uri' => $uri,
    ]) ?>

    <?php if ($this->loggedin()): ?>
        <form id="data-form" action="<?= $this->url('/staff/reviews/' . $review->id . '/delete') ?>" method="POST">
            <div class="field">
                <label class="label">Razón (opcional)</label>
                <div class="control">
                    <input class="input" type="text" name="reason" maxlength="<?= $this->e(\App\Models\Report::REASON_MAX_LENGTH) ?>">
                </div>
            </div>
            <div class="field">
                <label class="checkbox">
                    <input name="force" type="checkbox" />
                    Eliminar completamente
                </label>
            </div>
            <div class="field">
                <div class="control">
                    <button id="data-submit" class="button is-primary" type="submit">Enviar</button>
                </div>
            </div>
        </form>
    <?php endif ?>
</div>
