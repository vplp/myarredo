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

        <div class="one-filter">
            <?= Html::a(
                Yii::t('app', 'Category'),
                'javascript:void(0);',
                ['class' => 'filt-but']
            ) ?>
            <div class="list-item">
                <?php foreach ($category as $item) {
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
            <div class="one-filter">
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
            </div>
        <?php } ?>

        <?php if ($style) { ?>
            <div class="one-filter">
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

        <?php if ($subtypes) { ?>
            <div class="one-filter">
                <?= Html::a(
                    Yii::t('app', 'Тип'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="list-item">
                    <?php foreach ($subtypes as $item) {
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
        <?php } ?>

        <?php if ($factory) { ?>
            <div class="one-filter">
                <?= Html::a(
                    Yii::t('app', 'Фабрики'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="list-item">
                    <?php
                    $count_factory = 0;
                    foreach ($factory as $letter => $val) {
                        foreach ($val as $item) {
                            ++$count_factory;
                            $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check';

                            echo Html::beginTag('a', ['href' => $item['link'], 'class' => $class]);
                            ?>
                            <div class="filter-group">
                                <div class="my-checkbox"></div><?= $item['title'] ?>
                            </div>
                            <span><?= $item['count'] ?></span>
                            <?= Html::endTag('a'); ?>
                        <?php }
                    } ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($colors) { ?>
            <div class="one-filter colors-box">
                <?= Html::a(
                    Yii::t('app', 'Color'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="list-item">
                    <?php foreach ($colors as $item) {
                        $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check';
                        echo Html::beginTag('a', ['href' => $item['link'], 'class' => $class]);
                        ?>
                        <div class="filter-group">
                            <div class="my-checkbox"
                                 style="background-color:<?= $item['color_code'] ?>;"></div><?= $item['title'] ?>
                        </div>
                        <span><?= $item['count'] ?></span>
                        <?php
                        echo Html::endTag('a');
                    } ?>
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
