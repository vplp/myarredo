<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\Category;

/** @var $route string */
/** @var $category Category */
/** @var $types [] */
/** @var $subtypes [] */
/** @var $style [] */
/** @var $factory [] */
/** @var $factory_first_show [] */
/** @var $colors [] */
/** @var $priceRange [] */

?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => false
]) ?>

    <div class="filter-title">
        <div><?= Yii::t('app', 'Портал проверенных поставщиков итальянской мебели') ?></div>
        <div class="frosted-glass"></div>
    </div>

    <div class="filter-bot">

        <?= Html::dropDownList(
            'category',
            '',
            ['' => Yii::t('app', 'Category')] + $category,
            [
                'id' => 'filter_by_category',
                'class' => 'first',
                'data-styler' => true
            ]
        ); ?>

        <?= Html::dropDownList(
            'types',
            '',
            ['' => Yii::t('app', 'Предмет')] + $types,
            [
                'id' => 'filter_by_types',
                'class' => false,
                'data-styler' => true,
            ]
        ); ?>

        <div class="filter-price">
            <div class="left">
                <input type="text" name="price[from]" class="price-diap" placeholder="<?= Yii::t('app', 'от') ?>">
                <input type="text" name="price[to]" class="price-diap" placeholder="<?= Yii::t('app', 'до') ?>">€
                <input type="hidden" name="price[currency]" value="EUR">
            </div>

            <?= Html::submitButton(
                Yii::t('app', 'Найти'),
                [
                    'class' => 'search',
                    'name' => 'filter_on_main_page',
                    'value' => 1,
                    'rel' => 'nofollow'
                ]
            ) ?>
        </div>
    </div>

<?php ActiveForm::end() ?>
