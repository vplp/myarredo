<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\user\models\User;

/**
 * @var $pages \yii\data\Pagination
 * @var $models User[]
 * @var $model User
 */

$this->title = $this->context->title;
?>

<main>
    <div class="page adding-product-page">
        <div class="largex-container">

            <?= Html::tag('h1', $this->context->title); ?>

            <?= $this->render('_form_filter', [
                'model' => $model,
                'params' => $params,
                'models' => $models,
            ]); ?>

            <div class="manager-history">
                <div class="manager-history-header">
                    <ul class="orders-title-block flex">
                        <li class="order-id">
                            <span>User ID</span>
                        </li>
                        <li>
                            <span><?= Yii::t('app', 'Company') ?></span>
                        </li>
                        <li>
                            <span><?= Yii::t('app', 'City') ?></span>
                        </li>
                        <li>
                            <span>Количество авторизаций</span>
                        </li>
                        <li>
                            <span>Дата последней авторизации</span>
                        </li>
                        <li>
                            <span>Количество просмотра PDF</span>
                        </li>
                        <li>
                            <span>Количество ответов</span>
                        </li>
                        <li>
                            <span>Общая стоимость товара</span>
                        </li>
                    </ul>
                </div>
                <div class="manager-history-list">

                    <?php foreach ($models->getModels() as $model) { ?>
                        <div class="item">

                            <?= Html::beginTag('a', [
                                'href' => Url::toRoute([
                                    '/shop/order-answer-stats/view',
                                    'id' => $model->id
                                ])
                            ]) ?>
                            <ul class="orders-title-block flex">
                                <li class="order-id">
                                    <span>
                                        <?= $model->id; ?>
                                    </span>
                                </li>
                                <li>
                                    <span><?= $model->profile->getNameCompany() ?></span>
                                </li>
                                <li>
                                    <span><?= isset($model->profile->city) ? $model->profile->city->getTitle() : '' ?></span>
                                </li>
                                <li>
                                    <span><?= $model->getCountLogin() ?></span>
                                </li>
                                <li>
                                    <span><?= $model->getLastDateLogin() ?></span>
                                </li>
                                <li>
                                    <span><?= $model->getFactoryFileClickStatsCount() ?></span>
                                </li>
                                <li>
                                    <span><?= $model->answerCount ?></span>
                                </li>
                                <li>
                                    <span><?= $model->getOrderItemPriceTotalCost() ?></span>
                                </li>
                            </ul>
                            <?= Html::endTag('a') ?>
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
