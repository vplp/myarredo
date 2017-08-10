<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var $model \frontend\modules\catalog\models\Category
 */

?>

<div class="italian-furn">
    <div class="container large-container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="header">
                    <h2>ИТАЛЬЯНСКАЯ МЕБЕЛЬ В МОСКВЕ</h2>
                    <?= Html::a(
                        'Смотреть все категории',
                        Url::toRoute(['/catalog/category/list']),
                        ['class' => 'more']
                    ); ?>
                </div>
                <div class="tiles-wrap">

                    <?php foreach ($models as $model): ?>
                        <div class="col-xs-6 col-sm-3 col-md-3 one-cat">
                            <?= Html::beginTag('a', ['href' => $model->getUrl()]); ?>
                            <div class="img-cont"><?= Html::img($model->getImageLink()); ?></div>
                            <div class="descr"><?= $model['lang']['title']; ?></div>
                            <?= Html::endTag('a'); ?>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</div>