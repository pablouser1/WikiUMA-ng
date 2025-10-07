<nav class="panel is-primary">
    <p class="panel-heading"><?= $this->e($title) ?></p>
    <div class="panel-content-scroll">
        <?php foreach ($items as $item): ?>
            <a
                class="panel-block item"
                href="<?= $this->e($item->url) ?>"
                data-name="<?= $this->e($item->name) ?>">
                <?= $this->e($item->name) ?>
            </a>
        <?php endforeach ?>
    </div>
</nav>
