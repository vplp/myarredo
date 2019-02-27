<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\Category;

?>

    <div class="filters">

        <?php
        $form = ActiveForm::begin([
            'method' => 'get',
            'id' => 'catalog_filter',
            'action' => Url::toRoute([$route])
        ]); ?>

        <div class="one-filter open">

            <a href="javascript:void(0);" class="filt-but"><?= Yii::t('app', 'Category') ?></a>

            <div class="list-item">
                <?php
                foreach ($category as $item) {
                    $options = $item['checked']
                        ? ['class' => 'one-item selected']
                        : ['class' => 'one-item'];
                    echo Html::a(
                        Html::img(
                            Category::getImage($item['image_link3'])
                        ) . $item['title'] . '<span>' . $item['count'] . '</span>',
                        $item['link'],
                        $options
                    );
                } ?>
            </div>
        </div>

        <?php
        if ($types) { ?>
            <div class="one-filter open subject-filter">
                <a href="javascript:void(0);" class="filt-but"><?= Yii::t('app', 'Предмет') ?></a>
                <div class="list-item">

                    <?php
                    foreach ($types as $item) {
                        $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check';

                        echo Html::beginTag('a', ['href' => $item['link'], 'class' => $class]);
                        ?>
                        <div class="filter-group">
                            <div class="my-checkbox"></div><?= $item['title'] ?></div><span><?= $item['count'] ?></span>
                        <?php
                        echo Html::endTag('a');
                    } ?>

                </div>

                <?php if (count($types) > 10) { ?>
                    <a href="javascript:void(0);" class="show-all-sub show-more show-class" data-variant="Скрыть">
                        <span class="btn-text"><?= Yii::t('app', 'Показать все предметы') ?></span>
                    </a>
                <?php } ?>

            </div>
        <?php }

        if ($style) { ?>
            <div class="one-filter open">
                <a href="javascript:void(0);" class="filt-but"><?= Yii::t('app', 'Стиль') ?></a>
                <div class="list-item">

                    <?php
                    foreach ($style as $item) {
                        $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check';

                        echo Html::beginTag('a', ['href' => $item['link'], 'class' => $class]);
                        ?>
                        <div class="filter-group">
                            <div class="my-checkbox"></div><?= $item['title'] ?></div><span><?= $item['count'] ?></span>
                        <?php
                        echo Html::endTag('a');
                    } ?>

                </div>
            </div>
        <?php }

        if ($factory) { ?>
            <div class="one-filter open">
                <a href="javascript:void(0);" class="filt-but"><?= Yii::t('app', 'Фабрики') ?></a>
                <div class="list-item">

                    <?php
                    foreach ($factory_first_show as $key => $item) {
                        $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check';
                        echo Html::beginTag('a', ['href' => $item['link'], 'class' => $class]);
                        ?>
                        <div class="filter-group">
                            <div class="my-checkbox"></div><?= $item['title'] ?></div><span><?= $item['count'] ?></span>
                        <?php
                        echo Html::endTag('a');
                    } ?>

                    <a href="#" class="show-more show-class" data-toggle="modal" data-target="#factory-modal">
                        <span class="btn-text">
                            <?= Yii::t('app', 'Показать еще') ?>
                        </span>
                    </a>

                    <div id="factory-modal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <?= Yii::t('app', 'Close') ?>
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h3 class="text-center">
                                    <?= Yii::t('app', 'Выбор фабрики') ?>
                                </h3>
                                <div class="alphabet-tab">

                                    <?php
                                    foreach ($factory as $letter => $val) {
                                        echo Html::a($letter, "javascript:void(0);");
                                    } ?>

                                </div>
                                <div class="alphabet-tab-cont">
                                    <?php foreach ($factory as $letter => $val) { ?>
                                        <div data-show="<?= $letter ?>">

                                            <?php
                                            foreach ($val as $item) {
                                                $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check';
                                                echo Html::beginTag('a', ['href' => $item['link'], 'class' => $class]);
                                                ?>
                                                <div class="my-checkbox"></div><?= $item['title'] ?> (<?= $item['count'] ?>)
                                                <?php
                                                echo Html::endTag('a');
                                            } ?>

                                        </div>

                                    <?php } ?>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        <?php }

        /*
        <div class="one-filter">
            <div class="price-slider-cont">
                <a href="javascript:void(0);" class="filt-but">
                    Цена
                </a>
                <div id="price-slider"></div>
                <div class="flex s-between" style="padding: 10px 0;">
                    <div class="cur">
                        <input type="text" id="min-price" value="<?= $min_max_price['minPrice'] ?>">
                    </div>
                    <span class="indent"> - </span>
                    <div class="cur">
                        <input type="text" id="max-price" value="<?= $min_max_price['maxPrice'] ?>">
                    </div>
                </div>
                <a href="#" class="submit">
                    OK
                </a>
            </div>
        </div>
        */

        if ($colors) {?>
            <div class="one-filter open colors-box">
                <a href="javascript:void(0);" class="filt-but"><?= Yii::t('app', 'Color') ?></a>
                <div class="list-item">

                    <?php
                    foreach ($colors as $item) {
                        $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check';
                        echo Html::beginTag('a', ['href' => $item['link'], 'class' => $class]);
                        ?>
                        <div class="filter-group">
                            <div class="my-checkbox" style="background-color:<?= $item['color_code'] ?>;"></div><?= $item['title'] ?>
                        </div>
                        <span><?= $item['count'] ?></span>
                        <?php
                        echo Html::endTag('a');
                    } ?>

                </div>

                <?php if (count($colors) > 10) { ?>
                    <a href="javascript:void(0);" class="show-all-sub show-more show-class" data-variant="Скрыть">
                        <span class="btn-text"><?= Yii::t('app', 'Show all colors') ?></span>
                    </a>
                <?php } ?>

            </div>

        <?php }

        echo Html::hiddenInput('sort', Yii::$app->request->get('sort') ?? null);
        echo Html::hiddenInput('object', Yii::$app->request->get('object') ?? null);

        if (count(Yii::$app->catalogFilter->params) >= 1) {
            echo Html::a(
                Yii::t('app', 'Сбросить фильтры'),
                Url::toRoute([$route]),
                [
                    'class' => 'reset',
                    'rel' => 'nofollow'
                ]
            );
        }

        ActiveForm::end();
        ?>

    </div>

<?php
$script = <<<JS
$('.category-filter label').on('click', function () {
    var checkbox = $(this).parent().find('input[type=checkbox]');  
   
    if ($(this).parent().find('input[type=checkbox]:checked').length) {
        checkbox.prop('checked', false);
    } else {
        checkbox.prop('checked', true);
    }

    $('#catalog_filter').submit();
});
$('.category-filter input[type=checkbox]').on( "click", function () {
    $('#catalog_filter').submit();
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);
