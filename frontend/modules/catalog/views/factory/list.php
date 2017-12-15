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
                <?= Html::a('Все', Url::toRoute(['/catalog/factory/list']), ['class' => 'all']); ?>
            </div>
        </div>
        <div class="container large-container">
            <div class="title-mark">
                <h1 class="title-text">
                    Итальянские фабрики мебели - производители из Италии
                </h1>
                <span>
                    (<?= Factory::findBase()->count(); ?> фабрик представлено в нашем каталоге)
                </span>
                <div class="view-but">
                    <a href="<?= Url::toRoute(['/catalog/factory/list', 'view' => 'three']); ?>" class="tiles4 flex">
                        <i></i><i></i><i></i><i></i>
                        <i></i><i></i><i></i><i></i>
                    </a>
                    <a href="<?= Url::toRoute(['/catalog/factory/list']); ?>" class="tiles2 flex active">
                        <i></i><i></i>
                    </a>
                </div>
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
                <?= yii\widgets\LinkPager::widget([
                    'pagination' => $pages,
                    'registerLinkTags' => true,
                    'nextPageLabel' => 'Далее<i class="fa fa-angle-right" aria-hidden="true"></i>',
                    'prevPageLabel' => '<i class="fa fa-angle-left" aria-hidden="true"></i>Назад'
                ]); ?>
            </div>

        </div>
    </div>
</main>