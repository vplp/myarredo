<?php

use yii\helpers\Html;

/**
 * @var $promotions array
 * @var $products array
 */

if (!empty($products) || !empty($promotions)) { ?>
    <div class="rec-slider-wrap novetly-sliderbox">
        <div class="container large-container">
            <div class="row">
                <div class="std-slider novoslider" id="rec-slider"></div>
            </div>
        </div>
    </div>
<?php } ?>

<?php
$bestsellertext = Yii::t('app', 'Bestseller');
$script = <<< JS
console.time('speed novetly slider js');

var sliderData = $sliderData;
var bestselerText = "$bestsellertext";

var sliderLayout = '';

if (window.screen.width >= 768) {
    sliderData.forEach(function(elem, i) {
        var bestseler = elem.bestseller ? '<div class="prod-bestseller">'+ bestselerText +'</div>' : '';

        sliderLayout += '' +
        '<div class="item" data-dominant-color>' +
            '<a class="tile" href="'+ elem.href +'" target="_blank">' +
                bestseler +
                '<div class="prod-saving-percentage">'+ elem.percent +'</div>' +
                '<div class="img-cont">' +
                    '<img src="'+ elem.src +'" loading="lazy" alt="">' +
                    '<span class="background"></span>' +
                '</div>' +
                '<div class="add-item-text">' +
                    elem.text +
                '</div>' +
            '</a>' +
        '</div>';
    });

    $('.novoslider').html(sliderLayout);
}

console.timeEnd('speed novetly slider js');
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>
