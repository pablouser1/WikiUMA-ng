<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $this->url('/css/vendor/bulma.min.css') ?>">
    <meta property="og:title" content="<?= $this->e($title) ?> - WikiUMA" />
    <meta property="og:url" content="<?= $uri ?>" />
    <meta property="og:type" content="website" />
    <?php if (isset($withReviews) && $withReviews): ?>
        <link rel="stylesheet" href="<?= $this->url('/css/review.css') ?>">
    <?php endif ?>
    <script defer src="<?= $this->url('/js/navbar.js') ?>"></script>
    <script defer src="<?= $this->url('/js/theme.js') ?>"></script>
    <?php if (isset($withSearch) && $withSearch): ?>
        <script defer src="<?= $this->url('/js/search.js') ?>"></script>
    <?php endif ?>
    <?php if (isset($withCaptcha) && $withCaptcha): ?>
        <script async defer src="https://www.hCaptcha.com/1/api.js"></script>
    <?php endif ?>
    <?php if (isset($withMaxChars) && $withMaxChars): ?>
        <script defer src="<?= $this->url('/js/maxchars.js') ?>"></script>
    <?php endif ?>
    <title><?= $this->e($title) ?> - WikiUMA</title>
</head>
