<?php $this->layout('layouts/default', ['title' => 'Spam en correo']) ?>

<?php $this->start('header') ?>
<p class="title">Quitar Spam del correo</p>
<?php $this->stop() ?>

<div class="container">
  <article class="message is-primary">
    <div class="message-header">
      <p>Contexto</p>
    </div>
    <div class="message-body">
      Probablemente hayas recibido (muy a menudo) en tu correo una gran cantidad de mensajes con un asunto empezando por
      <strong>[ldestudiantes]</strong>.<br>
      Esta es la lista de difusión usada por la Universidad de Málaga para enviar correos
      a todo el alumnado, administrada usando "sympa", un programa de código abierto para gestionar este tipo de correos.<br>
      Actualmente no es posible "desuscribirse" de esta lista. Aunque, sí puedes pedirle al programa que no te mande correos
      y seguir estando suscrito, lo que se acerca mucho a nuestro objetivo.
    </div>
  </article>
  <div class="content">
    <p>¡Al lío!</p>
    <p>Pasos a seguir para no recibir estos correos:</p>
    <ol>
      <li>
        Accede a <a href="https://sympa.sci.uma.es/sympa/suboptions/ldestudiantes" rel="nofollow" target="_blank">https://sympa.sci.uma.es/sympa/suboptions/ldestudiantes</a>
      </li>
      <li>
        Verás un mensaje que pone "Autorización rechazada. ¿Puede ser que te hayas olvidado de acceder?". Ciérrala y haz click
        en el botón que pone "Pulsar para acceder por iDUMA"
      </li>
      <li>
        Inicia sesión con tus credenciales de la UMA
      </li>
      <li>
        Una vez iniciada sesión deberías poder ver una página con la configuración de tu suscripción
      </li>
      <li>
        Busca la opción "Modo de recepción" y elige la opción "sin correo"
      </li>
      <li>
        Haz click en el botón que pone "Actualizar"
      </li>
    </ol>
    <p>¡Listo!</p>
    <p>
        PD: Si por algún motivo necesitas consultar alguno de estos correos puedes ver
        <a href="https://sympa.sci.uma.es/sympa/arc/ldestudiantes" rel="nofollow" target="_blank">aquí</a>
        todos los correos enviados por este medio
    </p>
  </div>
</div>
