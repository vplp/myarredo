<?php

use frontend\modules\news\models\Group;
use yii\helpers\Url;

/**
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */

$page = Yii::$app->getRequest()->get('page', null);

$title = $this->context->label;
$title .= ($page) ? ' cтр. '.$page : '';
$this->title = $title ;

$description = 'description';
$description .= ($page) ? ' Страница '.$page : '';


$this->registerMetaTag([
    'name' => 'description',
    'content' => $description
]);

if ($page) {
    $this->registerMetaTag([
        'name' => 'robots',
        'content' => 'noindex, follow'
    ]);
}

?>

<?php if (!empty($models) && Yii::$app->request->get('page')): ?>

        <section>
            <div class="big-title clearfix">
                <h2><?= Yii::t('app', 'News') ?></h2>
                <?php /*
                <p class="all">
                    <?= Yii::t('app', 'Show') ?>:
                    <a href="<?= Url::toRoute(['/news/list/index']) ?>"><?= Yii::t('app', 'All news') ?></a>
                    <?php foreach (Group::getList() as $group): ?>
                        <a href="<?= $group->getUrl() ?>"><?= $group['lang']['title'] ?></a>
                    <?php endforeach; ?>
                </p>
                */?>
            </div>
        </section>
    </div>
    <div class="news-wr-center">
        <div class="news-container">
            <?php foreach ($models as $article): ?>
                <?= Yii::$app->controller->renderPartial('/part/seo',['article' => $article]); ?>
                <?= $this->render('_list_item', ['article' => $article]) ?>
            <?php endforeach; ?>
        </div>

        <div class="pages">
            <?=
            yii\widgets\LinkPager::widget([
                'pagination' => $pages,
                'registerLinkTags' => true,
            ]);
            ?>
        </div>

<?php elseif (isset($models[0])): ?>

        <section>
            <div class="big-title clearfix">
                <h2><?= Yii::t('app', 'News') ?></h2>
                <?php /*
                <p class="all">
                    <?= Yii::t('app', 'Show') ?>:
                    <a href="<?= Url::toRoute(['/news/list/index']) ?>"><?= Yii::t('app', 'All news') ?></a>
                    <?php foreach (Group::getList() as $group): ?>
                        <a href="<?= $group->getUrl() ?>"><?= $group['lang']['title'] ?></a>
                    <?php endforeach; ?>
                </p>
                */?>
            </div>
            <div class="last-news">
                <div class="main-news">
                    <?php if (isset($models[0])): ?>
                    <?= Yii::$app->controller->renderPartial('/part/seo',['article' => $models[0]]); ?>
                        <?= $this->render('_list_item_main', ['article' => $models[0]]) ?>
                    <?php endif; ?>
                </div>
                <div class="two-news">
                    <?php for ($i = 1; $i <= 2; $i++): ?>
                        <?php if (isset($models[$i])): ?>
                            <?= Yii::$app->controller->renderPartial('/part/seo',['article' => $models[$i]]); ?>
                            <?= $this->render('_list_item_other', ['article' => $models[$i]]) ?>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
        </section>
    </div>
    <div class="news-wr-center">
        <div class="news-container">
            <?php for ($i = 3; $i < count($models); $i++): ?>
                <?= Yii::$app->controller->renderPartial('/part/seo',['article' => $models[$i]]); ?>
                <?= $this->render('_list_item', ['article' => $models[$i]]) ?>
            <?php endfor; ?>
        </div>

        <div class="pages">
            <?=
            yii\widgets\LinkPager::widget([
                'pagination' => $pages,
                'registerLinkTags' => true,
            ]);
            ?>
        </div>

<?php endif; ?>