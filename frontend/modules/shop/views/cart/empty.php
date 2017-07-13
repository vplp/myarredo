<?php

/**
 * @author Alla Kuzmenko
 * @copyright (c) 2016, Thread
 */
?>
<div>
    <?php
    echo Yii::$app->getSession()->getFlash('SEND_ORDER');

    if (Yii::$app->getSession()->getFlash('SEND_ORDER') !== null):
        echo '<br>' . Yii::$app->getSession()->getFlash('SEND_ORDER') . '<br>';
    endif;    
    ?>
    Вы еще не добавили в заказ товаров.
    <br>
    <br>
</div>
