<?php

use yii\helpers\Html;
//
use frontend\modules\articles\models\Article;

/** @var $model Article */

$this->title = $model['lang']['title'];
$this->context->breadcrumbs[] = $this->title;
?>
<div class="myarredo-blog-wrap">
    <div class="myarredo-blogbox">
        <div class="myarredo-blogartbox">

            <!-- Контент старт -->
            <div class="single-articlebox">
                <div class="article-title"><?= $model['lang']['title'] ?></div>
                <article class="article-textbox">
                    <?= $model['lang']['content'] ?>
                </article>
            </div>
            <!-- Контент конец -->

            <!-- Сайдбар старт -->
            <div class="article-assidebox">
                <div class="article-asside">
                    <div class="article-asside-title">Популярные новости</div>
                    <div class="article-asside-artbox">

                        <!-- item -->
                        <div class="article-asside-item">
                            <div class="article-item-box">
                                <a class="article-item-imglink" href="/articles/test3/">
                                    <div class="article-item-img"><img src="/uploads/articles/5cdaa5c386636.jpg" alt=""></div>
                                </a>
                                <div class="article-item-descr">
                                    <div class="article-item-title">
                                        Делать мебель дома - не лучшее решение для спины
                                    </div>
                                    <div class="article-item-shortdescr">
                                        Некоторые люди пытаються дома самостоятельно делать мебель, и на это не только больно смотреть - но это и опасно для самого мастера, а также для людей что будут
                                        использовать потом эту мебель
                                    </div>
                                    <div class="panel-article-item">
                                        <a class="btn-aricle-more" href="/articles/test3/">Подробнее</a>
                                        <div class="article-item-data">
                                            <i class="fa fa-calendar" aria-hidden="true"></i> 14.05.2019                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- item -->
                        <div class="article-asside-item">
                            <div class="article-item-box">
                                <a class="article-item-imglink" href="/articles/test5/">
                                    <div class="article-item-img"><img src="/uploads/articles/5cdac3ae50a7a.png" alt=""></div>
                                </a>
                                <div class="article-item-descr">
                                    <div class="article-item-title">Международная выставка  мебели IMM Cologne 2018</div>
                                    <div class="article-item-shortdescr">Кресло с мягкими подлокотниками, расположенными на одном уровне со спинкой представлено итальянской фабрикой Il Loft в коллекции Armchairs.</div>
                                    <div class="panel-article-item">

                                        <a class="btn-aricle-more" href="/articles/test5/">Подробнее</a>
                                        <div class="article-item-data">
                                            <i class="fa fa-calendar" aria-hidden="true"></i> 14.05.2019 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Сайдбар конец -->

            <!-- Похожие статьи старт -->
            <div class="article-similarbox">
                <div class="article-similar-hr"></div>
                <div class="article-similar">

                    <!-- item -->
                    <div class="article-similar-item">
                        <div class="article-item-box">
                            <a class="article-item-imglink" href="/articles/test3/">
                                <div class="article-item-img"><img src="/uploads/articles/5cdaa5c386636.jpg" alt=""></div>
                            </a>
                            <div class="article-item-descr">
                                <div class="article-item-title">
                                    Делать мебель дома - не лучшее решение для спины
                                </div>
                                <div class="article-item-shortdescr">
                                    Некоторые люди пытаються дома самостоятельно делать мебель, и на это не только больно смотреть - но это и опасно для самого мастера, а также для людей что будут
                                    использовать потом эту мебель
                                </div>
                                <div class="panel-article-item">
                                    <a class="btn-aricle-more" href="/articles/test3/">Подробнее</a>
                                    <div class="article-item-data">
                                        <i class="fa fa-calendar" aria-hidden="true"></i> 14.05.2019                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- item -->
                    <div class="article-similar-item">
                        <div class="article-item-box">
                            <a class="article-item-imglink" href="/articles/test5/">
                                <div class="article-item-img"><img src="/uploads/articles/5cdac3ae50a7a.png" alt=""></div>
                            </a>
                            <div class="article-item-descr">
                                <div class="article-item-title">Международная выставка  мебели IMM Cologne 2018</div>
                                <div class="article-item-shortdescr">Кресло с мягкими подлокотниками, расположенными на одном уровне со спинкой представлено итальянской фабрикой Il Loft в коллекции Armchairs.</div>
                                <div class="panel-article-item">

                                    <a class="btn-aricle-more" href="/articles/test5/">Подробнее</a>
                                    <div class="article-item-data">
                                        <i class="fa fa-calendar" aria-hidden="true"></i> 14.05.2019 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- item -->
                    <div class="article-similar-item">
                        <div class="article-item-box">
                            <a class="article-item-imglink" href="/articles/test3/">
                                <div class="article-item-img"><img src="/uploads/articles/5cdaa5c386636.jpg" alt=""></div>
                            </a>
                            <div class="article-item-descr">
                                <div class="article-item-title">
                                    Делать мебель дома - не лучшее решение для спины
                                </div>
                                <div class="article-item-shortdescr">
                                    Некоторые люди пытаються дома самостоятельно делать мебель, и на это не только больно смотреть - но это и опасно для самого мастера, а также для людей что будут
                                    использовать потом эту мебель
                                </div>
                                <div class="panel-article-item">
                                    <a class="btn-aricle-more" href="/articles/test3/">Подробнее</a>
                                    <div class="article-item-data">
                                        <i class="fa fa-calendar" aria-hidden="true"></i> 14.05.2019                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- item -->
                    <div class="article-similar-item">
                        <div class="article-item-box">
                            <a class="article-item-imglink" href="/articles/test5/">
                                <div class="article-item-img"><img src="/uploads/articles/5cdac3ae50a7a.png" alt=""></div>
                            </a>
                            <div class="article-item-descr">
                                <div class="article-item-title">Международная выставка  мебели IMM Cologne 2018</div>
                                <div class="article-item-shortdescr">Кресло с мягкими подлокотниками, расположенными на одном уровне со спинкой представлено итальянской фабрикой Il Loft в коллекции Armchairs.</div>
                                <div class="panel-article-item">

                                    <a class="btn-aricle-more" href="/articles/test5/">Подробнее</a>
                                    <div class="article-item-data">
                                        <i class="fa fa-calendar" aria-hidden="true"></i> 14.05.2019 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Похожие статьи конец -->

        </div>
    </div>
</div>