<div class="card">
    <div class="card-content">
        <p class="title is-4">Informe <?= $this->e($report->uuid) ?></p>
        <p class="subtitle is-6">
            <a href="<?= $this->url('/redirect', ['target' => $report->review->target, 'type' => $report->review->type]) ?>" target="_blank">Consultar reseñado</a>
        </p>

        <?php $this->insert('partials/reviews/single', ['review' => $report->review]) ?>

        <p class="title is-4">Informe</p>
        <div class="content">
            <?= $report->message ?>
        </div>
        <hr />
        <form action="<?= $this->url('/staff/reports/' . $report->id . '/status') ?>" method="POST">
            <div class="field">
                <label class="label">Estado</label>
                <div class="control">
                    <div class="select">
                        <select name="status" required>
                            <?php foreach (\App\Enums\ReportStatusEnum::cases() as $status): ?>
                                <option <?= $report->status === $status ? 'selected' : '' ?> value="<?= $this->e($status->value)?>"><?= $this->e($status->displayName()) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Razón (opcional)</label>
                <div class="control">
                    <input class="input" type="text" name="reason">
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button class="button is-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
