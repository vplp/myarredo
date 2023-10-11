<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\{
    Product, Factory
};

/**
 * @var $pages \yii\data\Pagination
 * @var $model Product
 * @var $factory Factory
 * @var $models Product[]
 */

$this->title = $this->context->title;
$keys = Yii::$app->catalogFilter->keys;
$params = Yii::$app->catalogFilter->params;

?>

    <main>
        <div class="page category-page">
            <div class="container large-container">
                <div class="cat-content">
                    <div class="row">

                        <div class="col-md-3 col-lg-3 js-filter-modal ajax-get-filter"></div>

                        <div class="col-md-9 col-lg-9">
                            <div class="cont-area">
                                <div class="cat-prod-wrap">
                                    <div class="cat-prod">

                                        <?php foreach ($models as $model) {
                                            echo $this->render('/category/_list_item', [
                                                'model' => $model
                                            ]);
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
                </div>
            </div>
        </div>
    </main>

<?php
$queryParams = json_encode(Yii::$app->catalogFilter->params);
$url = Url::toRoute('/catalog/template-factory/ajax-get-filter');
$url2 = Url::toRoute('/catalog/template-factory/ajax-get-filter-sizes');
$link = '/factory/' . $factory['alias'] . '/catalog';
$script = <<<JS
$.post('$url', {
        _csrf: $('#token').val(),
        catalogFilterParams: $queryParams,
        link: '$link'
    }, function(data) {
    $('.ajax-get-filter').html(data.html);
    
    setTimeout(function() {
        $.post('$url2', {
                _csrf: $('#token').val(),
                catalogFilterParams:$queryParams,
                link: '$link'
            }, function(data) {
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
