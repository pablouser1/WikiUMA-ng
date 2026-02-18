<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 * @var array $query
 * @var \Illuminate\Support\Collection<\App\Models\Report> $reports
 */
?>

<?php $this->layout('layouts/default', [
    'title' => 'Informes',
    'uri' => $uri,
    'withReviews' => true,
    'withForm' => true,
]) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Informes',
])
?>

<section class="section">
    <div class="container">
        <?php $this->insert('partials/reports/index', [
            'reports' => $reports,
            'uri' => $uri,
            'query' => $query,
        ]) ?>
    </div>
</section>
