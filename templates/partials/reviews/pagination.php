<?php
$page = $query['page'] ?? 1;
$back = $page - 1;
$next = $page + 1;
?>

<nav class="pagination" role="navigation" aria-label="pagination">
    <?php if ($back > 0): ?>
        <a href="<?= $this->uriQuery($uri, $query, ['page' => $back]) ?>" class="pagination-previous">Página anterior</a>
    <?php endif ?>
    <?php if ($hasNext): ?>
        <a href="<?= $this->uriQuery($uri, $query, ['page' => $next]) ?>" class="pagination-next">Siguiente página</a>
    <?php endif ?>
</nav>
