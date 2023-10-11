<?php

use yii\helpers\{
    Url, Html
};
use frontend\modules\catalog\models\Factory;

/**
 * @var \yii\data\Pagination $pages
 * @var Factory $model
 * @var Factory $models
 */

$this->title = $this->context->title;

?>
<style>
    .category-page .cat-prod .one-prod-tile .background,
    .std-slider .background{
        -webkit-filter: none;
        filter: none;
    }
</style>
<main>
    <div class="page factory-list-page">
        <div class="container-wrap">
            <div class="container large-container">
                <div class="section-header">
                    <h1 class="title-text">
                        <?= Yii::t('app', 'Итальянские фабрики мебели - производители из Италии') ?>
                    </h1>
                    <span class="after-title">
                        (<?= Factory::findBase()->count(); ?> <?= Yii::t('app', 'фабрик представлено в нашем каталоге') ?>
                        )
                    </span>
                </div>
                <div class="title-mark">
                    <div class="letter-nav">
                        <div class="container large-container">
                            <ul class="letter-select">
                                <?php 
                                $currentLetter = strtoupper(explode('/' ,$_SERVER['REQUEST_URI'])[2]);
                                foreach (Factory::getListLetters() as $letter) {
                                    echo Html::beginTag('li') .
                                        Html::a(
                                            $letter['first_letter'],
                                            Url::toRoute([
                                                '/catalog/factory/list',
                                                'letter' => strtolower($letter['first_letter'])
                                            ]), $currentLetter == $letter['first_letter'] ? ['class' => 'active'] : ['class' => 'fct-link']
                                        ) .
                                        Html::endTag('li');
                                } ?>
                            </ul>
                            <?php // Html::a('Все', Url::toRoute(['/catalog/factory/list']), ['class' => 'all']); ?>
                        </div>
                    </div>
                    <?php
                    /*
                    ?>
                    <div class="view-but">
                        <a href="<?= Url::toRoute(['/catalog/factory/list', 'view' => 'three']); ?>" >
                            <i class="fa fa-list-ul" aria-hidden="true"></i>
                        </a>
                        <a href="<?= Url::toRoute(['/catalog/factory/list']); ?>" class="active">
                            <i class="fa fa-th-large" aria-hidden="true"></i>
                        </a>
                    </div>
                    */
                    ?>
                </div>
                <div class="factory-tiles flex">
                    <?php foreach ($models as $model) {
                        echo $this->render('_list_item', [
                            'model' => $model,
                            'categories' => $factory_categories[$model['id']] ?? []
                        ]);
                    } ?>
                </div>

                <?php if ($pages->totalCount > $pages->defaultPageSize) { ?>
                    <div class="pagi-wrap">
                        <?= frontend\components\LinkPager::widget([
                            'pagination' => $pages,
                        ]) ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
