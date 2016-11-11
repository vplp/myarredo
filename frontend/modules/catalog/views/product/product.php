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

<section class="catalog">
    <div class="container cf">
        <div class="section_t">
            <nav class="breadcrumbs">

                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs
                ])
                ?>

            </nav>
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
        <div class="catalog_cnt">
            <div class="catalog_cnt_b cf">
                <div class="catalog_cnt_b_l">

                    <?= Menu::widget([
                        'view' => 'catalog_menu'
                    ]) ?>

                </div>
                <div class="catalog_cnt_b_r">
                    <div class="good cf">
                        <div class="good_l">
                            <div class="good_img">
                                <?php if ($model->getImageLink()): ?>
                                    <img src="<?= $model->getImageLink() ?>" class="good_img_i" data-large="<?= $model->getImageLink() ?>" data-title="<?= $model['lang']['title'] ?>" data-help="<?= $model['lang']['title'] ?>" title="<?= $model['lang']['title'] ?>">
                                <?php endif; ?>
                            </div>
                            <div class="good_b">
                                <div class="good_b_t cf">
                                    <div class="good_b_l">
                                        <a id="good_zoom" class="good_zoom" href="#"></a>
                                    </div>
                                    <div class="good_b_r">
                                        <a href="#" class="good_liked" data-id=""></a>
                                    </div>
                                </div>
                                <div class="good_b_b">
                                    <button class="card-buy button-green">
                                        <i></i>
                                        <span>Купить</span>
                                    </button>
                                    <div class="good_not-available">
                                        <span>Нет в наличии</span>
                                    </div>
                                    <a href="Google-Maps-cheet-sheet.pdf" class="good_instructions good_btn" target="_blank">
                                        <i></i>
                                        <span>Инструкция по применению</span>
                                    </a>
                                    <a href="Google-Maps-cheet-sheet.pdf" class="good_certificate good_btn" target="_blank">
                                        <i></i>
                                        <span>Сертификат на продукцию</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="good_r">
                            <h2 class="good_t"><?= $model['lang']['title'] ?></h2>
                            <div class="good_tx">
                                <?= $model['lang']['content'] ?>
                            </div>
                            <div class="good_descr">
                                <table>
                                    <tr class="packaging">
                                        <td>Упаковка:</td>
                                        <td>
                                            <div class="value">100 мл</div>
                                        </td>
                                    </tr>
                                    <tr class="price">
                                        <td>Цена:</td>
                                        <td>
                                            <div class="value"><?= $model['price_of_retail'] ?> <span>грн</span></div>
                                        </td>
                                    </tr>
                                    <tr class="price_for_members">
                                        <td>Цена для членов клуба:</td>
                                        <td>
                                            <div class="value"><?= $model['price_for_members'] ?> <span>грн</span></div>
                                        </td>
                                    </tr>
                                    <tr class="addition">
                                        <td>Входит в программу:</td>
                                        <td>
                                            <div class="value">Очищение лица</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="good_tabs">
            <ul class="good_tabs_lks cf">
                <li class="good_tabs_lk_active good_tabs_lk" data-section="#section-1">
                    <div class="good_tabs_i">
                        <a href="#">Применение</a>
                    </div>
                </li>
                <li class="good_tabs_lk" data-section="#section-2">
                    <div class="good_tabs_i">
                        <a href="#">Преимущества</a>
                    </div>
                </li>
                <li class="good_tabs_lk" data-section="#section-3">
                    <div class="good_tabs_i">
                        <a href="#">Отзывы</a>
                    </div>
                </li>
                <li class="good_tabs_lk" data-section="#section-4">
                    <div class="good_tabs_i">
                        <a href="#">Статьи</a>
                    </div>
                </li>
                <li class="good_tabs_lk" data-section="#section-5">
                    <div class="good_tabs_i">
                        <a href="#">Видео</a>
                    </div>
                </li>
            </ul>
            <div class="good_tabs_cnt">
                <div class="good_tabs_section_cnt">
                    <div id="section-1" class="good_tabs_section active">
                        <?= $model['lang']['application'] ?>
                    </div>
                </div>
                <div class="good_tabs_section_cnt">
                    <div id="section-2" class="good_tabs_section">
                        <?= $model['lang']['advantages'] ?>
                    </div>
                </div>
                <div class="good_tabs_section_cnt">
                    <div id="section-3" class="good_tabs_section">
                        Отзывы
                    </div>
                </div>
                <div class="good_tabs_section_cnt">
                    <div id="section-4" class="good_tabs_section">
                        Статьи
                    </div>
                </div>
                <div class="good_tabs_section_cnt">
                    <div id="section-5" class="good_tabs_section">
                        <iframe width="417" height="235" src="https://www.youtube.com/embed/Ed8Sia9Bcx8" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
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