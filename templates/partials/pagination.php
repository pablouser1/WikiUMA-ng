<?php
$range = 1;
$page = isset($query['page']) ? intval($query['page']) : 1;

// Sliding window
$startPage = max(1, $page - $range);
$endPage = min($lastPage, $page + $range);
$back = $page - 1;
$next = $page + 1;
?>

<nav class="pagination" role="navigation" aria-label="pagination">
    <!-- Previous Button -->
    <?php if ($back > 0): ?>
        <a href="<?= $this->uriQuery($uri, $query, ['page' => $back]) ?>" class="pagination-previous">
            Página anterior
        </a>
    <?php else: ?>
        <a class="pagination-previous" disabled>Página anterior</a>
    <?php endif ?>

    <!-- Next Button -->
    <?php if ($hasNext): ?>
        <a href="<?= $this->uriQuery($uri, $query, ['page' => $next]) ?>" class="pagination-next">
            Siguiente página
        </a>
    <?php else: ?>
        <a class="pagination-next" disabled>Siguiente página</a>
    <?php endif ?>

    <ul class="pagination-list">
        <?php if ($startPage > 1): ?>
            <!-- Always Show First Page if not in range -->
            <li>
                <a href="<?= $this->uriQuery($uri, $query, ['page' => 1]) ?>" class="pagination-link" aria-label="Goto page 1">1</a>
            </li>
        <?php endif ?>

        <?php if ($startPage > 2): ?>
            <!-- Show Ellipsis if gap between 1 and startPage -->
            <li>
                <span class="pagination-ellipsis">&hellip;</span>
            </li>
        <?php endif ?>

        <!-- Range -->
        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
            <li>
                <a
                    href="<?= $this->uriQuery($uri, $query, ['page' => $i]) ?>"
                    class="pagination-link <?= $i === $page ? 'is-current' : ''; ?>"
                    aria-label="Goto page <?= $this->e($i) ?>"
                    aria-current="<?= $i === $page ? 'page' : 'step' ?>">
                    <?= $this->e($i) ?>
                </a>
            </li>
        <?php endfor ?>

        <?php if ($endPage < ($lastPage - 1)): ?>
            <!-- Show Ellipsis if gap between endPage and lastPage -->
            <li>
                <span class="pagination-ellipsis">&hellip;</span>
            </li>
        <?php endif ?>

        <?php if ($endPage < $lastPage): ?>
            <!-- Always Show Last Page if not in range -->
            <li>
                <a href="<?= $this->uriQuery($uri, $query, ['page' => $lastPage]) ?>" class="pagination-link" aria-label="Goto page <?= $this->e($lastPage) ?>">
                    <?= $this->e($lastPage) ?>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>
