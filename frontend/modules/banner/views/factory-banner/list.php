<?php
use yii\widgets\ListView;

?>

<?=
ListView::widget([
    'dataProvider' => $model->search(Yii::$app->request->queryParams),
    'options' => [
        'tag' => 'div',
        'class' => 'list-wrapper',
        'id' => 'list-wrapper',
    ],
    'layout' => "{pager}\n{items}\n{summary}",
    'itemView' => function ($model, $key, $index, $widget) {
        return $this->render('_list_item',['model' => $model]);

        // or just do some echo
        // return $model->title . ' posted by ' . $model->author;
    },
]);
?>
