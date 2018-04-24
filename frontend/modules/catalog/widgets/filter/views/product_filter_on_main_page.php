<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};

?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'id' => 'catalog_filter',
    'action' => false
]) ?>

    <div class="filter-title">
        Портал проверенных поставщиков
        итальянской мебели
        <div class="frosted-glass"></div>
    </div>

    <div class="filter-bot">

        <?= Html::dropDownList(
            'category',
            '',
            ['' => 'Категория'] + $category,
            [
                'class' => 'first',
                'data-styler' => true
            ]
        ); ?>

        <?= Html::dropDownList(
            'types',
            '',
            ['' => 'Предмет'] + $types,
            [
                'class' => false,
                'data-styler' => true,
            ]
        ); ?>

        <div class="filter-price">
            <div class="left">
                <input type="text" placeholder="от">
                <input type="text" placeholder="до">
                €
            </div>

            <?= Html::submitButton('Найти', [
                'class' => 'search',
                'name' => 'filter_on_main_page',
                'value' => 1
            ]) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>