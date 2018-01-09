<?php
use backend\app\bootstrap\ActiveForm;
use thread\modules\sys\modules\mailcarrier\models\MailBox;

/**
 * @var $model \backend\modules\sys\modules\mailcarrier\models\MailBox
 * @var $modelLang \backend\modules\sys\modules\mailcarrier\models\MailBoxLang
 */
//
$form = ActiveForm::begin();
//
echo $form->submit($model, $this);
if ($model['id'] == 1) {
    echo $form->text_line($model, 'alias', [
        'inputOptions' => [
            'readonly' => 'readonly'
        ]
    ]);
} else {
    echo $form->text_line($model, 'alias');
}
echo $form->text_line_lang($modelLang, 'title')
    . $form->text_line($model, 'host')
    . $form->text_line($model, 'username')
    . $form->text_line($model, 'password')
    . $form->text_line($model, 'port')
    . $form->field($model, 'encryption')->dropDownList(MailBox::statusEncryptionRange())
    . $form->switcher($model, 'published');
echo $form->submit($model, $this);
//
ActiveForm::end();
