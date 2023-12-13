<?php

use yii\helpers\Html;
use frontend\modules\banner\models\BannerItem;
use frontend\modules\catalog\widgets\filter\ProductFilterOnMainPage;

/**
 * @var $model BannerItem
 * @var $filterItem array
 * @var $type string
 */

$presentData = [];
$firstFrameLink = '';
$firstFrameSrc = '';

if ($filterItem) {
    $firstFrameLink = $filterItem['lang']['link'] ?? '';
    $firstFrameSrc = $filterItem->getImageThumb();

    ?>
    <div class="top-home-img" style="background-image: url(<?= $filterItem->getImageLink() ?>)">
        <?= ProductFilterOnMainPage::widget(['model' => $filterItem]); ?>
    </div>
<?php } elseif (!empty($items)) {
    foreach ($items as $model) {
        $presentData[] = [
            'langLink' => $model['lang']['link'] ?? '',
            'langDescr' => $model['lang']['description'] ? str_replace('<br>', ' ', $model['lang']['description']) : '',
            'imgLinkDsktp' => $model->getImageLink(),
            'imgLinkMob' => $model->getImageThumb()
        ];

        $firstFrameLink = $model['lang']['link'] ?? '';
        $firstFrameSrc = $model->getImageLink();
        $firstFrameDescr = $model['lang']['description'] ? str_replace('<br>', ' ', $model['lang']['description']) : '';

        Yii::$app->view->registerLinkTag([
            'rel' => 'preload',
            'href' => $model->getImageLink().'?v=1.0',
            'as' => 'image',
            'media' => '(min-width: 601px)',
        ]);
    } ?>
    <div class="home-top-slider">
        <div class="img-cont">
            <a href="<?= $firstFrameLink; ?>">
                <img width="1600" height="560" src="<?= $firstFrameSrc; ?>" alt="<?= $firstFrameDescr ?>">
            </a>
        </div>
    </div>
<?php } elseif ($type == 'main') { ?>
    <div class="top-home-img">
        <?= ProductFilterOnMainPage::widget(); ?>
    </div>
<?php }

$prsData = json_encode($presentData);
$csToken = Yii::$app->getRequest()->csrfToken;
$script = <<< JS
console.time('speed banner loader js');
// Рендерим слайдер с картинками нужного размера
var presData =  $prsData;
var homeTopSlider = $('.home-top-slider');

if (homeTopSlider.length == 0) {
    return false;
}

// функция для рендера и инициализации слайдера
function renderSlider(data) {

    // variables
    var layut = '';
    var winWidth = window.screen.width;
    var link = '';

    // генерим верстку из полученого JSON массива
    $(data).each(function(i, elem) {
        winWidth > 460 ? link = elem.imgLinkDsktp : link = elem.imgLinkMob;
        layut += '<div class="img-cont">';

        if (elem.langLink != '') {
            layut += '<a href="'+ elem.langLink +'">' +
                    '<img width="1600" height="560" src="'+ link +'?v=1.0" alt="'+ elem.langDescr +'">' +
                '</a>';
        }
        else {
            layut += '<img width="1600" height="560" src="'+ link +'?v=1.0" alt="'+ elem.langDescr +'">';
        }
        if (elem.langDescr != '') {
            layut += '<span>'+ elem.langDescr +'</span>';
        }

        layut += '</div>';
    });

    // Ложим верстку в слайдер на странице
    homeTopSlider.html(layut);

    // Инициализируем Slick слайдер
    setTimeout(function() {
        homeTopSlider.slick({
            autoplay: true,
            dots: true,
            arrows: true,
            fade: true,
            cssEase: 'linear',
            autoplaySpeed: 3000
        });
    },100);
}

// Default init
(function() {
    renderSlider(presData);
})();

// $.ajax({
//     type: 'POST',
//     data: {
//         '_csrf': '$csToken',
//         'action': 'getPresent'
//     },
//     success: function(resp) {
//         console.log(resp);
//     },
//     error: function(err) {
//         console.log(err.statusText);
//     }
// });

console.timeEnd('speed banner loader js');
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>
