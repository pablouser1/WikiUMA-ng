<?php $this->layout('layouts/default', [
    'title' => 'Informes',
    'uri' => $uri,
    'withReviews' => true,
    'withMaxChars' => true,
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
