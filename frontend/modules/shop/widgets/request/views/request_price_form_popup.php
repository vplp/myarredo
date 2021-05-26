<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
use frontend\modules\shop\models\CartCustomerForm;

/** @var $model CartCustomerForm */

$model->user_agreement = 1;

?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"
        id="myModalLabel"><?= Yii::t('app', 'Заполните форму - получите лучшую цену на этот товар') ?></h4>
</div>

<div class="modal-body">
    <?= $this->renderAjax('@app/modules/shop/widgets/request/views/parts/ajax_get_price_form', [
        'model' => $model
    ]) ?>
</div>


