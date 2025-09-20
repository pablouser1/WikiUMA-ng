<nav class="level">
    <!-- Left side -->
    <div class="level-left">
        <p>Filtros</p>
    </div>
    <!-- Right side -->
    <div class="level-right">
        <p class="level-item"><a href="<?= $this->uriQuery($uri, $query, ['filter' => 'all'])?>">Todos</a></p>
        <p class="level-item"><a href="<?= $this->uriQuery($uri, $query, ['filter' => 'pending'])?>">Pendientes</a></p>
        <p class="level-item"><a href="<?= $this->uriQuery($uri, $query, ['filter' => 'accepted'])?>">Aceptados</a></p>
        <p class="level-item"><a href="<?= $this->uriQuery($uri, $query, ['filter' => 'denied'])?>">Denegados</a></p>
    </div>
</nav>
