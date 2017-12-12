<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

?>

<?= Html::a('Добавить', Url::toRoute(['/banner/factory-banner/create']), ['class' => 'btn btn-default']) ?>

<?=
ListView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'options' => [
        'tag' => 'div',
        'class' => 'list-wrapper',
        'id' => 'list-wrapper',
    ],
    'layout' => "{pager}\n{items}\n{summary}",
    'itemView' => function ($model) {
        return $this->render('_list_item',['model' => $model]);
    },
]);
?>
