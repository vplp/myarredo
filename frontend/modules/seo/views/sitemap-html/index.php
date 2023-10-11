<?php

use yii\helpers\Html;

/**
 * @var $category
 * @var $types
 * @var $subtypes
 * @var $style
 * @var $colors
 * @var $factory
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page about-page">
        <div class="container large-container">
            <div class="col-md-12">
                <?= Html::tag('h1', Yii::t('app', 'Карта сайта')); ?>
                <?= Html::tag('h2', Yii::t('app', 'Категории мебели')); ?>
                <div class="text">

                    <?php if ($category) {
                        echo Html::beginTag('ul', [
                            'class' => 'list sitemap-list'
                        ]);
                        foreach ($category as $item) {
                            echo Html::tag(
                                'li',
                                Html::a(
                                    '<i class="icon-right-open"></i>' . $item['title'],
                                    $item['link']
                                )
                            );
                        }
                        echo Html::endTag('ul');
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <?= Html::tag('h2', Yii::t('app', 'Предметы мебели')); ?>
                <div class="text">

                    <?php if ($types) {
                        echo Html::beginTag('ul', [
                            'class' => 'list sitemap-list'
                        ]);
                        foreach ($types as $item) {
                            echo Html::tag(
                                'li',
                                Html::a(
                                    '<i class="icon-right-open"></i>' . $item['title'],
                                    $item['link']
                                )
                            );
                        }
                        echo Html::endTag('ul');
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <?= Html::tag('h2', Yii::t('app', 'Типы')); ?>
                <div class="text">

                    <?php if ($subtypes) {
                        echo Html::beginTag('ul', [
                            'class' => 'list sitemap-list'
                        ]);
                        foreach ($subtypes as $item) {
                            echo Html::tag(
                                'li',
                                Html::a(
                                    '<i class="icon-right-open"></i>' . $item['title'],
                                    $item['link']
                                )
                            );
                        }
                        echo Html::endTag('ul');
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <?= Html::tag('h2', Yii::t('app', 'Стили мебели')); ?>
                <div class="text">

                    <?php if ($style) {
                        echo Html::beginTag('ul', [
                            'class' => 'list sitemap-list'
                        ]);
                        foreach ($style as $item) {
                            echo Html::tag(
                                'li',
                                Html::a(
                                    '<i class="icon-right-open"></i>' . $item['title'],
                                    $item['link']
                                )
                            );
                        }
                        echo Html::endTag('ul');
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <?= Html::tag('h2', Yii::t('app', 'Цвета мебели')); ?>
                <div class="text">

                    <?php if ($colors) {
                        echo Html::beginTag('ul', [
                            'class' => 'list sitemap-list'
                        ]);
                        foreach ($colors as $item) {
                            echo Html::tag(
                                'li',
                                Html::a(
                                    '<i class="icon-right-open"></i>' . $item['title'],
                                    $item['link']
                                )
                            );
                        }
                        echo Html::endTag('ul');
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <?= Html::tag('h2', Yii::t('app', 'Фабрики мебели')); ?>
                <div class="text">

                    <?php if ($factory) {
                        echo Html::beginTag('ul', [
                            'class' => 'list sitemap-list'
                        ]);
                        foreach ($factory as $item) {
                            echo Html::tag(
                                'li',
                                Html::a(
                                    '<i class="icon-right-open"></i>' . $item['title'],
                                    $item['link']
                                )
                            );
                        }
                        echo Html::endTag('ul');
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</main>
