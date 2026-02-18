<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 */
?>

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
        <p>Actualmente esos datos están parcialmente importados.</p>
        <p>Las valoraciones vinculadas a profesores que siguen impartiendo clases están disponibles.</p>
        <p>Las valoraciones a asignaturas no están implementadas.</p>
    </div>
    <div class="content">
        <h1>Créditos</h1>
        <p>Este proyecto no sería posible sin la ayuda de:</p>
        <ul>
            <li>
                <a rel="nofollow" href="https://github.com/chillerlan/php-cache">chillerlan/php-cache</a>
            </li>
            <li>
                <a rel="nofollow" href="https://github.com/thephpleague/plates">Plates</a>
            </li>
            <li>
                <a rel="nofollow" href="https://github.com/jgthms/bulma">Bulma</a>
            </li>
            <li>
                <a rel="nofollow" href="https://github.com/yassinedoghri/php-icons">yassinedoghri/php-icons</a>
            </li>
            <li>
                <a rel="nofollow" href="https://fontawesome.com">FontAwesome</a>
            </li>
        </ul>
    </div>
</section>
