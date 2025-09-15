<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a href="<?=$this->url('/')?>" class="navbar-item">
        WikiUMA-ng
    </a>

    <a role="button" id="navbar-burger" class="navbar-burger" aria-label="menu" aria-expanded="false">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbar-menu" class="navbar-menu">
    <div class="navbar-start">
      <?php foreach($this->links() as $link): ?>
      <a class="navbar-item" href="<?=$this->url($link['path'])?>">
           <?=$this->e($link['name'])?>
      </a>
      <?php endforeach ?>
    </div>
  </div>
</nav>
