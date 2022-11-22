<?php $this->layout('layouts/default', ['title' => 'Acerca de']) ?>

<?php $this->start('header') ?>
    <p class="title">¡Bienvenido a WikiUMA <small>ng</small>!</p>
<?php $this->stop() ?>

<div class="content">
    <p>Versión: <?=$this->version()?></p>
    <p>WikiUMA-ng pretende ser una versión mejorada de <a href="https://www.wikiuma.com" rel="nofollow">WikiUma</a></p>
    <p class="title">Programas de terceros</p>
    <p>Este proyecto no sería posible sin la ayuda de:</p>
    <ul>
    	<li><a rel="nofollow" href="https://github.com/thephpleague/plates">Plates</a></li>
    	<li><a rel="nofollow" href="https://github.com/bramus/router">bramus/router</a></li>
    	<li><a rel="nofollow" href="https://github.com/josegonzalez/php-dotenv">josegonzalez/dotenv</a></li>
    	<li><a rel="nofollow" href="https://github.com/jgthms/bulma">Bulma</a></li>
    </ul>
</div>
