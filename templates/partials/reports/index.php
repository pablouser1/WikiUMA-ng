<div class="block">
    <?php $this->insert('partials/reports/filter', ['uri' => $uri, 'query' => $query]) ?>
    <?php if ($reports->isEmpty()): ?>
        <?php $this->insert('partials/reports/empty') ?>
    <?php else: ?>
        <div class="box">
            <?php foreach ($reports as $report): ?>
                <?php $this->insert('partials/reports/single', [
                    'report' => $report,
                ]) ?>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>
