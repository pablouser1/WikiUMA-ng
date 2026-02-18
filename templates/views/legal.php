<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Psr\Http\Message\UriInterface $uri
 */
?>

<?php $this->layout('layouts/default', [
    'title' => 'Legal',
    'uri' => $uri,
]) ?>

<?php $this->insert('partials/hero', [
    'title' => 'Legal',
])
?>

<section class="section">
    <div class="content">
        <h1>Términos de uso</h1>
        <ul>
            <li>
                Esta página web <strong>NO ESTÁ AFILIADA</strong> a la Universidad de Málaga.
            </li>
            <li>
                La administración de este servicio no verifica ni avala las publicaciones escritas por los usuarios.
            </li>
            <li>
                Cualquier publicación no apropiada (amenazas, publicación de información privada...) no está permitida y
                puede ser eliminada por la administración.
            </li>
            <li>
                Las publicaciones pueden ser manualmente denunciadas por el usuario:
                <ul>
                    <li>Esta denuncia se puede realizar haciendo click a la bandera encontrada arriba a la derecha de la valoración.</li>
                    <li>
                        Una vez realizada la denuncia, la administración decidirá si eliminar o no la valoración
                        teniendo en consideración los argumentos expuestos por el denunciante.
                    </li>
                    <li>
                        El denunciante puede comprobar el estado de su denuncia
                        en todo momento con el ID dado al finalizar el proceso.
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="content">
        <h1>Privacidad</h1>
        <h2>Información recopilada</h2>
        <ul>
            <li>Dirección IP, con un tiempo máximo de almacenamiento de dos semanas, <b>SÓLO</b> en los siguientes casos:</li>
            <ul>
                <li>Fallos repetidos a la hora de resolver captchas.</li>
                <li>Gran cantidad de solicitudes continuadas.</li>
            </ul>
        </ul>
        <h2>Uso de cookies</h2>
        <p>
            WikiUMA utiliza cookies, estas cookies se utilizan exclusivamente para el
            correcto funcionamiento de la aplicación y NUNCA para analíticas o rastreo.
        </p>
    </div>
    <div class="content">
        <p><strong>Al usar el servicio confirmas haber leído y aceptado los términos de uso.</strong></p>
    </div>
</section>
