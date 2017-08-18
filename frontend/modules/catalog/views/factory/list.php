<?php

use yii\helpers\{
    Url, Html
};
use frontend\modules\catalog\models\Factory;

/**
 * @var \yii\data\Pagination $pages
 * @var \frontend\modules\catalog\models\Factory $model
 */

?>

<main>
    <div class="page factory-list-page">
        <div class="letter-nav">
            <div class="container large-container">
                <ul class="letter-select">

                    <?php foreach (Factory::getListLetters() as $letter): ?>
                        <li>
                            <?= Html::a(
                                $letter['first_letter'],
                                Url::toRoute(['/catalog/factory/list', 'letter' => strtolower($letter['first_letter'])])
                            ); ?>
                        </li>
                    <?php endforeach; ?>

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
                    (282 фабрик представлено в нашем каталоге)
                </span>
                <div class="view-but">
                    <a href="<?= Url::toRoute(['/catalog/factory/list', 'view'=> 'three']); ?>" class="tiles4 flex active">
                        <i></i><i></i><i></i><i></i>
                        <i></i><i></i><i></i><i></i>
                    </a>
                    <a href="<?= Url::toRoute(['/catalog/factory/list']); ?>" class="tiles2 flex">
                        <i></i><i></i>
                    </a>
                </div>
            </div>

            <div class="factory-tiles flex">

                <?php foreach ($models as $model): ?>
                    <?= $this->render('_list_item', ['model' => $model, 'categories' => $factory_categories[$model['id']]]) ?>
                <?php endforeach; ?>
            </div>

            <div class="pagi-wrap">
                <?= yii\widgets\LinkPager::widget([
                    'pagination' => $pages,
                    'registerLinkTags' => true,
                    'nextPageLabel' => 'Далее<i class="fa fa-angle-right" aria-hidden="true"></i>',
                    'prevPageLabel' => '<i class="fa fa-angle-left" aria-hidden="true"></i>Назад'
                ]);
                ?>
            </div>

        </div>
    </div>
</main>