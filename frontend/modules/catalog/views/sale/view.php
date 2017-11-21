<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\Factory;

?>

<main>
    <div class="page sale-page">
        <div class="container large-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex s-between c-align top-links">

                        <?php if ($model['factory']): ?>
                            <?= Html::a(
                                $model['factory']['lang']['title'],
                                Factory::getUrl($model['factory']['alias']),
                                ['class' => 'brand']
                            ); ?>
                        <?php endif; ?>

                        <a href="#" class="back">
                            Вернуться к списку
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h1><?= $model->getTitle() ?></h1>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-5">
                    <div class="img-wrap">
                        <a href="javascript:void(0);" class="img-cont">
                            <?= Html::img($model->getImage()); ?>
                        </a>
                        <a href="javascript:void(0);" class="zoom">
                            Увеличить
                            <i class="fa fa-search-plus" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7">
                    <div class="prod-info">
                        <div class="prod-style">
                            <span>Стиль: </span>
                            <a href="#">
                                Современный
                            </a>
                        </div>
                        <div class="prod-price">
                            <div class="price">
                                2172 EUR
                            </div>
                            <div class="old-price">
                                (старая цена - <b>4 334  EUR</b>)
                            </div>
                        </div>
                        <div class="prod-shortstory">
                            Стол обеденный с столешницей из натурального мрамора и ногами в шпоне ореха.
                        </div>
                        <table class="infotable" width="100%">
                            <tr>
                                <td>
                                    Размеры
                                </td>
                                <td>
                                    L:2200
                                </td>
                                <td>
                                    DP:1100
                                </td>
                                <td>
                                    H:740
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Материал
                                </td>
                                <td colspan="3">
                                    Мрамор
                                </td>
                            </tr>
                        </table>
                        <div class="seller-cont">
                            <h4>Контакты продавца</h4>
                            <div class="title">
                                Салон "Sfera Design"
                            </div>
                            <a href="tel:+380442309379">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                +380 (44) 230-93-79
                            </a>
                            <div class="location">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                Украина - Киев </br>
                                бульвар Леси Украинки, 16
                            </div>
                            <a href="mailto:sferadesignkiev@gmail.com">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                sferadesignkiev@gmail.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>