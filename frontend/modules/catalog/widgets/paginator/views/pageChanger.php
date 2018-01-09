<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

    <div class="this-page">

        <?= Html::beginForm() ?>

        Страница

        <?= Html::textInput('page', $pageArray['page'] ?? 1, ['class' => 'pageInput']) ?>

        <?php
        $pageArray['page'] = 'newPage';
        //$pageArray['page'] = Yii::$app->request->get('page') ? Yii::$app->request->get('page') + 1 : 2;
        $data = Url::toRoute(['/catalog/category/list'] + $pageArray);
        ?>
        из <?= $pages->getPageCount(); ?>
        <?= Html::submitButton('<i class="fa fa-angle-right" aria-hidden="true"></i>', ['class' => 'pageChanger', 'data-url' => $data]) ?>

        <?= Html::endForm(); ?>
    </div>

<?php
$script = <<<JS
$(document).on('click', '.pageChanger', function (e) {
    e.preventDefault();
    var str = $(this).attr('data-url');
    var newPage = parseInt($('.pageInput').val()) + 1;
    var res = str.replace("newPage", newPage);
    window.location.href = res;
    return false;
});
JS;
$this->registerJs($script, yii\web\View::POS_END);