<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\shop\models\Order $model
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page adding-product-page">
        <div class="container large-container">

            <?= Html::tag('h1', $this->context->title); ?>

            <div class="manager-history">
                <div class="manager-history-header">
                    <ul class="orders-title-block flex">
                        <li class="order-id">
                            <span>№</span>
                        </li>
                        <li class="application-date">
                            <span>Дата заявки</span>
                        </li>
                        <li>
                            <span>Имя</span>
                        </li>
                        <li>
                            <span>Телефон</span>
                        </li>
                        <li>
                            <span>Email</span>
                        </li>
                        <li>
                            <span>Город</span>
                        </li>
                        <li>
                            <span>Статус</span>
                        </li>
                    </ul>
                </div>
                <div class="manager-history-list">

                    <?php if (!empty($models)): ?>

                        <?php foreach ($models as $model): ?>

                            <div class="item" data-hash="<?= $model->id; ?>">

                                <ul class="orders-title-block flex">
                                    <li class="order-id">
                                        <span>
                                            <?= $model->id; ?>
                                        </span>
                                    </li>
                                    <li class="application-date">
                                        <span><?= $model->getCreatedTime() ?></span>
                                    </li>
                                    <li>
                                        <span><?= $model->customer->full_name ?></span>
                                    </li>
                                    <li>
                                        <span><?= $model->customer->phone ?></span>
                                    </li>
                                    <li>
                                        <span><?= $model->customer->email ?></span>
                                    </li>
                                    <li><span>
                                            <?= ($model->city) ? $model->city->lang->title : ''; ?>
                                        </span>
                                    </li>
                                    <li><span><?= $model->getOrderStatus(); ?></span></li>
                                </ul>

                                <div class="hidden-order-info flex">

                                    <?= $this->render('_list_item', [
                                        'model' => $model,
                                    ]) ?>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>

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