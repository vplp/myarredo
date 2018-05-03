<?php

use yii\helpers\{
    Url, Html
};
use frontend\modules\catalog\models\Factory;

/**
 * @var \yii\data\Pagination $pages
 * @var \frontend\modules\catalog\models\Factory $model
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page factory-list-page">
        <div class="container-wrap">
            <div class="container large-container">
                <div class="section-header">
                    <h1 class="title-text">
                        <?= Yii::t('app','Итальянские фабрики мебели - производители из Италии') ?>
                    </h1>
                    <span class="after-title">
                        (<?= Factory::findBase()->count(); ?> <?= Yii::t('app','фабрик представлено в нашем каталоге') ?>)
                    </span>
                </div>

                <div class="title-mark">
                    <div class="letter-nav">
                        <div class="container large-container">
                            <ul class="letter-select">

                                <?php
                                foreach (Factory::getListLetters() as $letter) {
                                    echo Html::beginTag('li') .
                                        Html::a(
                                            $letter['first_letter'],
                                            Url::toRoute(['/catalog/factory/list', 'letter' => strtolower($letter['first_letter'])])
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
                        echo $this->render(
                            '_list_item',
                            [
                                'model' => $model,
                                'categories' => $factory_categories[$model['id']] ?? []
                            ]
                        );
                    } ?>

                </div>

                <div class="pagi-wrap">
                    <?= frontend\components\LinkPager::widget([
                        'pagination' => $pages,
                    ]); ?>
                </div>

            </div>
        </div>
    </div>
</main>