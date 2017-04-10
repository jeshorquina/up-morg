<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
        <?= $page["title"] ?>
    </title>
    <link rel="stylesheet" href="<?= $page['urls']['stylesheet'] ?>">
</head>

<body data-source="<?= $page['urls']['base'] ?>"
    <?php if(isset($csrf)){ ?>
    data-csrf-name="<?= $csrf['name'] ?>"
    data-csrf-hash="<?= $csrf['hash'] ?>"
    <?php } ?> 
>

    <div id="notifications" class="sticky"></div>