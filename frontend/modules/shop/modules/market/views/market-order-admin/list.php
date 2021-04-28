<?php

use yii\helpers\{
    Html, Url
};
use yii\data\Pagination;
use frontend\modules\shop\modules\market\models\MarketOrder;

/**
 * @var $pages Pagination
 * @var $model MarketOrder
 * @var $models array
 * @var $params array
 */

$this->title = $this->context->title;
?>
    <main>
        <div class="page adding-product-page">
            <div class="largex-container">

                <?= Html::tag('h1', $this->context->title); ?>

                <div class="flex form-inline">
                    <?= Html::a(
                        Yii::t('market', 'Добавить заказ'),
                        ['/shop/market/market-order-admin/create'],
                        ['class' => 'btn btn-cancel']
                    ) ?>
                </div>

                <?= $this->render('_form_filter', [
                    'model' => $model,
                    'params' => $params,
                    'models' => $models,
                ]); ?>

                <div class="manager-history">
                    <div class="manager-history-header">
                        <ul class="orders-title-block flex">
                            <li class="order-id">
                                <span>№</span>
                            </li>
                            <li class="application-date">
                                <span><?= Yii::t('app', 'Request Date') ?></span>
                            </li>
                            <li>
                                <span><?= Yii::t('app', 'Name') ?></span>
                            </li>
                            <li>
                                <span><?= Yii::t('app', 'Email') ?></span>
                            </li>
                            <li>
                                <span><?= Yii::t('app', 'Country') ?></span>
                            </li>
                            <li>
                                <span><?= Yii::t('app', 'City') ?></span>
                            </li>
                            <li>
                                <span><?= Yii::t('app', 'Cost') ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="manager-history-list">

                        <?php foreach ($models->getModels() as $model) { ?>
                            <div class="item" data-hash="<?= $model->id; ?>">

                                <ul class="orders-title-block flex">
                                    <li class="order-id">
                                        <span><?= $model->id; ?></span>
                                    </li>
                                    <li class="application-date">
                                        <span><?= date('Y-m-d', $model->created_at) ?></span>
                                    </li>
                                    <li>
                                        <span><?= $model->full_name ?></span>
                                    </li>
                                    <li>
                                        <span><?= $model->email ?></span>
                                    </li>
                                    <li>
                                        <span><?= ($model->country) ? $model->country->getTitle() : ''; ?></span>
                                    </li>
                                    <li>
                                        <span><?= ($model->city) ? $model->city->getTitle() : ''; ?></span>
                                    </li>
                                    <li>
                                        <span><?= $model->cost . ' ' . $model->currency; ?></span>
                                    </li>
                                </ul>

                                <div class="hidden-order-info flex">

                                    <?= $this->render('_list_item', [
                                        'model' => $model
                                    ]) ?>

                                </div>
                            </div>

                        <?php } ?>

                    </div>

                    <?= frontend\components\LinkPager::widget([
                        'pagination' => $models->getPagination(),
                    ]) ?>

                </div>
            </div>
        </div>
    </main>


<?php
$script = <<<JS

JS;

$this->registerJs($script);
