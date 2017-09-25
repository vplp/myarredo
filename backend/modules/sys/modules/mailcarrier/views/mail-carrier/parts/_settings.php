<?php
use backend\modules\sys\modules\mailcarrier\models\MailBox;

/**
 * @var $model \backend\modules\news\models\Group
 * @var $modelLang \backend\modules\news\models\GroupLang
 */
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
    . $form->field($model, 'mailbox_id')->dropDownList(MailBox::dropDownList())
    . $form->text_line($model, 'from_email')
    . $form->text_line($model, 'from_user')
    . $form->field($model, 'send_to')
    . $form->text_line($model, 'subject')
    . $form->switcher($model, 'published');