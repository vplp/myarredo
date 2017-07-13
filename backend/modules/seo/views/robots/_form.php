<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

?>


<?php $form = ActiveForm::begin(); ?>

<?= Html::textarea('robots', $robotsTxt, ['class' => 'form-control', 'rows' => 10]); ?>
    <br>
    <div class="text-right submit-panel-buttons"><input type="hidden" name="save_and_exit">
        <button type="submit" class="btn btn-info"><?= Yii::t('app', 'Save') ?></button>
    </div>

<?php ActiveForm::end();

