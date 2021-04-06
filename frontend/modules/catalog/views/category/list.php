<?php

use yii\helpers\{
    Html, Url
};
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{
    Product, ItalianProduct, ItalianProductLang, ProductLang, Collection, Sale, SaleLang
};
use frontend\modules\catalog\widgets\filter\{
    ProductSorting
};
use frontend\modules\catalog\widgets\category\CategoryOnMainPage;
use frontend\modules\catalog\widgets\paginator\PageChanger;
use frontend\modules\catalog\widgets\product\ViewedProducts;
use frontend\modules\catalog\widgets\product\NoveltyProducts;
use frontend\modules\articles\widgets\articles\ArticlesList;

/**
 * @var $pages \yii\data\Pagination
 * @var $model Product
 * @var $models Product[]
 * @var $bestsellers
 */

$this->title = $this->context->title;

$keys = Yii::$app->catalogFilter->keys;
$params = Yii::$app->catalogFilter->params;

$category_id = 0;

if (!empty($models)) {
    foreach ($models as $model) {
        $category_id = $model->category[0]->id;
    }
}

?>

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
                        } elseif (isset($params[$keys['collection']]) && count($params[$keys['collection']]) == 1) {
                            $collection = Collection::findByIdWithFactory($params[$keys['collection']]);
                            echo Html::a(
                                Yii::t('app', 'Перейти на страницу фабрики'),
                                ['/catalog/factory/view', 'alias' => $collection['factory']['alias']]
                            );
                        } ?>

                        <?= Breadcrumbs::widget([
                            'links' => $this->context->breadcrumbs,
                        ]) ?>

                    </div>

                    <?php if (in_array(DOMAIN_TYPE, ['ru', 'ua']) && (empty($params) || (count($params) == 1 && isset($params[$keys['category']])))) {
                        echo NoveltyProducts::widget([
                            'modelClass' => Sale::class,
                            'modelLangClass' => SaleLang::class,
                        ]);
                    } ?>

                    <?php if (empty($params)) { ?>
                        <div class="only-mob mobcat">
                            <?= CategoryOnMainPage::widget(); ?>
                        </div>
                    <?php } ?>

                    <div class="cat-content scroll-marker">
                        <?= Html::a(
                            Yii::t('app', 'Фильтры'),
                            'javascript:void(0);',
                            ['class' => 'js-filter-btn']
                        ) ?>
                        <div class="row-mob clearfix">
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
                                                    echo $this->render('_list_item', [
                                                        'model' => $model,
                                                        'bestsellers' => $bestsellers
                                                    ]);
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

                        <?php if (isset($params[$keys['category']])) {
                            echo ArticlesList::widget([
                                'view' => 'articles_on_main',
                                'limit' => 4,
                                'category_id' => $category_id,
                                'city_id' => Yii::$app->city->getCityId()
                            ]);
                        } ?>

                        <?= ViewedProducts::widget([
                            'modelClass' => Product::class,
                            'modelLangClass' => ProductLang::class,
                            'cookieName' => 'viewed_products'
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
    </main>

<?php

$queryParams = json_encode(Yii::$app->catalogFilter->params);
$url = Url::toRoute('/catalog/category/ajax-get-filter');
$url2 = Url::toRoute('/catalog/category/ajax-get-filter-sizes');
$link = '/catalog/category/list';

$script = <<<JS
$.post('$url', {_csrf: $('#token').val(), catalogFilterParams: $queryParams, link: '$link'}, function(data) {
    $('.ajax-get-filter').html(data.html);
    
    setTimeout(function() {
        $.post('$url2', {_csrf: $('#token').val(),catalogFilterParams:$queryParams,link: '$link'}, function(data) {
            $('<div class="one-filter">'+data.html+'</div>').insertAfter('.one-filter:eq(2)').addClass('filter-range-slider');

            setTimeout(function() {
                rangeInit();
            }, 500);
            runDesctop();
            selectFirstFEl();
            
            $('.submit_sizes').on('click', function () {
                let link = $('input[name="sizesLink"]').val(),
                diameterMin = $('input[name="diameter[min]"]'),
                diameterMax = $('input[name="diameter[max]"]'),
                widthMin = $('input[name="width[min]"]'),
                widthMax = $('input[name="width[max]"]'),
                lengthMin = $('input[name="length[min]"]'),
                lengthMax = $('input[name="length[max]"]'),
                heightMin = $('input[name="height[min]"]'),
                heightMax = $('input[name="height[max]"]'),
                apportionmentMin = $('input[name="apportionment[min]"]'),
                apportionmentMax = $('input[name="apportionment[max]"]');
            
                if (diameterMin.length && diameterMax.length &&
                    diameterMin.data('default') == diameterMin.val() && diameterMax.data('default') == diameterMax.val()) {
                    link = link.replace('={diameterMin}-{diameterMax}', '');
                } else if (diameterMin.length && diameterMax.length) {
                    link = link.replace('{diameterMin}', diameterMin.val());
                    link = link.replace('{diameterMax}', diameterMax.val());   
                }
            
                if (widthMin.length && widthMax.length &&
                    widthMin.data('default') == widthMin.val() && widthMax.data('default') == widthMax.val()) {
                    link = link.replace('={widthMin}-{widthMax}', '');
                } else if (widthMin.length && widthMax.length) {
                    link = link.replace('{widthMin}', widthMin.val());
                    link = link.replace('{widthMax}', widthMax.val());   
                }
                 
                if (lengthMin.length && lengthMax.length &&
                    lengthMin.data('default') == lengthMin.val() && lengthMax.data('default') == lengthMax.val()) {
                    link = link.replace('={lengthMin}-{lengthMax}', '');
                } else if (lengthMin.length && lengthMax.length) {
                    link = link.replace('{lengthMin}', lengthMin.val());
                    link = link.replace('{lengthMax}', lengthMax.val());   
                }
            
                if (heightMin.length && heightMax.length &&
                    heightMin.data('default') == heightMin.val() && heightMax.data('default') == heightMax.val()) {
                    console.log(heightMin.data('default'));
                    link = link.replace('={heightMin}-{heightMax}', '');
                } else if (heightMin.length && heightMax.length) {
                    link = link.replace('{heightMin}', heightMin.val());
                    link = link.replace('{heightMax}', heightMax.val());   
                }
                
                if (apportionmentMin.length && apportionmentMax.length &&
                    apportionmentMin.data('default') == apportionmentMin.val() && apportionmentMax.data('default') == apportionmentMax.val()) {
                    link = link.replace('={apportionmentMin}-{apportionmentMax}', '');
                } else if (apportionmentMin.length && apportionmentMax.length) {
                    link = link.replace('{apportionmentMin}', apportionmentMin.val());
                    link = link.replace('{apportionmentMax}', apportionmentMax.val());   
                }
            
                window.location.href = link;
            });
        });
    }, 1000);
    
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
