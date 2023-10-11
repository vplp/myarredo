<?php

use frontend\modules\shop\models\FormFindProduct;

/** @var $model FormFindProduct */

$this->title = $this->context->title;

$model->user_agreement = 1;

?>

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title"><?= Yii::t('app', 'Не нашли то что искали? Оставьте заявку тут') ?></h3>
        </div>
        <div class="modal-body">
            <?= $this->renderAjax('request_find_product', [
                'model' => $model
            ]); ?>
        </div>
    </div>
</div>


