<div class="block">
    <?php $this->insert('partials/reports/filter', [
        'uri' => $uri,
        'query' => $query,
    ]) ?>
    <?php if ($reports->isEmpty()): ?>
        <?php $this->insert('partials/reports/empty') ?>
    <?php else: ?>
        <?php foreach ($reports as $report): ?>
            <div class="mb-4">
                <?php $this->insert('partials/reports/single', [
                    'report' => $report,
                    'uri' => $uri,
                ]) ?>
            </div>
        <?php endforeach ?>
    <?php endif ?>
    <?php $this->insert('partials/pagination', [
        'uri' => $uri,
        'query' => $query,
        'lastPage' => $reports->lastPage(),
        'hasNext' => $reports->hasMorePages(),
    ]) ?>
</div>
