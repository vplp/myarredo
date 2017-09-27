<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $item \frontend\modules\catalog\models\Product */
/* @var $product \frontend\modules\shop\models\CartItem */

?>

<p>Здравствуйте, <?= $order->customer['full_name'] ?></p>
<p>Ваш запрос №<?= $order['id'] ?> успешно принят.</p>
<p>Вам прийдут письма с ценами на предметы, которые Вас заинтересовали от разных поставщиков.</p>
<p>Вам нужно будет только выбрать лучшие условия для покупки.</p>
<p>Просчет занимает от 15 мнут до 1 рабочего дня.</p>

<p>Запрашиваемый товар(товары):</p>

<?php foreach ($order->items as $item): ?>
    <p>
        <?= Html::a($item->product['lang']['title'], Product::getUrl($item->product['alias'])) ?>
    </p>
<?php endforeach; ?>

<p>Для просмотра заказа пройдите по <a href="<?= $order->getTokenLink() ?>">ссылке</a>.</p>
