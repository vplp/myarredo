<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

?>

<main>
    <div class="page about-page">
        <div class="container large-container">
            <div class="col-md-12">
                <?= Html::tag('h1', $this->context->title); ?>
                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                    'options' => ['class' => 'bread-crumbs']
                ]) ?>
                <div class="text">

                    <p style="text-align:center"><span style="font-size:22px"><span
                                    style="font-family:tahoma,geneva,sans-serif"><strong><span
                                            style="color:rgb(255, 0, 0)">Важно!</span>&nbsp;</strong></span></span></p>
                    <p style="text-align:center">
                        <span style="font-size:18px; font-family:tahoma,geneva,sans-serif">
                            Проверьте, пожалйста, папку СПАМ и отметьте&nbsp;письмо от MyARREDO как <u>НЕспам</u>.
                            <br/><br/>
                            Иначе нам не удастся отправить уведомления о новых запросах и дарить вам клиентов.</span>
                    </p>

                    <p style="text-align:center">
                        <?php if ($domain == 'ua'): ?>
                            <iframe width="853" height="480" src="https://www.youtube.com/embed/k7VvU4_EhmA" frameborder="0" allowfullscreen></iframe>
                        <?php elseif ($domain == 'ru'): ?>
                            <iframe width="853" height="480" src="https://www.youtube.com/embed/ROsr8e4ykaw" frameborder="0" allowfullscreen></iframe>
                        <?php elseif ($domain == 'by'): ?>

                        <?php endif; ?>
                    </p>
                </div>
            </div>

        </div>
    </div>
</main>