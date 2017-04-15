<div class="nav sticky">
    <div class="nav-content">
        <div class="left-content">
            <h1 class="item">
                <a href="<?= $page['urls']['index'] ?>"><strong>UP MOrg</strong></a>
            </h1>
        </div>
        <div class="right-content align-right">
            <?php foreach($page['nav'] as $nav_item) { ?>
            <a class="item <?= ($nav_item['name'] == 'Sign Up') ? 'button' : ''; ?>" href="<?= $nav_item['url'] ?>">
                <?= $nav_item['name'] ?>
            </a>
            <?php } ?>
        </div>
    </div>
</div>