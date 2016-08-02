<?php
//TODO: проверить ActiveForm
//TODO: Доработать
use yii\bootstrap\ActiveForm;
use thread\widgets\HtmlForm;

/**
 * @var $model \backend\modules\menu\models\Menu
 * @var $modelLang \backend\modules\menu\models\MenuLang|\thread\app\base\models\ActiveRecord
 */
?>

<?php $form = ActiveForm::begin(); ?>

<div class="row form-group">
    <div class="col-sm-12">
        <?php HtmlForm::buttonPanel($model, $this) ?>
    </div>
</div>

<?php HtmlForm::textInput($model, 'alias') ?>
<?php HtmlForm::textInput($modelLang, 'title') ?>

<div class="row form-group">
    <div class="col-sm-2">
        <?php HtmlForm::switcher($model, 'published') ?>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-12">
        <?php HtmlForm::buttonPanel($model, $this) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
