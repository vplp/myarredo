<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\{
    Sale, SaleLang
};

/**
 * @var $model Sale
 * @var $modelLang SaleLang
 */

?>

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
</div>
<!-- steps box end -->

<?= $this->render('../../sale/view', [
    'model' => $model,
    'modelLang' => $modelLang
]) ?>

<div class="buttons-cont">
    <?= Html::a(
        Yii::t('app', 'Edit'),
        ['/catalog/partner-sale/update', 'id' => $model->id],
        ['class' => 'btn btn-primary']
    ) ?>
</div>