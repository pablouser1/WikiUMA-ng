<div class="buttons is-centered">
    <a href="<?= $this->url('/stats', ['target' => $target, 'type' => $type->value]) ?>" class="button is-primary">
        <span class="icon">
            <?= icon('fa7-solid:chart-line') ?>
        </span>
        <span>Ver estadísticas completas</span>
    </a>
    <?php if (!$isReadOnly): ?>
        <a href="<?= $this->url('/reviews', ['target' => $target, 'type' => $type->value]) ?>" class="button is-link">
            <span class="icon">
                <?= icon('fa7-solid:pencil') ?>
            </span>
            <span>Valorar <?= lcfirst($type->displayName()) ?></span>
        </a>
    <?php endif ?>
</div>
