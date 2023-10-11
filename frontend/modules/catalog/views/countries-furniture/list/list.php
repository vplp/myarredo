<?php

use yii\helpers\{
    Html, Url
};
use frontend\components\Breadcrumbs;
//
use frontend\modules\catalog\models\{Product, ItalianProduct, ItalianProductLang, ProductLang};
use frontend\modules\catalog\widgets\filter\{
    ProductSorting
};
use frontend\modules\catalog\widgets\paginator\PageChanger;
use frontend\modules\catalog\widgets\product\ViewedProducts;
use frontend\modules\catalog\widgets\product\ProductsNovelties;

/**
 * @var $pages \yii\data\Pagination
 * @var $model Product
 * @var $models Product[]
 */

$this->title = $this->context->title;

$keys = Yii::$app->catalogFilter->keys;
$params = Yii::$app->catalogFilter->params;

?>
<style>
    .category-page .cat-prod .one-prod-tile .background,
    .std-slider .background{
        -webkit-filter: none;
        filter: none;
    }
</style>
    <main>
        <div class="page category-page">
            <div class="container-wrap">
                <div class="container large-container">
                    <div>

                        <?= Html::tag('h1', Yii::$app->metatag->seo_h1) ?>

                        <?php if (isset($params[$keys['factory']]) && count($params[$keys['factory']]) == 1) {
                            echo Html::a(
                                Yii::t('app', 'Перейти на страницу фабрики'),
                                ['/catalog/factory/view', 'alias' => $params[$keys['factory']][0]]
                            );
                        } ?>

                        <?= Breadcrumbs::widget([
                            'links' => $this->context->breadcrumbs,
                        ]) ?>

                    </div>

                    <div class="cat-content">
                        <?= Html::a(
                            Yii::t('app', 'Фильтры'),
                            'javascript:void(0);',
                            ['class' => 'js-filter-btn']
                        ) ?>
                        <div class="clearfix">
                            <div class="col-md-3 col-lg-3 js-filter-modal ajax-get-filter"></div>
                            <div class="col-md-9 col-lg-9">
                                <div class="cont-area">

                                    <div class="top-bar flex">

                                        <?= ProductSorting::widget([]) ?>

                                        <?= PageChanger::widget(['pages' => $pages]) ?>

                                    </div>

                                    <div class="cat-prod-wrap">
                                        <div class="cat-prod">
                                            <?php if (!empty($models)) {
                                                foreach ($models as $model) {
                                                    echo $this->render(
                                                        isset($model['price_new'])
                                                            ? '_list_item_sale'
                                                            : '_list_item',
                                                        [
                                                            'model' => $model
                                                        ]
                                                    );
                                                }
                                            } else if (empty($models) && isset($params)) {
                                                echo Html::tag('p', Yii::t('app', 'По таким параметрам нет товаров'));
                                            } ?>
                                        </div>

                                        <?php if ($pages->totalCount > $pages->defaultPageSize) { ?>
                                            <div class="pagi-wrap">
                                                <?= frontend\components\LinkPager::widget([
                                                    'pagination' => $pages,
                                                ]) ?>
                                            </div>
                                        <?php } ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="clearfix">
                            <div class="comp-advanteges">

                                <?php if (!Yii::$app->request->get('page')) { ?>
                                    <?= Yii::$app->metatag->seo_content ?>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

<?php
$queryParams = json_encode($params);
$url = Url::toRoute('/catalog/countries-furniture/ajax-get-filter');
$link = '/catalog/countries-furniture/list';
$script = <<<JS
$.post('$url', {
        _csrf: $('#token').val(),
        catalogFilterParams: $queryParams,
        link: '$link'
    }, function(data) {
    $('.ajax-get-filter').html(data.html);
    
    $('.submit_price').on('click', function () {
        let link = $('input[name="price[link]"]').val(),
            min = $('input[name="price[min]"]').val(),
            max = $('input[name="price[max]"]').val();
        
        link = link.replace('{priceMin}', min);
        link = link.replace('{priceMax}', max);
    
        window.location.href = link;
    });
    
    $('.category-filter label').on('click', function () {
        let checkbox = $(this).parent().find('input[type=checkbox]');  
       
        if ($(this).parent().find('input[type=checkbox]:checked').length) {
            checkbox.prop('checked', false);
        } else {
            checkbox.prop('checked', true);
        }
    
        $('#catalog_filter').submit();
    });
    
    $('.category-filter input[type=checkbox]').on( "click", function () {
        $('#catalog_filter').submit();
    });
});
JS;

$this->registerJs($script);
