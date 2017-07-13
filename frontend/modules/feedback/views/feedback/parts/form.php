<?php

use yii\helpers\{
    Html, Url
};
use yii\bootstrap\ActiveForm;

/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */

$form = ActiveForm::begin([
    'action' => Url::toRoute(['/feedback/form/send'])
]);
?>
<div class="form-group has-feedback">
    <?= $form->field($model, 'user_name', [
        'template' => '{label}{input}<i class="fa fa-user form-control-feedback"></i>{error}{hint}'
    ])->textInput([
        'placeholder' => Yii::t('feedback', 'Enter your name')
    ]) ?>
</div>
<div class="form-group has-feedback">
    <?= $form->field($model, 'email', [
        'template' => '{label}{input}<i class="fa fa-envelope form-control-feedback"></i>{error}{hint}'
    ])->textInput([
        'placeholder' => Yii::t('feedback', 'Enter your email')
    ]) ?>
</div>
<div class="form-group has-feedback">
    <?= $form->field($model, 'subject', [
        'template' => '{label}{input}<i class="fa fa-navicon form-control-feedback"></i>{error}{hint}'
    ])->textInput([
        'placeholder' => Yii::t('feedback', 'Enter your subject')
    ]) ?>
</div>
<div class="form-group has-feedback">
    <?= $form->field($model, 'question', [
        'template' => '{label}{input}<i class="fa fa-pencil form-control-feedback"></i>{error}{hint}'
    ])->textarea([
        'placeholder' => Yii::t('faq', 'Enter your question'),
        'style' => 'resize: none; height:150px;'
    ]) ?>
</div>
<div class="g-recaptcha" data-sitekey="your_site_key">
    <div style="width: 304px; height: 78px;">
        <div>
            <iframe
                    src="https://www.google.com/recaptcha/api2/anchor?k=your_site_key&amp;co=aHR0cDovL2xvY2FsaG9zdDo4MA..&amp;hl=uk&amp;v=r20170329125654&amp;size=normal&amp;cb=vd4t1pm16ess"
                    title="віджет recaptcha" width="304" height="78" frameborder="0" scrolling="no"
                    name="undefined"></iframe>
        </div>
        <textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response"
                  style="width: 250px; height: 40px; border: 1px solid #c1c1c1; margin: 10px 25px; padding: 0px; resize: none;  display: none; "></textarea>
    </div>
</div>
<?= Html::submitButton('Submit', [
    'class' => 'submit-button btn btn-default'
]) ?>
<?php ActiveForm::end(); ?>
