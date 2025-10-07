<?php $this->layout('layouts/default', ['title' => 'Acerca de']) ?>

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
        <p>WikiUMA recoge la siguiente información:</p>
        <ul>
            <li>Dirección IP <b>SÓLO</b> en los siguientes casos:</li>
            <ul>
                <li>Fallos constantes de captcha.</li>
                <li>Gran cantidad de solicitudes continuadas.</li>
                <li>En el resto de casos, tu dirección IP no se almacena.</li>
            </ul>
            <li>
                Al crear un informe, el correo electrónico dado es almacenado y
                usado exclusivamente para enviar actualizaciones de su estado.
            </li>
        </ul>

        <h4>¿Dónde están las valoraciones de la antigua versión de WikiUMA?</h4>
        <p>Actualmente esos datos no están importados en la versión actual.</p>
        <p>
            La estructura de estos datos son considerablemente distintos a la actual y
            la migración sería costosa, tanto en tiempo invertido como en recursos.
        </p>

        <h4>Las palabras más usadas en las valoraciones de un profesor / una asignatura no coincide con los datos reales</h4>
        <p>Estos datos no se actualizan en tiempo real, se calcula cada 7 días.</p>
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
