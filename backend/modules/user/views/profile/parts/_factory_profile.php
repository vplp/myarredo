<?php

/**
 * @var $model \backend\modules\user\models\Profile
 */

?>

<?php if (in_array($model['user']['group_id'], [3])):
    echo $form->text_line($model, 'email_company');
endif; ?>
