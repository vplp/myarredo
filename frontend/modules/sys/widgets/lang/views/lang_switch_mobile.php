<div class="one-list js-toggle-list">
    <i class="fa fa-globe" aria-hidden="true"></i>
    <?= $current['label'] ?>
</div>
<ul class="mobile-lang-list js-list-container">
    <?php
    foreach ($models as $model) {
        if ($model['alias'] == $current['alias']) {
            continue;
        } ?>
        <li>
            <a href="<?= $model['url'] ?>">
                <i class="fa fa-globe" aria-hidden="true"></i>
                <?= $model['label'] ?>
            </a>
        </li>
    <?php } ?>
</ul>