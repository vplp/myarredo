<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\modules\shop\modules\market\models\MarketOrder;

/* @var $this yii\web\View */

/* @var $model MarketOrder */

?>

<div style="width:100%;font-size:16px Arial,sans-serif;">
    <div style="background-color: #c4c0b8; padding:15px 0; text-align:center;">
        <table cellspacing="0" cellpadding="0" border="0" width="540" style="width:100%;">
            <tr>
                <td style="text-align:center;">
                    <div style="width:100%;text-align:center;">
                        <?= Html::img('https://www.myarredo.ru/uploads/mailer/logo_note.png') ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;">
                    <div style="width:100%;text-align:center;padding-top:8px;">
                        <span style="color: #fff; font:bold 16px Arial,sans-serif;">
                            <?= Yii::t('app', 'Мы помогаем купить мебель по лучшим ценам.') ?>
                        </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;font-size: 14px;">

        <?= Yii::$app->param->getByName('LETTER_NEW_MARKET_ORDER_PARTNER') ?>

        <?= Url::toRoute(['/shop/market/market-order-partner/list'], true) . '#' . $model->id ?>

    </div>

</div>
