<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\{
    Product, Category, Factory
};

?>

    <div class="filters">

        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'id' => 'catalog_filter',
            'action' => Url::toRoute([$route])
        ]) ?>

        <?php if (count(Yii::$app->catalogFilter->params) > 1) { ?>
            <?= Html::a(
                Yii::t('app', 'Сбросить фильтры'),
                Url::toRoute([$route]),
                ['class' => 'reset']
            ) ?>
        <?php } ?>

        <div class="one-filter open">
            <?= Html::a(
                Yii::t('app', 'Category'),
                'javascript:void(0);',
                ['class' => 'filt-but']
            ) ?>
            <div class="list-item">

                <?php
                foreach ($category as $item) {
                    $options = $item['checked'] ? ['class' => 'one-item selected'] : ['class' => 'one-item'];

                    echo Html::a(
                        Html::img(Category::getImage($item['image_link3'])) .
                        $item['title'] . '<span>' . $item['count'] . '</span>',
                        $item['link'],
                        $options
                    );
                } ?>

            </div>
        </div>

        <?php if ($types) { ?>
            <div class="one-filter open subject-filter">
                <?= Html::a(
                    Yii::t('app', 'Предмет'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="list-item">

                    <?php foreach ($types as $item) { ?>
                        <?php $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check' ?>

                        <?= Html::beginTag('a', ['href' => $item['link'], 'class' => $class]); ?>
                        <div class="filter-group">
                            <div class="my-checkbox"></div><?= $item['title'] ?></div><span><?= $item['count'] ?></span>
                        <?= Html::endTag('a'); ?>
                    <?php } ?>

                </div>

                <?php if (count($types) > 10) {
                    echo Html::a(
                        '<span class="btn-text">' . Yii::t('app', 'Показать все предметы') . '</span>',
                        'javascript:void(0);',
                        [
                            'class' => 'show-all-sub show-more show-class',
                            'data-variant' => 'Скрыть',
                        ]
                    );
                } ?>

            </div>
        <?php } ?>

        <?php if ($style) { ?>
            <div class="one-filter open">
                <?= Html::a(
                    Yii::t('app', 'Стиль'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="list-item">

                    <?php foreach ($style as $item) { ?>
                        <?php $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check' ?>

                        <?= Html::beginTag('a', ['href' => $item['link'], 'class' => $class]); ?>
                        <div class="filter-group">
                            <div class="my-checkbox"></div><?= $item['title'] ?></div><span><?= $item['count'] ?></span>
                        <?= Html::endTag('a'); ?>
                    <?php } ?>

                </div>
            </div>
        <?php } ?>

        <?php if ($factory) { ?>
            <div class="one-filter open">
                <?= Html::a(
                    Yii::t('app', 'Фабрики'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="list-item">

                    <?php foreach ($factory_first_show as $key => $item) { ?>
                        <?php $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check' ?>

                        <?= Html::beginTag('a', ['href' => $item['link'], 'class' => $class]); ?>
                        <div class="filter-group">
                            <div class="my-checkbox"></div><?= $item['title'] ?></div><span><?= $item['count'] ?></span>
                        <?= Html::endTag('a'); ?>
                    <?php } ?>

                    <?= Html::a(
                        '<span class="btn-text">' . Yii::t('app', 'Показать еще') . '</span>',
                        null,
                        [
                            'class' => 'show-more show-class',
                            'data-toggle' => 'modal',
                            'data-target' => '#factory-modal'
                        ]
                    ) ?>

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

                                    <?php foreach ($factory as $letter => $val) { ?>
                                        <?= Html::a($letter, "javascript:void(0);"); ?>
                                    <?php } ?>

                                </div>
                                <div class="alphabet-tab-cont">
                                    <?php foreach ($factory as $letter => $val) { ?>
                                        <div data-show="<?= $letter ?>">

                                            <?php foreach ($val as $item) { ?>
                                                <?php $class = $item['checked']
                                                    ? 'one-item-check selected'
                                                    : 'one-item-check' ?>

                                                <?= Html::beginTag(
                                                    'a',
                                                    ['href' => $item['link'], 'class' => $class]
                                                ); ?>
                                                <div class="my-checkbox"></div>
                                                <?= $item['title'] ?> (<?= $item['count'] ?>)
                                                <?= Html::endTag('a'); ?>
                                            <?php } ?>

                                        </div>
                                    <?php } ?>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        <?php } ?>

        <?= Html::hiddenInput('sort', Yii::$app->request->get('sort') ?? null) ?>
        <?= Html::hiddenInput('object', Yii::$app->request->get('object') ?? null) ?>

        <?php ActiveForm::end() ?>

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

$this->registerJs($script);
