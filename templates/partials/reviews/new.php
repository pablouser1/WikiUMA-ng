<div class="buttons is-centered">
    <a href="<?= $this->url('/reviews', ['target' => $target, 'type' => $type->value]) ?>" class="button is-link">
        <span class="icon">
            <?= icon('fa7-solid:pencil') ?>
        </span>
        <span>Valorar <?= lcfirst($type->displayName()) ?></span>
    </a>
</div>
