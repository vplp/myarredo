<?php

use yii\helpers\{
    Html, Url
};

?>

    <div class="flex basket-items">
        <?php
        foreach ($items as $item) {
            echo $this->render(
                'parts/item_of_cart',
                ['item' => $item, 'product' => $products[$item['product_id']] ?? []]
            );
        } ?>
    </div>

<?php
if (count($items) > 3) {
    echo Html::button('Показать все', ['class' => 'btn btn-default show-all']);
}

$script = <<< JS
    $('.basket-item-info').on('click', '.remove', function() {
        window.location.reload();
    });
JS;
$this->registerJs($script);
