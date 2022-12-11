<div class="buttons" role="navigation" aria-label="pagination">
    <?php if ($this->page() > 1): ?>
    	<a class="button is-danger" href="?<?= http_build_query(array_merge($_GET, ['page' => $this->page() - 1])) ?>">Atrás</a>
    <?php endif ?>
    <a class="button is-success" href="?<?= http_build_query(array_merge($_GET, ['page' => $this->page() + 1])) ?>" <?= $count === 0 ? "disabled" : '' ?>>Siguiente página</a>
</div>
