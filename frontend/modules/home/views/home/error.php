<?php

use yii\helpers\Html;
//
use frontend\themes\myarredo\assets\AppAsset;

$this->title = $name;

$bundle = AppAsset::register($this);
?>

<main>
    <div class="page about-page error-page">
        <div class="container largex-container">
            <div class="row">
                <div class="col-md-6">
                    <figure class="error-img">
                        <?= Html::img($bundle->baseUrl . '/img/not_found.svg') ?>
                    </figure>
                </div>
                <div class="col-md-6">
                    <?php Html::tag('h1', Html::encode($this->title), []); ?>
                    <div class="text errtext-box">
                        <p class="notfound-text"><?= nl2br(Html::encode($message)) ?></p>
                        <p class="gohome">
                            <?= Html::a(
                                Yii::t('app', 'Перейти на главную'),
                                '/',
                                ['class' => 'gohome-link']
                            ) ?>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
