<?php

use yii\helpers\{
    Html, Url
};
use yii\data\Pagination;
//
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{
    Sale, SaleLang
};
use frontend\modules\catalog\widgets\product\ViewedProducts;

/**
 * @var $pages Pagination
 * @var $model Sale
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page category-page">
        <div class="container-wrap">
            <div class="container large-container">
                <div class="row">

                    <?= Html::tag('h1', (Yii::$app->metatag->seo_h1 != '')
                        ? Yii::$app->metatag->seo_h1
                        : Yii::t('app', 'Распродажа итальянской мебели')); ?>

                    <?= Breadcrumbs::widget([
                        'links' => $this->context->breadcrumbs,
                    ]) ?>

                </div>
                <div class="cat-content">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 ajax-get-filter"></div>
                        <div class="col-md-9 col-lg-9">
                            <div class="cont-area">

                                <div class="cat-prod-wrap">
                                    <div class="cat-prod">

                                        <?php
                                        if (!empty($models)) {
                                            foreach ($models as $model) {
                                                echo $this->render('_list_item', ['model' => $model]);
                                            }
                                        } else {
                                            echo '<p>' . Yii::t('app', 'Не найдено') . '</p>';
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

                    <div class="row">
                        <div class="comp-advanteges">
                            <?= Yii::$app->metatag->seo_content ?>
                        </div>
                    </div>

                    <?= ViewedProducts::widget([
                        'modelClass' => Sale::class,
                        'modelLangClass' => SaleLang::class,
                        'cookieName' => 'viewed_sale'
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</main>

<?php

$url = Url::to(['/catalog/sale/ajax-get-filter']);
$queryParams = json_encode(Yii::$app->catalogFilter->params);

$script = <<<JS
$.post('$url', {_csrf: $('#token').val(), catalogFilterParams:$queryParams}, function(data) {
    $('.ajax-get-filter').html(data.html);
    
    setTimeout(function() {
      rangeInit();
    }, 300);
    runDesctop();
    selectFirstFEl();
    
    $('.submit_price').on('click', function () {
        let link = $('input[name="price[link]"]').val(),
            min = $('input[name="price[min]"]').val(),
            max = $('input[name="price[max]"]').val();
        
        link = link.replace('{priceMin}', min);
        link = link.replace('{priceMax}', max);
    
        window.location.href = link;
    });
    
    $('.category-filter label').on('click', function () {
        var checkbox = $(this).parent().find('input[type=checkbox]');  
       
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
