<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <?php if(isset($withReviews) && $withReviews): ?>
    <link rel="stylesheet" href="<?=$this->url('/css/review.css')?>">
    <?php endif ?>
    <?php if(isset($withNavbar) && $withNavbar): ?>
    <script defer src="<?=$this->url('/js/navbar.js')?>"></script>
    <?php endif ?>
    <?php if(isset($withSearch) && $withSearch): ?>
    <script defer src="<?=$this->url('/js/search.js')?>"></script>
    <?php endif ?>
    <?php if(isset($withCaptcha) && $withCaptcha): ?>
    <script async defer src="https://cdn.jsdelivr.net/gh/altcha-org/altcha/dist/altcha.min.js" type="module"></script>
    <?php endif ?>
    <title><?=$this->e($title)?> - WikiUMA(ng)</title>
</head>
