<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\{
    ElasticSearchProduct,
    ElasticSearchSale,
    ElasticSearchItalianProduct
};

/**
 * @var $models ElasticSearchProduct[]
 * @var $model ElasticSearchProduct
 * @var $modelsSale ElasticSearchSale[]
 * @var $modelSale ElasticSearchSale
 * @var $modelsItalianProduct ElasticSearchItalianProduct[]
 * @var $modelItalianProduct ElasticSearchItalianProduct
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page category-page">
        <div class="container-wrap">
            <div class="container large-container">
                <div class="row">
                    <?= Html::tag('h1', $this->title, []); ?>
                </div>
                <div class="cat-content">
                    <div class="row">

                        <div class="col-md-12 col-lg-12">
                            <div class="cont-area">

                                <h3><?= Yii::t('app', 'Результат поиска для') ?>
                                    <span class='label label-success'>
                                            <?= $queryParams['search'] ?>
                                        </span>
                                </h3>

                                <?php if ($modelsSale->getModels() && $modelsSale->getPagination()->getPageCount() >= Yii::$app->getRequest()->get('page')) { ?>
                                    <h3><?= Yii::t('app', 'Sale') ?></h3>
                                    <div class="cat-prod-wrap cat-prod-sale">
                                        <div class="cat-prod">
                                            <?php
                                            foreach ($modelsSale->getModels() as $model) {
                                                $product = $model->product;

                                                if ($model->product != null) {
                                                    $factory = [];
                                                    $factory[$model->product['factory']['id']] = $model->product['factory'];

                                                    echo $this->render('/sale/_list_item', [
                                                        'model' => $model->product,
                                                        'factory' => $factory,
                                                    ]);
                                                }
                                            } ?>
                                        </div>
                                        <div class="pagi-wrap">
                                            <?= frontend\components\LinkPager::widget([
                                                'pagination' => $modelsSale->getPagination()
                                            ]) ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($modelsItalianProduct->getModels() && $modelsItalianProduct->getPagination()->getPageCount() >= Yii::$app->getRequest()->get('page')) { ?>
                                    <h3><?= Yii::t('app', 'Sale in Italy') ?></h3>
                                    <div class="cat-prod-wrap cat-prod-sale">
                                        <div class="cat-prod">
                                            <?php
                                            foreach ($modelsItalianProduct->getModels() as $model) {
                                                $product = $model->product;

                                                if ($model->product != null) {
                                                    $factory = [];
                                                    $factory[$model->product['factory']['id']] = $model->product['factory'];

                                                    echo $this->render('/sale-italy/_list_item', [
                                                        'model' => $model->product,
                                                        'factory' => $factory,
                                                    ]);
                                                }
                                            } ?>
                                        </div>
                                        <div class="pagi-wrap">
                                            <?= frontend\components\LinkPager::widget([
                                                'pagination' => $modelsItalianProduct->getPagination()
                                            ]) ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ($models->getModels() && $models->getPagination()->getPageCount() >= Yii::$app->getRequest()->get('page')) { ?>
                                    <h3><?= Yii::t('app', 'Catalog of furniture') ?></h3>
                                    <div class="cat-prod-wrap">
                                        <div class="cat-prod">
                                            <?php
                                            foreach ($models->getModels() as $model) {
                                                $product = $model->product;

                                                if ($model->product != null) {
                                                    $factory = [];
                                                    $factory[$model->product['factory']['id']] = $model->product['factory'];

                                                    echo $this->render('/category/_list_item', [
                                                        'model' => $model->product
                                                    ]);
                                                } else { ?>
                                                    <div class="one-prod-tile">
                                                        <div class="one-prod-tile-in">
<?php
/* !!! */ echo  '<pre style="color:red;">'; print_r($model); echo '</pre>'; /* !!! */
?>
                                                        </div>
                                                    </div>
                                                <? }
                                            } ?>
                                        </div>
                                        <div class="pagi-wrap">
                                            <?= frontend\components\LinkPager::widget([
                                                'pagination' => $models->getPagination()
                                            ]) ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (!$modelsSale->getModels() && !$modelsItalianProduct->getModels() && !$models->getModels()) {
                                    echo Yii::t('app', 'К сожалению по данному запросу товаров не найдено');
                                } ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
