<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\Category;

/**
 * @var $model \frontend\modules\catalog\models\Category
 */

?>

<div class="italian-furn">
    <div class="container large-container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="header">
                    <?= Html::a(
                        Yii::t('app', 'Смотреть все категории'),
                        Url::toRoute(['/catalog/category/list']),
                        ['class' => 'more']
                    ); ?>
                </div>
                <div class="tiles-wrap">

                    <?php foreach ($models as $model): ?>
                        <div class="col-xs-6 col-sm-3 col-md-3 one-cat">
                            <?= Html::beginTag('a', ['href' => Category::getUrl($model['alias'])]); ?>
                            <div class="img-cont"><?= Html::img(Category::getImage($model['image_link'])); ?></div>
                            <div class="descr"><?= $model['lang']['title']; ?></div>
                            <?= Html::endTag('a'); ?>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</div>