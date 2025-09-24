<span class="tag is-rounded is-<?= $this->tag($tag->type) ?>">
    <label class="checkbox">
        <input name="tags[]" value="<?= $this->e($tag->id) ?>" type="checkbox" />
        <?php if ($tag->icon): ?>
            <span class="icon is-small">
                <?= $this->e($tag->icon)  ?>
            </span>
        <?php endif ?>
        <span><?= $this->e($tag->name) ?></span>
    </label>
</span>
