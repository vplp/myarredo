<?php
use backend\themes\defaults\widgets\forms\ActiveForm;
use yii\bootstrap\Html;

/**
 * @var \backend\modules\seo\models\Seo $model
 * @var \backend\modules\seo\models\SeoLang $modelLang
 * @var ActiveForm $model
 */
?>


<?php $form = ActiveForm::begin(); ?>

<?= Html::textarea('robots', $robotsTxt, ['class' => 'form-control', 'rows' => 10]); ?>
    <br/>
    <div class="text-right submit-panel-buttons"><input type="hidden" name="save_and_exit">
        <button type="submit" class="btn btn-info">Save</button>
    </div>

<?php ActiveForm::end();

