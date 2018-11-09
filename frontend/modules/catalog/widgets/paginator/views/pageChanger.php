<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

    <div class="this-page">

        <?= Html::beginForm() ?>

        <span class="label">
            <?= Yii::t('app', 'Page') ?>
        </span>

        <?php

//        echo Html::submitButton(
//            '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
//            [
//                'class' => 'pageChanger',
//                'data-url' => Url::toRoute(['/catalog/category/list'] + $pageArray)
//            ]
//        );

        echo Html::textInput('page', $pageArray['page'] ?? 1, ['class' => 'pageInput']);

        $pageArray['page'] = 'newPage';
        $data = Url::toRoute(['/catalog/category/list'] + $pageArray);

        if ($pages->getPageCount() > 1) {
            echo Yii::t('app', 'из') . ' ' .
                $pages->getPageCount() .
                Html::submitButton(
                    '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                    [
                        'class' => 'pageChanger',
                        'data-url' => $data
                    ]
                );
        }
        ?>

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