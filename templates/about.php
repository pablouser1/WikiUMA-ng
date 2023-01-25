<?php $this->layout('layouts/default', ['title' => 'Acerca de']) ?>

<?php $this->start('header') ?>
<p class="title">Acerca de WikiUMA <small>ng</small></p>
<p class="subtitle">Versión: <?= $this->version() ?></p>
<?php $this->stop() ?>

<div class="content">
    <p>WikiUMA <small>ng</small> aspira a ser una versión mejorada de <a href="https://www.wikiuma.com" rel="nofollow">WikiUMA <small>✞</small></a></p>
</div>
<div class="content">
    <p class="title">Créditos</p>
    <p>Este proyecto no sería posible sin la ayuda de:</p>
    <ul>
        <li><a rel="nofollow" href="https://github.com/thephpleague/plates">Plates</a></li>
        <li><a rel="nofollow" href="https://github.com/gregwar/captcha">gregwar/captcha</a></li>
        <li><a rel="nofollow" href="https://github.com/bramus/router">bramus/router</a></li>
        <li><a rel="nofollow" href="https://github.com/josegonzalez/php-dotenv">josegonzalez/dotenv</a></li>
        <li><a rel="nofollow" href="https://github.com/jgthms/bulma">Bulma</a> y <a rel="nofollow" href="https://github.com/jenil/bulmaswatch">Bulmaswatch</a></li>
        <li><a rel="nofollow" href="https://github.com/developerdino/ProfanityFilter">developerdino/ProfanityFilter</a> (con algunas modificaciones)</li>
    </ul>
</div>
