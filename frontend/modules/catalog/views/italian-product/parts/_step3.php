<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang
};

/**
 * @var ItalianProduct $model
 * @var ItalianProductLang $modelLang
 */

?>

<div class="form-horizontal add-itprod-content">

    <!-- steps box -->
    <div class="progress-steps-box">
        <div class="progress-steps-step<?= !Yii::$app->request->get('step') ? ' active' : '' ?>">
            <span class="step-numb">1</span>
            <span class="step-text"><?= Yii::t('app', 'Информация про товар') ?></span>
        </div>
        <div class="progress-steps-step<?= Yii::$app->request->get('step') == 'photo' ? ' active' : '' ?>">
            <span class="step-numb">2</span>
            <span class="step-text"><?= Yii::t('app', 'Фото товара') ?></span>
        </div>
        <div class="progress-steps-step<?= Yii::$app->request->get('step') == 'check' ? ' active' : '' ?>">
            <span class="step-numb">3</span>
            <span class="step-text"><?= Yii::t('app', 'Проверка товара') ?></span>
        </div>
        <div class="progress-steps-step<?= Yii::$app->request->get('step') == 'payment' ? ' active' : '' ?>">
            <span class="step-numb">4</span>
            <span class="step-text"><?= Yii::t('app', 'Оплата') ?></span>
        </div>
    </div>
    <!-- steps box end -->

    <?= $this->render('../../sale-italy/view', [
        'model' => $model,
        'modelLang' => $modelLang
    ]) ?>

    <div class="buttons-cont">
        <?= Html::a(
            Yii::t('app', 'Edit'),
            ['/catalog/italian-product/update', 'id' => $model->id],
            ['class' => 'btn btn-primary']
        ) ?>

        <?= Html::a(
            Yii::t('app', 'Опубликовать'),
            ['/catalog/italian-product/update', 'id' => $model->id, 'step' => 'payment'],
            ['class' => 'btn btn-primary']
        ) ?>
    </div>

</div>

<!-- rules box -->
<div class="add-itprod-rules">
    <div class="add-itprod-rules-item">

        <?= Yii::$app->param->getByName('ITALIAN_PRODUCT_STEP3_TEXT') ?>

        <!--<h4 class="additprod-title">Помни это...</h4>
    <div class="additprod-textbox">
        <p>
            Обьявление будет опубликовано если оно соответствует правилам Myarredo
        </p>
        <p>
            Не вводите одно и то же обьявление несколько раз
        </p>
    </div>
    <div class="panel-additprod-rules">
        <a href="#" class="btn-myarredo">
            <i class="fa fa-question-circle" aria-hidden="true"></i>
            Правила
        </a>
    </div>-->
    </div>
</div>
<!-- rules box end -->
