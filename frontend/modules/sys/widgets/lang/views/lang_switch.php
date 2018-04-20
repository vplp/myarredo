<a href="javascript:void(0);" class="js-select-lang">
    <i class="fa fa-globe" aria-hidden="true"></i>
    <?= $current['label'] ?>
    <i class="fa fa-chevron-down" aria-hidden="true"></i>
</a>
<ul class="lang-drop-down">
    <?php foreach ($models as $model) : ?>
        <?php if ($model['alias'] == $current['alias']) {
            continue;
        } ?>
        <li>
            <a href="<?= $model['url'] ?>">
                <i class="fa fa-globe" aria-hidden="true"></i>
                <?= $model['label'] ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
