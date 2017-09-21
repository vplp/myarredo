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
                    <div class="col-md-12">
                        Вы еще не добавили в заказ товаров.
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
