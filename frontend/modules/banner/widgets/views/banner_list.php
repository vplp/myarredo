<?php

use yii\helpers\Html;
use frontend\modules\banner\models\BannerItem;
use frontend\modules\catalog\widgets\filter\ProductFilterOnMainPage;

/**
 * @var $model BannerItem
 */
$presentData = array();
$firstFrameLink = '';
$firstFrameSrc = '';
if (!empty($items)) { ?>
    <?php foreach ($items as $model) {
        $presentData[] = array(
            'langLink' => $model['lang']['link'] ?? '',
            'langDescr' => $model['lang']['description'] ?? '',
            'imgLinkDsktp' => $model->getImageLink(),
            'imgLinkMob' => $model->getImageThumb()
        );
        $firstFrameLink = $model['lang']['link'] ?? '';
        $firstFrameSrc = $model->getImageThumb();
    } ?>
    <div class="home-top-slider">
        <div class="img-cont">
            <a href="<?= $firstFrameLink; ?>">
                <img src="<?= $firstFrameSrc; ?>" alt="">
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
                    '<img src="'+ link +'" alt="">' +
                '</a>';
        }
        else {
            layut += '<img src="'+ link +'" alt="">';
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
