<?php

use yii\helpers\{
    Html, Url
};

?>

<main>
    <div class="page notebook-page">
        <div class="container large-container">
            <form>
                <div class="row">
                    <div class="col-md-12">
                        <?= Html::tag('h2', $this->context->title) ?>

                        <?= Html::a('Добавить товар', Url::toRoute(['/catalog/category/list']), ['class' => 'btn btn-default add-product']) ?>
                    </div>
                    <div class="col-md-8">

                        <?= \frontend\modules\shop\widgets\cart\Cart::widget(['view' => 'full']) ?>

                    </div>
                    <div class="col-md-4">
                        <div class="best-price-form">
                            <h3>
                                Заполните форму - получите лучшую цену на этот товар
                            </h3>
                            <form role="form">
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email" placeholder="Введите email">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" placeholder="Имя">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="phone" placeholder="+7 (___) ___-__-__">
                                </div>
                                <div class="form-group">
                                    <textarea name="comm" class="form-control" id="" cols="30" rows="10"
                                              placeholder="Комментарии"></textarea>
                                </div>

                                <button type="submit" class="btn btn-success big">Получить лучшую цену</button>

                            </form>

                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</main>
