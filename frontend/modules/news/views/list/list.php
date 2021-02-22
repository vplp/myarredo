<?php

use frontend\modules\news\models\Article;

/** @var $pages \yii\data\Pagination */
/** @var $models Article */

$this->title = $this->context->title;
?>

    <div class="myarredo-blog-wrap">
        <div class="myarredo-blog">
            <div class="myarredoblog-box">
                <h2 class="myarredoblog-title"><?= Yii::t('app', 'News') ?></h2>

                <div class="articlebox">
                    <?php for ($i = 0; $i < count($models); $i++) {
                        if (isset($models[$i])) {
                            echo $this->render('_article', ['article' => $models[$i]]);
                        }
                    } ?>
                </div>

                <div class="catalog">
                    <div class="pages">
                        <?= frontend\components\LinkPager::widget([
                            'pagination' => $pages,
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

$this->registerJs($script);
?>
