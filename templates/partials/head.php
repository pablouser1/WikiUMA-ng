<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="<?= $this->e($title) ?> - WikiUMA" />
    <meta property="og:url" content="<?= $uri ?>" />
    <meta property="og:type" content="website" />
    <link rel="stylesheet" href="<?= $this->url($this->asset('/css/vendor/bulma.min.css')) ?>">
    <?php if (isset($withReviews) && $withReviews): ?>
        <link rel="stylesheet" href="<?= $this->url($this->asset('/css/review.css')) ?>">
    <?php endif ?>
    <script defer src="<?= $this->url($this->asset('/js/navbar.js')) ?>"></script>
    <script defer src="<?= $this->url($this->asset('/js/theme.js')) ?>"></script>
    <?php if (isset($withSearch) && $withSearch): ?>
        <script defer src="<?= $this->url($this->asset('/js/search.js')) ?>"></script>
    <?php endif ?>
    <?php if (isset($withCaptcha) && $withCaptcha): ?>
        <script async defer src="https://www.hCaptcha.com/1/api.js"></script>
    <?php endif ?>
    <?php if (isset($withForm) && $withForm): ?>
        <script defer src="<?= $this->url($this->asset('/js/form.js')) ?>"></script>
    <?php endif ?>
    <title><?= $this->e($title) ?> - WikiUMA</title>
</head>
