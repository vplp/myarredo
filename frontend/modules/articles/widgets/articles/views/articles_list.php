<?php

use yii\helpers\{
    Url, Html
};
//
use frontend\modules\articles\models\Article;

/** @var $articles Article[] */
/** @var $article Article */

?>

<?php if (!empty($articles)) { ?>
    <section class="articles">
        <div class="container cf">
            <h3><?= Yii::t('front', 'Articles') ?></h3>
            <?= Html::a(
                Yii::t('front', 'All articles'),
                Url::toRoute(['/articles/articles/list']),
                ['class' => 'more-page']
            ) ?>
            <div class="articles_cnt">

                <?php foreach ($articles as $article) {
                    echo $this->render('_article', ['article' => $article]);
                } ?>

            </div>
            <div class="articles_b_mobile cf">
                <?= Html::a(
                    Yii::t('front', 'All articles'),
                    Url::toRoute(['/articles/articles/list']),
                    ['class' => 'more-page']
                ) ?>
            </div>
        </div>
    </section>
<?php }
