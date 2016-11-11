<?php

use frontend\modules\catalog\widgets\menu\Menu;
//
use yii\widgets\Breadcrumbs;

/**
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */

$this->title = $this->context->title;

?>

<section class="catalog catalog_page">
    <div class="container cf">
        <nav class="breadcrumbs">

            <?= Breadcrumbs::widget([
                'links' => $this->context->breadcrumbs
            ])
            ?>

        </nav>
        <div class="catalog_cnt">
            <div class="catalog_cnt_t cf">
                <div class="catalog_cnt_t_l">
                    <h2 class="catalog_t"><?= $this->context->title ?></h2>
                </div>
                <div class="catalog_cnt_t_r">
                    <div class="filter-by-type">
                        <div class="filter-by-type_t">Сортировать:</div>
                        <div id="filter-select" class="filter-select">
                            <select class="filter-by-type_sel">
                                <option value="" disabled selected data-placeholder="true">Сортировать</option>
                                <option value="От дешевых к дорогим">От дешевых к дорогим</option>
                                <option value="От дорогих к дешевым">От дорогих к дешевым</option>
                                <option value="По алфавиту">По алфавиту</option>
                                <option value="По рейтингу">По рейтингу</option>
                            </select>
                        </div>
                    </div>
                    <div class="filter-by-cat">
                        <div class="filter-by-cat_t">
                            <span>Каталог</span>
                            <label>
                                <i></i>
                            </label>
                        </div>
                        <div class="filter-by-cat_menu">
                            <ul>
                                <li class="level">
                                    <a href="#">Продукция</a>
                                    <ul class="filter-by-cat_submenu">
                                        <li class="level2">
                                            <a href="#">Красота</a>
                                        </li>
                                        <li class="level2">
                                            <a href="#">Здоровье</a>
                                        </li>
                                        <li class="level2">
                                            <a href="#">Питание</a>
                                        </li>
                                        <li class="level2">
                                            <a href="#">Фитокомплексы</a>
                                        </li>
                                        <li class="level2">
                                            <a href="#">Безопасный дом</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="level">
                                    <a href="#">Программы и комплексы</a>
                                    <ul class="filter-by-cat_submenu">
                                        <li class="level2">
                                            <a href="#">Красота</a>
                                        </li>
                                        <li class="level2">
                                            <a href="#">Здоровье</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="level">
                                    <a href="#">Проблемы</a>
                                    <ul class="filter-by-cat_submenu">
                                        <li class="level2">
                                            <a href="#">Красота</a>
                                        </li>
                                        <li class="level2">
                                            <a href="#">Здоровье</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="level">
                                    <a href="#">Бренды</a>
                                    <ul class="filter-by-cat_submenu">
                                        <li class="level2">
                                            <a href="#">Красота</a>
                                        </li>
                                        <li class="level2">
                                            <a href="#">Здоровье</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="catalog_cnt_b cf">
                <div class="catalog_cnt_b_l">

                    <?= Menu::widget([
                        'view' => 'catalog_menu'
                    ]) ?>

                </div>
                <div id="itemContainer" class="catalog_cnt_b_r cf">

                    <?php foreach ($models as $product): ?>
                        <?= $this->render('_product', ['product' => $product]) ?>
                    <?php endforeach; ?>

                </div>

                <div class="pages">
                    <?=
                    yii\widgets\LinkPager::widget([
                        'pagination' => $pages,
                        'registerLinkTags' => true,
                    ]);
                    ?>
                </div>

                <div class="catalog_holder"></div>
            </div>
        </div>
    </div>
</section>
<section class="bargain">
    <div class="container cf">
        <h3 class="bargain_t">Выгодная покупка</h3>
        <div class="bargain_cnt cf">
            <div class="bargain_i">
                <div class="bargain_i_l">
                    <div class="bargain_i_img">
                        <img src="images/goods/4.jpg" alt="">
                    </div>
                </div>
                <div class="bargain_i_r">
                    <div class="bargain_i_t">РАСТВОР АНКАРЦИН OPTIMUM</div>
                    <div class="bargain_i_tx">Повышает защитные силы организма при стрессах...</div>
                    <div class="bargain_i_price">122.00<span>грн</span></div>
                    <button class="bargain_i_buy button-green">
                        <i></i>
                        <span>Купить</span>
                    </button>
                </div>
            </div>
            <div class="bargain_i">
                <div class="bargain_i_l">
                    <div class="bargain_i_img">
                        <img src="images/goods/1.jpg" alt="">
                    </div>
                </div>
                <div class="bargain_i_r">
                    <div class="bargain_i_t">РАСТВОР АНКАРЦИН OPTIMUM</div>
                    <div class="bargain_i_tx">Повышает защитные силы организма при стрессах...</div>
                    <div class="bargain_i_price">122.00<span>грн</span></div>
                    <button class="bargain_i_buy button-green">
                        <i></i>
                        <span>Купить</span>
                    </button>
                </div>
            </div>
            <div class="bargain_i">
                <div class="bargain_i_l">
                    <div class="bargain_i_img">
                        <img src="images/goods/2.jpg" alt="">
                    </div>
                </div>
                <div class="bargain_i_r">
                    <div class="bargain_i_t">РАСТВОР АНКАРЦИН OPTIMUM</div>
                    <div class="bargain_i_tx">Повышает защитные силы организма при стрессах...</div>
                    <div class="bargain_i_price">122.00<span>грн</span></div>
                    <button class="bargain_i_buy button-green">
                        <i></i>
                        <span>Купить</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

