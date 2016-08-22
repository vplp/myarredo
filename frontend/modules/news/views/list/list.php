<?php

use frontend\modules\news\models\Group;
use yii\helpers\Url;

/**
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */

$page = Yii::$app->getRequest()->get('page', null);

$title = $this->context->label;
$title .= ($page) ? ' cтр. ' . $page : '';
$this->title = $title;

$description = 'description';
$description .= ($page) ? ' Страница ' . $page : '';


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

<h2><?= Yii::t('app', 'News') ?></h2>
<div class="news-container">
    <?php foreach ($models as $article): ?>
        <?= $this->render('/part/seo', ['article' => $article]) ?>
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