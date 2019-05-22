<?php

use frontend\modules\articles\models\Article;

/** @var $models Article */
/** @var $models Article */

$this->title = $this->context->title;
?>

    <div class="myarredo-blog-wrap">
        <div class="myarredo-blog">
            <div class="myarredoblog-box">
                <h2 class="myarredoblog-title"><?= Yii::t('app', 'Articles') ?></h2>

                <div class="articlebox">
                    <?php for ($i = 0; $i < count($models); $i++) {
                        if (isset($models[$i])) {
                            echo $this->render('_article', ['article' => $models[$i]]);
                        }
                    } ?>
                </div>

                <div class="catalog">
                    <div class="pages">
                        <?= yii\widgets\LinkPager::widget([
                            'pagination' => $pages,
                            'registerLinkTags' => true,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$script = <<<JS
// Функция для добавление полосы после каждой 4-ой статьи
function addHrForBlog() {
    $('.articlebox').children('.article-item').each(function(i, item) {
        switch(i) {
            case 3:
            $(item).after('<div class="article-item-hr"></div>');
            break;
            case 7:
            $(item).after('<div class="article-item-hr"></div>');
            break;
            case 11:
            $(item).after('<div class="article-item-hr"></div>');
            break;
        }
    });
}
(function() {
    addHrForBlog();
})();

JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>