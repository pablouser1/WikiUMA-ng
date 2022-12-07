<form method="GET" action="<?= $this->e($this->current_url()) ?>">
    <div class="field has-addons has-addons-centered">
    	<div class="control">
            <div class="select">
                <select name="sort">
                    <option value="created_at" <?= $this->selected('created_at', 'sort') ?>>Fecha de publicación</option>
                    <option value="votes" <?= $this->selected('votes', 'sort') ?>>Votos</option>
                </select>
            </div>
    	</div>
    	<div class="control">
            <div class="select">
                <select name="order">
                    <option value="asc" <?= $this->selected('asc', 'order') ?>>Ascendiente</option>
                    <option value="desc" <?= $this->selected('desc', 'order') ?>>Descendiente</option>
                </select>
            </div>
    	</div>
        <div class="control">
            <button class="button is-info" type="submit">Ordenar</button>
        </div>
    </div>
    <?php if (isset($params)): ?>
        <?php foreach ($params as $key => $value): ?>
            <input type="hidden" name="<?= $this->e($key) ?>" value="<?= $this->e($value) ?>" ?>
        <?php endforeach ?>
    <?php endif ?>
</form>
