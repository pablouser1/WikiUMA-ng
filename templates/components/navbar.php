<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a href="<?=$this->url('/')?>" class="navbar-item">WikiUMA-ng</a>

    <a role="button" id="navbar-burger" class="navbar-burger" aria-label="menu" aria-expanded="false">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbar-menu" class="navbar-menu">
    <div class="navbar-start">
      <?php foreach($this->links() as $link): ?>
      <a class="navbar-item" href="<?=$this->url($link['endpoint'])?>"><?=$this->e($link['name'])?></a>
      <?php endforeach ?>
    </div>
    <div class="navbar-end">
      <?php if ($this->isAdmin()): ?>
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link"><?=$this->e($_SESSION['username'])?></a>
        <div class="navbar-dropdown">
          <a class="navbar-item" href="<?=$this->url('/admin')?>">Panel de Control</a>
          <a class="navbar-item" href="<?=$this->url('/admin/logout')?>">Cerrar sesión</a>
        </div>
      </div>
      <?php else: ?>
      <a href="/admin/login" class="navbar-item">Restringido</a>
      <?php endif ?>
      <a href="https://github.com/pablouser1/WikiUma-ng" class="navbar-item">Código Fuente</a>
    </div>
  </div>
</nav>

<script defer src="<?=$this->url('/js/navbar.js')?>"></script>
