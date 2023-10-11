<?php
/**
 * @var $model \backend\modules\news\models\Group
 * @var $modelLang \backend\modules\news\models\GroupLang
 */
echo $form->field($model, 'send_cc')
    . $form->field($model, 'send_bcc')
    . $form->text_line($model, 'path_to_layout')
    . $form->text_line($model, 'path_to_view');
