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
            'action' => Url::toRoute(['/catalog/category/list'])
        ]) ?>

        <div class="one-filter open">
            <?= Html::a(
                '<i class="fa fa-times" aria-hidden="true"></i>СБРОСИТЬ ФИЛЬТРЫ',
                Url::toRoute(['/catalog/category/list']),
                ['class' => 'reset']
            ) ?>
            <a href="javascript:void(0);" class="filt-but">
                Категории
            </a>
            <div class="list-item">

                <?php foreach ($category as $item):
                    $options = (isset($filter['category']) && in_array($item['alias'], array_values($filter['category'])))
                        ? ['class' => 'one-item selected']
                        : ['class' => 'one-item'];

                    echo Html::a(
                        $item['lang']['title'] . ' (' . $item['count'].')',
                        Yii::$app->catalogFilter->createUrl(['category' => $item['alias']]),
                        $options
                    );

                endforeach; ?>

            </div>
        </div>

        <?php if ($types): ?>
            <div class="one-filter open">
                <a href="javascript:void(0);" class="filt-but">Предмет</a>
                <div class="list-item">

                    <?php foreach ($types as $item): ?>

                        <?php $class = (isset($filter['type']) && in_array($item['alias'], array_values($filter['type'])))
                            ? 'one-item-check selected'
                            : 'one-item-check' ?>

                        <div>
                            <?= Html::beginTag('a', [
                                'href' => Yii::$app->catalogFilter->createUrl(['type' => $item['alias']]),
                                'class' => $class
                            ]); ?>
                            <input type="checkbox">
                            <div class="my-checkbox"></div><?= $item['lang']['title'] ?> (<?= $item['count'] ?>)
                            <?= Html::endTag('a'); ?>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        <?php endif; ?>

        <?php if ($style): ?>
            <div class="one-filter open">
                <a href="javascript:void(0);" class="filt-but">Стиль</a>
                <div class="list-item">

                    <?php foreach ($style as $item): ?>

                        <?php $class = (isset($filter['style']) && in_array($item['alias'], array_values($filter['style'])))
                            ? 'one-item-check selected'
                            : 'one-item-check' ?>

                        <div>
                            <?= Html::beginTag('a', [
                                'href' => Yii::$app->catalogFilter->createUrl(['style' => $item['alias']]),
                                'class' => $class
                            ]); ?>
                            <input type="checkbox">
                            <div class="my-checkbox"></div><?= $item['lang']['title'] ?>  (<?= $item['count'] ?>)
                            <?= Html::endTag('a'); ?>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        <?php endif; ?>

        <?php if ($factory): ?>
            <div class="one-filter open">
                <a href="javascript:void(0);" class="filt-but">Фабрики</a>
                <div class="list-item">

                    <?php
                    $count_selected = 0;

                    if (isset($filter['factory'])): ?>

                        <?php foreach ($factory as $key => $item): ?>

                            <?php
                            if ((isset($filter['factory']) && in_array($item['alias'], array_values($filter['factory'])))):
                                ++$count_selected;
                                ?>

                                <?php $class = (isset($filter['factory']) && in_array($item['alias'], array_values($filter['factory'])))
                                    ? 'one-item-check selected'
                                    : 'one-item-check' ?>

                                <div>
                                    <?= Html::beginTag('a', [
                                            'href' => Yii::$app->catalogFilter->createUrl(['factory' => $item['alias']]),
                                            'class' => $class
                                        ]); ?>
                                    <input type="checkbox">
                                    <div class="my-checkbox"></div><?= $item['lang']['title'] ?> (<?= $item['count'] ?>)
                                    <?= Html::endTag('a'); ?>
                                </div>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php endif; ?>

                        <?php foreach ($factory as $key => $item): ?>

                            <?php if ($count_selected + $key > 9) break; ?>
                            <?php if (isset($filter['factory']) && in_array($item['alias'], array_values($filter['factory']))) continue; ?>

                            <?php $class = (isset($filter['factory']) && in_array($item['alias'], array_values($filter['factory'])))
                                ? 'one-item-check selected'
                                : 'one-item-check' ?>

                            <div>
                                <?= Html::beginTag('a', [
                                    'href' => Yii::$app->catalogFilter->createUrl(['factory' => $item['alias']]),
                                    'class' => $class
                                ]); ?>
                                <input type="checkbox">
                                <div class="my-checkbox"></div><?= $item['lang']['title'] ?> (<?= $item['count'] ?>)
                                <?= Html::endTag('a'); ?>
                            </div>

                        <?php endforeach; ?>


                    <a href="#" class="show-more" data-toggle="modal" data-target="#factory-modal">
                        <i class="fa fa-plus" aria-hidden="true"></i>Показать еще
                    </a>

                    <div id="factory-modal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    Закрыть
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h3 class="text-center">
                                    ВЫБОР ФАБРИКИ
                                </h3>
                                <div class="alphabet-tab">

                                    <?php foreach (Factory::getListLetters() as $key => $letter): ?>
                                        <?= Html::a(
                                            $letter['first_letter'],
                                            "javascript:void(0);",
                                            ($key == 0) ? ['class' => 'active'] : []
                                        ); ?>
                                    <?php endforeach; ?>

                                </div>
                                <div class="alphabet-tab-cont">
                                    <?php foreach (Factory::getListLetters() as $key => $letter): ?>
                                        <div data-show="<?= $letter['first_letter'] ?>"<?= ($key == 0) ? ' style="display: flex;"' : ''?>>

                                            <?php foreach ($factory as $item): ?>

                                                <?php if ($item['first_letter'] == $letter['first_letter']): ?>
                                                    <?php $class = (isset($filter['factory']) && in_array($item['alias'], array_values($filter['factory'])))
                                                        ? 'one-fact selected'
                                                        : 'one-fact' ?>

                                                    <?= Html::beginTag('a', [
                                                        'href' => Yii::$app->catalogFilter->createUrl(['factory' => $item['alias']]),
                                                        'class' => $class
                                                    ]); ?>
                                                    <i class="fa fa-square-o" aria-hidden="true"></i>
                                                    <?= $item['lang']['title'] ?> (<?= $item['count'] ?>)
                                                    <?= Html::endTag('a'); ?>
                                                <?php endif; ?>

                                            <?php endforeach; ?>

                                        </div>

                                    <?php endforeach; ?>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        <?php endif; ?>

        <div class="one-filter">
            <div class="price-slider-cont">
                <a href="javascript:void(0);" class="filt-but">
                    Цена
                </a>
                <div id="price-slider"></div>
                <div class="flex s-between" style="padding: 10px 0;">
                    <div class="cur">
                        <input type="text" id="min-price" value="100">
                    </div>
                    <span class="indent"> - </span>
                    <div class="cur">
                        <input type="text" id="max-price" value="10000">
                    </div>
                </div>
                <a href="#" class="submit">
                    OK
                </a>
            </div>
        </div>

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

$this->registerJs($script, yii\web\View::POS_READY);
