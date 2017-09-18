<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\widgets\menu\CatalogMenu;

?>

<header>
    <?php if ((Yii::$app->getUser()->isGuest)): ?>
        <div class="city-select-cont">
            <div class="container large-container">
                <div class="row">
                    <div class="top-panel">
                        <div class="top-panel-in">
                            <a href="javascript:void(0);" class="set-country">Россия</a>
                            <a href="javascript:void(0);" id="close-top">
                                <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="title-city">Ваш город</div>
                        <div class="tab-country-content">
                            <ul class="links-cont">
                                <li class="active">
                                    <a href="#">Москва</a>
                                </li>
                                <li>
                                    <a href="#">Санкт-Петербург</a>
                                </li>
                                <li>
                                    <a href="#">Альметьевск</a>
                                </li>
                                <li>
                                    <a href="#">Анапа</a>
                                </li>
                                <li>
                                    <a href="#">Архангельск</a>
                                </li>
                                <li>
                                    <a href="#">Барнаул</a>
                                </li>
                                <li>
                                    <a href="#">Белгород</a>
                                </li>
                                <li>
                                    <a href="#">Благовещенск</a>
                                </li>
                                <li>
                                    <a href="#">Брянск</a>
                                </li>
                                <li>
                                    <a href="#">Владивосток</a>
                                </li>
                                <li>
                                    <a href="#">Владикавказ</a>
                                </li>
                                <li>
                                    <a href="#">Владимир</a>
                                </li>
                                <li>
                                    <a href="#">Волгоград</a>
                                </li>
                                <li>
                                    <a href="#">Воронеж</a>
                                </li>
                                <li>
                                    <a href="#">Екатеринбург</a>
                                </li>
                                <li>
                                    <a href="#">Иваново</a>
                                </li>
                                <li>
                                    <a href="#">Ижевск</a>
                                </li>
                                <li>
                                    <a href="#">Иркутск</a>
                                </li>
                                <li>
                                    <a href="#">Казань</a>
                                </li>
                                <li>
                                    <a href="#">Калининград</a>
                                </li>
                                <li>
                                    <a href="#">Калуга</a>
                                </li>
                                <li>
                                    <a href="#">Кемерово</a>
                                </li>
                                <li>
                                    <a href="#">Киров</a>
                                </li>
                                <li>
                                    <a href="#">Кострома</a>
                                </li>
                                <li>
                                    <a href="#">Краснодар</a>
                                </li>
                                <li>
                                    <a href="#">Курск</a>
                                </li>
                                <li>
                                    <a href="#">Магнитогорск</a>
                                </li>
                                <li>
                                    <a href="#">Махачкала</a>
                                </li>
                                <li>
                                    <a href="#">Мурманск</a>
                                </li>
                                <li>
                                    <a href="#">Набережные челны</a>
                                </li>
                                <li>
                                    <a href="#">Нальчик</a>
                                </li>
                                <li>
                                    <a href="#">Нижничй Новгород</a>
                                </li>
                                <li>
                                    <a href="#">Новокузнецк</a>
                                </li>
                                <li>
                                    <a href="#">Новороссийск</a>
                                </li>
                                <li>
                                    <a href="#">Новосибирск</a>
                                </li>
                                <li>
                                    <a href="#">Оренбург</a>
                                </li>
                                <li>
                                    <a href="#">Пенза</a>
                                </li>
                                <li>
                                    <a href="#">Перьм</a>
                                </li>
                                <li>
                                    <a href="#">Рязань</a>
                                </li>
                                <li>
                                    <a href="#">Ростов-на-Дону</a>
                                </li>
                                <li>
                                    <a href="#">Самара</a>
                                </li>
                                <li>
                                    <a href="#">Саратов</a>
                                </li>
                                <li>
                                    <a href="#">Смоленск</a>
                                </li>
                                <li>
                                    <a href="#">Сочи</a>
                                </li>
                                <li>
                                    <a href="#">Ставрополь</a>
                                </li>
                                <li>
                                    <a href="#">Таганрог</a>
                                </li>
                                <li>
                                    <a href="#">Тамбов</a>
                                </li>
                                <li>
                                    <a href="#">Тверь</a>
                                </li>
                                <li>
                                    <a href="#">Тольятти</a>
                                </li>
                                <li>
                                    <a href="#">Томск</a>
                                </li>
                                <li>
                                    <a href="#">Тула</a>
                                </li>
                                <li>
                                    <a href="#">Тюмень</a>
                                </li>
                                <li>
                                    <a href="#">Ульяновск</a>
                                </li>
                                <li>
                                    <a href="#">Уфа</a>
                                </li>
                                <li>
                                    <a href="#">Хабаровск</a>
                                </li>
                                <li>
                                    <a href="#">Чебоксары</a>
                                </li>
                                <li>
                                    <a href="#">Челябинск</a>
                                </li>
                                <li>
                                    <a href="#">Южно-Сахалинск</a>
                                </li>
                                <li>
                                    <a href="#">Ярославль</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="top-navbar">
            <div class="container large-container">
                <ul class="nav navbar-nav top-panel flex">
                    <li class="tel-num">
						<span>
							<i class="glyphicon glyphicon-earphone"></i> +7 (844) 297-45-97
						</span>
                    </li>
                    <li>
                        <a class="callback-trigger" href="javascript:void(0);">
							<span>
								Обратный звонок
							</span>
                        </a>
                    </li>
                    <li class="geo">
                        <a href="javascript: void(0);" id="select-city">
                            <i class="glyphicon glyphicon-map-marker"></i>
                            <span class="country">
								Россия
							</span>
                            <span class="city">
								Москва
							</span>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" class="my-notebook">
							<span class="red-but">
								<i class="glyphicon glyphicon-book"></i>
							</span>
                            <span class="inscription">
								Мой блокнот
							</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    <?php else: ?>
        <div class="top-navbar">
            <div class="container large-container">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <div class="my-notebook dropdown">
                            <span class="red-but notebook-but dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                                Меню
                                <object>
                                    <ul class="dropdown-menu">
                                        <?php if (Yii::$app->getUser()->getIdentity()->group->role == 'partner'): ?>
                                            <li>
                                                <?= Html::a('Города', ['/user/profile/index']); ?>
                                            </li>
                                            <li>
                                                <?= Html::a('Распродажа', ['/user/profile/index']); ?>
                                            </li>
                                            <li>
                                                <?= Html::a('Заявки', ['/user/profile/index']); ?>
                                            </li>
                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <?= Html::a('Профиль', ['/user/profile/index']); ?>
                                            </li>
                                        <?php elseif (Yii::$app->getUser()->getIdentity()->group->role == 'factory'): ?>
                                            <li>
                                                <?= Html::a('Каталог', ['/user/profile/index']); ?>
                                            </li>
                                            <li>
                                                <?= Html::a('Коллекции', ['/user/profile/index']); ?>
                                            </li>
                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <?= Html::a('Профиль', ['/user/profile/index']); ?>
                                            </li>
                                        <?php else: ?>
                                            <li>
                                                <?= Html::a('Профиль', ['/user/profile/index']); ?>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </object>
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    <?php endif; ?>
    <nav class="navbar">
        <div class="container large-container">
            <a href="/" class="logo">
                <img src="<?= $bundle->baseUrl ?>/img/logo.png" alt="">
            </a>
            <?= CatalogMenu::widget([]); ?>
        </div>
    </nav>
</header>