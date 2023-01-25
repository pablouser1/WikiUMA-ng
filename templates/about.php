<?php $this->layout('layouts/default', ['title' => 'Acerca de']) ?>

<?php $this->start('header') ?>
<p class="title">¡Bienvenido a WikiUMA <small>ng</small>!</p>
<p class="subtitle">Versión: <?= $this->version() ?></p>
<?php $this->stop() ?>

<div class="content">
    <p>WikiUMA <small>ng</small> aspira a ser una versión mejorada de <a href="https://www.wikiuma.com" rel="nofollow">WikiUMA <small>✞</small></a></p>
</div>
<div class="content">
    <p class="title">Donaciones</p>
    <p>Mantener este proyecto vivo requiere tanto de dinero como de tiempo. Donar podría ayudarme a mantener este servicio para todos.</p>
    <p>Cualquier donación será bienvenida, puedes donar usando:</p>
    <div class="buttons">
        <a class="button is-info" href="https://paypal.me/pablouser1" target="_blank">PayPal</a>
        <a class="button is-warning" href="https://liberapay.com/pablouser1" target="_blank">Liberapay</a>
    </div>
    <p>¡Gracias por el apoyo! <span style="color: #e25555;">&#9829;</span></p>
    <p>- Pablo Ferreiro, desarrollador de WikiUMA <small>ng</small></p>
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
