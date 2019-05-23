<?php

use yii\helpers\Html;
//
use frontend\modules\page\models\Page;

use frontend\themes\myarredo\assets\AppAsset;

/**
 * @var $model Page
 */

$this->title = $this->context->title;

?>

<main class="about-main">
    <div class="about-wrap">
        <div class="largex-container about-container">
            <div class="aboutbox">
                <?= Html::tag('h1', Html::encode($model['lang']['title']), ['class' => 'about-title']); ?>
                <div class="about-content">

                    <?= $model['lang']['content'] ?>

                </div>
            </div>

        </div>
    </div>
</main>
