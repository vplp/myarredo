<?php

use backend\modules\sys\modules\logbook\models\Logbook;
use thread\app\bootstrap\ActiveForm;

/**
 * @var $model \backend\modules\sys\modules\logbook\models\Logbook
 */
$form = ActiveForm::begin();
echo $form->text_line($model, 'category')
    . $form->text_line($model, 'user_id')->dropDownList(\backend\modules\user\models\User::dropDownList())
    . $form->text_line($model, 'type')->dropDownList(Logbook::getTypeRange())
    . $form->text_line($model, 'message')->textarea(['style' => 'height:100px;']); ?>

    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->switcher($model, 'is_read') ?>
        </div>
        <div class="col-md-5">
            <?php //= $form->switcher($model, 'published') ?>
        </div>
    </div>

<?php
echo $form->submit($model, $this);
ActiveForm::end();
