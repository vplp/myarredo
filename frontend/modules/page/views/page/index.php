<?php

use yii\helpers\Html;
//SEO register
Yii::$app->metatag->registerModel($model);

$this->title = $model['lang']['title'];
?>

<?php Html::tag('h1', Html::encode($model['lang']['title']), []); ?>
<?= $model['lang']['content'] ?>

