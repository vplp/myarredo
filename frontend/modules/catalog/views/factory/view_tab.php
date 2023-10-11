<?php

use yii\helpers\{
    Url, Html
};
use frontend\themes\myarredo\assets\AppAsset;
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{
    Factory, Category
};
use frontend\modules\shop\widgets\request\RequestFindProduct;

/**
 * @var $model Factory
 */

$this->title = $this->context->title;

$bundle = AppAsset::register($this);

$route = $model->producing_country_id == 4
    ? ['/catalog/category/list']
    : ['/catalog/countries-furniture/list'];

?>

<main>
    <div class="page factory-page">
        <div class="container-wrap">
            <div class="container large-container">

                <div class="row">
                    <?= Breadcrumbs::widget([
                        'links' => $this->context->breadcrumbs,
                    ]) ?>
                </div>

                <div class="row factory-det">
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="fact-img">
                            <?= Html::img(Factory::getImage($model['image_link'])) ?>
                        </div>
                        <div class="nosearch-panel">
                            <?= RequestFindProduct::widget(['view' => 'ajax_request_find_product']) ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-9">
                        <div class="descr">

                            <?= Html::tag(
                                'h1',
                                $h1,
                                ['class' => 'title-text']
                            ); ?>

                            <div class="fact-link">
                                <?= Html::a(
                                    $model['url'],
                                    'http://' . $model['url'],
                                    [
                                        'target' => '_blank',
                                        'rel' => 'nofollow'
                                    ]
                                ); ?>
                            </div>

                            <div class="fact-assort-wrap">

                                <?= $this->render('parts/_tabs', [
                                    'model' => $model
                                ]) ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
