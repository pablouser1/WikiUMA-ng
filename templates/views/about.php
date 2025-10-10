<?php $this->layout('layouts/default', [
    'title' => 'Acerca de',
    'uri' => $uri,
]) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Acerca de WikiUMA',
])
?>

<section class="section">
    <div class="content">
        <p>WikiUMA <small>ng</small> aspira a continuar el funcionamiento de su antecesor con varias mejoras.
    </div>
    <div class="content">
        <h1>Preguntas frecuentes / Soporte</h1>

        <h4>¿Qué datos se recopilan acerca de mi?</h4>
        <p>Consulta <a href="<?= $this->url('/legal') ?>">aquí</a> para información al respecto.</p>

        <h4>¿Dónde están las valoraciones de la antigua versión de WikiUMA?</h4>
        <p>Actualmente esos datos no están importados en la versión actual.</p>
        <p>
            La estructura de estos datos son considerablemente distintos a la actual y
            la migración sería costosa, tanto en tiempo invertido como en recursos.
        </p>
    </div>
    <div class="content">
        <h1>Contacto</h1>
        <p>Puedes ponerte en contacto con la administración directamente enviando un correo electrónico a wikiuma (at) pabloferreiro (dot) es</p>
    </div>
    <div class="content">
        <h1>Cŕeditos</h1>
        <p>Este proyecto no sería posible sin la ayuda de:</p>
        <ul>
            <li>
                <a rel="nofollow" href="https://github.com/thephpleague/plates">Plates</a>
            </li>
            <li>
                <a rel="nofollow" href="https://github.com/jgthms/bulma">Bulma</a>
            </li>
            <li>
                <a rel="nofollow" href="https://github.com/developerdino/ProfanityFilter">developerdino/ProfanityFilter</a>
                (con algunas modificaciones)
            </li>
            <li>
                <a rel="nofollow" href="https://iconoir.com">Iconoir</a>
            </li>
        </ul>
    </div>
</section>
