<?php

use yii\helpers\Html;

?>

<?= Html::a(
    Yii::t('app', 'Sign Up'),
    ['/user/logout/index'],
    [
        'class' => 'reg'
    ]
); ?>