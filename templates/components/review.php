<article class="media">
  <figure class="media-left">
    <div class="note has-background-<?=$this->color($note)?>">
      <p><?=$this->e($note)?></p>
    </div>
  </figure>
  <div class="media-content">
    <div class="content">
      <p>
        <strong><?=$this->e($username)?></strong>
        <br>
        <?=$this->e($message)?>
      </p>
    </div>
    <nav class="level is-mobile">
      <div class="level-left">
        <p class="level-item">
            <span class="icon" style="color: #e25555;">&#9829;</span>
            <span><?=$this->e($votes)?></span>
        </p>
      </div>
      <?php if (isset($controls)): ?>
      <div class="level-right">
        <a href="<?=$this->url('/reports/new/' . $id)?>" class="level-item is-size-7 has-text-danger">Reportar</a>
      </div>
      <?php endif ?>
    </nav>
  </div>
</article>
