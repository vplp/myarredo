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

                    <?php
                    foreach (Factory::getListLetters() as $letter) {
                        echo Html::beginTag('li') .
                            Html::a(
                                $letter['first_letter'],
                                Url::toRoute(['/catalog/factory/list', 'letter' => strtolower($letter['first_letter']), 'view' => 'three'])
                            ) .
                            Html::endTag('li');
                    } ?>

                </ul>
                <?= Html::a(
                    'Все',
                    Url::toRoute(['/catalog/factory/list', 'view' => 'three']),
                    ['class' => 'all']
                ); ?>
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
                    <a href="<?= Url::toRoute(['/catalog/factory/list', 'view' => 'three']); ?>"
                       class="tiles4 flex active">
                        <i></i><i></i><i></i><i></i>
                        <i></i><i></i><i></i><i></i>
                    </a>
                    <a href="<?= Url::toRoute(['/catalog/factory/list']); ?>" class="tiles2 flex">
                        <i></i><i></i>
                    </a>
                </div>
            </div>


            <?php foreach ($models as $letter => $letter_models): ?>

                <div class="factory-stripe">

                    <div class="letter-wrap">
                        <div class="letter">
                            <?= $letter; ?>
                        </div>
                    </div>

                    <ul class="let-list">

                        <?php
                        $key = 1;
                        foreach ($letter_models as $model) {

                            echo Html::beginTag('li') .
                                Html::a(
                                    $model['lang']['title'],
                                    Url::toRoute(['/catalog/factory/view', 'alias' => $model['alias']])
                                ) .
                                Html::endTag('li');

                            if ($key % 12 == 0) {
                                echo '</ul><ul class="let-list">';
                            }

                            ++$key;
                        } ?>

                    </ul>
                </div>

            <?php endforeach; ?>

            <?php if (!Yii::$app->request->get('view')): ?>

                <div class="pagi-wrap">
                    <?= frontend\components\LinkPager::widget([
                        'pagination' => $pages,
                    ]);
                    ?>
                </div>

            <?php endif; ?>
        </div>
    </div>
</main>