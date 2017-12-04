<?php

/* @var $this yii\web\View */
/* @var $model \backend\modules\shop\models\Order */

foreach ($model->orderAnswers as $answer) {
    echo '<div><strong>' .$answer['user']['profile']['name_company'] . '</strong></div>'
        . '<div>' . $answer['answer'] . '</div><br>';
}