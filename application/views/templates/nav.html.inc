<?php if(array_key_exists("nav", $page)) { ?>
<div class="nav sticky">
    <div class="nav-content">
        <div class="left-content">
            <h1 class="item">
                <a href="<?= $page['urls']['index'] ?>" class="<?php if(strpos(uri_string(),'events') !== false) { ?>active<?php } ?>"><strong>UP MOrg</strong></a>
            </h1>
        </div>
        <div class="right-content align-right">
            <?php foreach($page['nav'] as $nav_item) { ?>
            <a class="item <?= ($nav_item['name'] == 'Logout') ? 'button' : ''; ?> <?php if(strpos(base_url(uri_string()),  $nav_item['url']) !== false) { ?>active<?php } ?>"
                href="<?= $nav_item['url'] ?>"><!--
                --><?= $nav_item['name'] ?><!--
            --></a>
            <?php } ?>
        </div>
    </div>
    <?php if(array_key_exists("nav_secondary", $page)) { ?>
    <div class="nav-secondary">
        <div class="nav-content">
            <?php foreach($page['nav_secondary'] as $nav_item) { ?>
            <a class="item <?php if(strpos(base_url(uri_string()),  $nav_item['url']) !== false) { ?>active<?php } ?>" href="<?= $nav_item['url'] ?>"><!--
                --><?= $nav_item['name'] ?><!--
            --></a>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
</div>
<?php } ?>