<?php

use yii\helpers\Html;
use frontend\components\Breadcrumbs;

/**
 * @var \yii\data\Pagination $pages
 * @var \frontend\modules\catalog\models\Sale $model
 */

?>

<main>
    <div class="page category-page">
        <div class="container large-container">
            <div class="row">
                <?= Html::tag('h1', $this->context->title); ?>
                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                ]) ?>
            </div>
            <div class="cat-content">
                <div class="row">
                    <div class="col-md-3 col-lg-3">
                        <div class="filters">
                            <div class="one-filter open">
                                <a href="#" class="reset">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                    СБРОСИТЬ ФИЛЬТРЫ
                                </a>
                                <a href="javascript:void(0);" class="filt-but">
                                    Категории
                                </a>
                                <div class="list-item">
                                    <a href="#" class="one-item">
                                        Спальни (11579)
                                    </a>
                                    <a href="#" class="one-item">
                                        Кухни (962)
                                    </a>
                                    <a href="#" class="one-item">
                                        Столовые комнаты (13576)
                                    </a>
                                    <a href="#" class="one-item">
                                        Детская мебель (1564)
                                    </a>
                                    <a href="#" class="one-item">
                                        Мягкая мебель (12892)
                                    </a>
                                    <a href="#" class="one-item">
                                        Гостиные (19842)
                                    </a>
                                    <a href="#" class="one-item">
                                        Светильники (4445)
                                    </a>
                                    <a href="#" class="one-item">
                                        Стулья (5716)
                                    </a>
                                    <a href="#" class="one-item">
                                        Кабинеты (3243)
                                    </a>
                                    <a href="#" class="one-item">
                                        Прихожие (2530)
                                    </a>
                                    <a href="#" class="one-item">
                                        Двери (191)
                                    </a>
                                    <a href="#" class="one-item">
                                        Спальни (11579)
                                    </a>
                                    <a href="#" class="one-item">
                                        Кухни (962)
                                    </a>
                                    <a href="#" class="one-item">
                                        Столовые комнаты (13576)
                                    </a>
                                    <a href="#" class="one-item">
                                        Детская мебель (1564)
                                    </a>
                                    <a href="#" class="one-item">
                                        Мягкая мебель (12892)
                                    </a>
                                    <a href="#" class="one-item">
                                        Гостиные (19842)
                                    </a>
                                    <a href="#" class="one-item">
                                        Светильники (4445)
                                    </a>
                                    <a href="#" class="one-item">
                                        Стулья (5716)
                                    </a>
                                    <a href="#" class="one-item">
                                        Кабинеты (3243)
                                    </a>
                                    <a href="#" class="one-item">
                                        Прихожие (2530)
                                    </a>
                                    <a href="#" class="one-item">
                                        Двери (191)
                                    </a>
                                </div>
                            </div>

                            <div class="one-filter open">
                                <a href="javascript:void(0);" class="filt-but">
                                    Предмет
                                </a>
                                <div class="list-item">
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            Аксессуары (11579)
                                        </label>
                                    </a>
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            Банкетка (11579)
                                        </label>
                                    </a>
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            Бар (11579)
                                        </label>
                                    </a>
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            Буфет (11579)
                                        </label>
                                    </a>
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            Комод (11579)
                                        </label>
                                    </a>
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            Книжный шкаф (11579)
                                        </label>
                                    </a>
                                </div>
                            </div>

                            <div class="one-filter open">
                                <a href="javascript:void(0);" class="filt-but">
                                    Стиль
                                </a>
                                <div class="list-item">
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            Гламур (11579)
                                        </label>
                                    </a>
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            Арт-деко (11579)
                                        </label>
                                    </a>
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            Современный (11579)
                                        </label>
                                    </a>
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            Классический (11579)
                                        </label>
                                    </a>
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            Современный (11579)
                                        </label>
                                    </a>
                                </div>
                            </div>

                            <div class="one-filter open">
                                <a href="javascript:void(0);" class="filt-but">
                                    Фабрики
                                </a>
                                <div class="list-item">
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            A.R.ARREDAMENTI SRL (302)
                                        </label>
                                    </a>
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            ALBERTA SALOTTI (135)
                                        </label>
                                    </a>
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            ALF (65)
                                        </label>
                                    </a>
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            ALTA MODA (286)
                                        </label>
                                    </a>
                                    <a href="#" class="one-item-check">
                                        <label>
                                            <input type="checkbox">
                                            <div class="my-checkbox"></div>
                                            ALCHYMIA (134)
                                        </label>
                                    </a>
                                </div>
                            </div>

                            <div class="one-filter">
                                <div class="price-slider-cont">
                                    <a href="javascript:void(0);" class="filt-but">
                                        Цена
                                    </a>
                                    <div id="price-slider"></div>
                                    <div class="flex s-between" style="padding: 10px 0;">
                                        <div class="cur">
                                            <input type="text" id="min-price" value="100">
                                        </div>
                                        <span class="indent"> - </span>
                                        <div class="cur">
                                            <input type="text" id="max-price" value="10000">
                                        </div>
                                    </div>
                                    <a href="#" class="submit">
                                        OK
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-9 col-lg-9">
                        <div class="cont-area">

                            <div class="cat-prod-wrap">
                                <div class="cat-prod">

                                    <?php if (!empty($models)): ?>
                                        <?php foreach ($models as $model): ?>
                                            <?= $this->render('_list_item', ['model' => $model]) ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>Не найдено</p>
                                    <?php endif; ?>

                                </div>
                                <div class="pagi-wrap">

                                    <?=
                                    yii\widgets\LinkPager::widget([
                                        'pagination' => $pages,
                                        'registerLinkTags' => true,
                                        'nextPageLabel' => 'Далее<i class="fa fa-angle-right" aria-hidden="true"></i>',
                                        'prevPageLabel' => '<i class="fa fa-angle-left" aria-hidden="true"></i>Назад'
                                    ]);
                                    ?>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="comp-advanteges">

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
