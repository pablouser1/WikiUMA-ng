<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var Bbsnly\ChartJs\Chart $distribution
 * @var \App\Models\Review|null $popular
 * @var \App\Models\Review|null $unpopular
 */
?>

<?php $this->layout('layouts/default', [
    'title' => 'Estadísticas',
    'uri' => $uri,
    'withReviews' => true,
    'withCharts' => true,
]) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Estadísticas',
]) ?>

<section class="section">
    <div class="columns is-centered is-multiline">
        <div class="column is-half">
            <p class="is-size-4 has-text-centered">
                <b>Distribución de notas</b>
            </p>
            <?= $distribution->toHtml('distribution') ?>
        </div>
    </div>
    <div class="columns is-centered is-multiline">
        <?php if ($popular !== null && $popular->votes > 0): ?>
            <div class="column is-half">
                <p class="is-size-4 has-text-centered">
                    <b>Valoración más popular</b>
                </p>
                <?php $this->insert('partials/reviews/single', [
                    'review' => $popular,
                    'isAdmin' => $this->loggedin(),
                    'uri' => $uri,
                ]) ?>
            </div>
        <?php endif ?>
        <?php if ($unpopular !== null && $popular->votes < 0): ?>
            <div class="column is-half">
                <p class="is-size-4 has-text-centered">
                    <b>Valoración más polémica</b>
                </p>
                <?php $this->insert('partials/reviews/single', [
                    'review' => $unpopular,
                    'isAdmin' => $this->loggedin(),
                    'uri' => $uri,
                ]) ?>
            </div>
        <?php endif ?>
    </div>
</section>
