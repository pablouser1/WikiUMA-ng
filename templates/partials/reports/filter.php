<nav class="level">
    <!-- Left side -->
    <div class="level-left">
        <p>Filtros</p>
    </div>
    <!-- Right side -->
    <div class="level-right">
        <?php foreach (\App\Enums\ReportFilterEnum::cases() as $filter): ?>
            <p class="level-item">
                <a href="<?= $this->uriQuery($uri, $query, ['filter' => $filter->value])?>"><?= $this->e($filter->displayName()) ?></a>
            </p>
        <?php endforeach ?>
    </div>
</nav>
