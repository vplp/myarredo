<?php

use yii\helpers\Html;

?>

<main>
    <div class="page factory-list-page">
        <div class="letter-nav">
            <div class="container large-container">
                <ul class="letter-select">
                    <li>
                        <a href="#">a</a>
                    </li>
                    <li>
                        <a href="#">b</a>
                    </li>
                    <li>
                        <a href="#">c</a>
                    </li>
                    <li>
                        <a href="#">d</a>
                    </li>
                    <li>
                        <a href="#">e</a>
                    </li>
                    <li>
                        <a href="#">f</a>
                    </li>
                    <li>
                        <a href="#">g</a>
                    </li>
                    <li>
                        <a href="#">h</a>
                    </li>
                    <li>
                        <a href="#">i</a>
                    </li>
                    <li>
                        <a href="#">j</a>
                    </li>
                    <li>
                        <a href="#">k</a>
                    </li>
                    <li>
                        <a href="#">l</a>
                    </li>
                    <li>
                        <a href="#">m</a>
                    </li>
                    <li>
                        <a href="#">n</a>
                    </li>
                    <li>
                        <a href="#">o</a>
                    </li>
                    <li>
                        <a href="#">p</a>
                    </li>
                    <li>
                        <a href="#">r</a>
                    </li>
                    <li>
                        <a href="#">s</a>
                    </li>
                    <li>
                        <a href="#">t</a>
                    </li>
                    <li>
                        <a href="#">u</a>
                    </li>
                    <li>
                        <a href="#">v</a>
                    </li>
                    <li>
                        <a href="#">w</a>
                    </li>
                    <li>
                        <a href="#">x</a>
                    </li>
                    <li>
                        <a href="#">y</a>
                    </li>
                    <li>
                        <a href="#">z</a>
                    </li>
                </ul>
                <a href="#" class="all">
                    Все
                </a>
            </div>
        </div>
        <div class="container large-container">
            <div class="title-mark">
                <h1 class="title-text">
                    Итальянские фабрики мебели - производители из Италии
                </h1>
                <span>
                    (282  фабрик представлено в нашем каталоге)
                </span>
                <div class="view-but">
                    <a href="#" class="tiles4 flex active">
                        <i></i><i></i><i></i><i></i>
                        <i></i><i></i><i></i><i></i>
                    </a>
                    <a href="#" class="tiles2 flex">
                        <i></i><i></i>
                    </a>
                </div>
            </div>

            <div class="factory-tiles flex">

                <?php foreach ($models as $model): ?>
                    <?= $this->render('_list_item', ['model' => $model]) ?>
                <?php endforeach; ?>
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
</main>