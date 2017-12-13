<?php

/**
 * @var $pages \yii\data\Pagination
 * @var $model \frontend\modules\catalog\models\Product
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page category-page">
        <div class="container large-container">
            <div class="row">

            </div>
            <div class="cat-content">
                <div class="row">
                    <div class="col-md-3 col-lg-3">

                    </div>
                    <div class="col-md-9 col-lg-9">
                        <div class="cont-area">


       <form class="form-filter-date-cont flex">

           <div class="dropdown arr-drop">
               <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Factory 1</button>
               <ul class="dropdown-menu drop-down-find">
                   <li>
                       <input type="text" class="find">
                   </li>
                   <li>
                       <a href="#">Factory 1</a>
                   </li>
                   <li>
                       <a href="#">Factory 1</a>
                   </li>
                   <li>
                       <a href="#">Factory 1</a>
                   </li>
               </ul>
           </div>

           <div class="dropdown arr-drop">
               <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Россия</button>
               <ul class="dropdown-menu drop-down-find">
                   <li>
                       <input type="text" class="find">
                   </li>
                   <li>
                       <a href="#">Россия</a>
                   </li>
                   <li>
                       <a href="#">Украина</a>
                   </li>
                   <li>
                       <a href="#">Беларусь</a>
                   </li>
               </ul>
           </div>

           <div class="dropdown arr-drop">
               <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Выберите
                   город
               </button>
               <ul class="dropdown-menu drop-down-find">
                   <li>
                       <input type="text" class="find">
                   </li>
                   <li>
                       <a href="#">Киев</a>
                   </li>
                   <li>
                       <a href="#">Днепр</a>
                   </li>
                   <li>
                       <a href="#">Харьков</a>
                   </li>
               </ul>
           </div>

           <div class="dropdown large-picker">
               <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">21.08.2017 -
                   21.08.2017
               </button>
               <ul class="dropdown-menu">
                   <li>
                       <a href="#">
                           Oggi
                       </a>
                   </li>
                   <li>
                       <a href="#">
                           Leri
                       </a>
                   </li>
                   <li>
                       <a href="#">
                           Settimana
                       </a>
                   </li>
                   <li>
                       <a href="#">
                           30 giorni
                       </a>
                   </li>
                   <li>
                       <a href="#">
                           Messe attuale
                       </a>
                   </li>
                   <li>
                       <a href="#">
                           Mese precedente
                       </a>
                   </li>
                   <li>
                       <a href="#"></a>
                   </li>
               </ul>
           </div>
       </form>


                            <div class="cat-prod-wrap">
                                <div class="cat-prod">

                                    <?php
                                    foreach ($models as $model) {
                                        echo $this->render('_list_item', [
                                            'model' => $model,
                                        ]);
                                    } ?>

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

            </div>
        </div>
    </div>
</main>
