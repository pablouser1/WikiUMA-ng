Hola,

Su queja con el ID <?= $this->e($report->uuid) ?> a la valoración del usuario "<?= $this->e($report->review->username ?? 'Anónimo') ?>" ha sido evaluada por la administración.
Después de una revisión, hemos decidido <?= $this->e($report->status->actionTaken()) ?>.

Motivo: <?= $report->reason === null ? 'Sin Especificar' : $this->e($report->reason) ?>.

Si tiene alguna pregunta o desea discutir esta decisión, no dude en responder a este correo.

Agradecemos sinceramente su contribución para hacer de WikiUMA un espacio más cívico y respetuoso, donde cada voz cuenta y se valora.

Un saludo,
Administración de WikiUMA.
