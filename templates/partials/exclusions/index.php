<div class="block">
    <?php if ($exclusions->isEmpty()): ?>
        <?php $this->insert('partials/exclusions/empty') ?>
    <?php else: ?>
        <div class="content">
            <ul>
                <?php foreach ($exclusions as $exclusion): ?>
                    <li><?= $this->e($exclusion->idnc) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>
    <?php $this->insert('partials/pagination', [
        'uri' => $uri,
        'query' => $query,
        'lastPage' => $exclusions->lastPage(),
        'hasNext' => $exclusions->hasMorePages(),
    ]) ?>
    <?php $this->insert('partials/exclusions/new') ?>
</div>
