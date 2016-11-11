<?php

use yii\helpers\Html;

/**
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */

echo Html::beginTag('ul', ['class' => 'catalog_menu']);

foreach ($items as $item):
    echo Html::beginTag('li', ['class' => 'level']);
    echo Html::a($item['lang']['title'], $item->getUrl(), ['class' => '']);

        // level2 start

        if((Yii::$app->request->get('alias') == $item->alias) ||
            (!empty($parent) && $parent->alias == $item->alias)):

            echo Html::beginTag('ul', ['class' => 'catalog_menu_submenu']);
            foreach ($item->children as $item2):
                echo Html::beginTag('li', ['class' => 'level2']);
                echo Html::a($item2['lang']['title'], $item2->getUrl(), ['class' => '']);

                    // level3 start

                    echo Html::beginTag('ul', ['class' => 'catalog_menu_submenu']);
                    foreach ($item2->children as $item3):
                        echo Html::beginTag('li', ['class' => 'level3']);
                        echo Html::a($item3['lang']['title'], $item3->getUrl(), ['class' => '']);
                        echo Html::endTag('li');
                    endforeach;
                    echo Html::endTag('ul');

                    // level3 end

                echo Html::endTag('li');
            endforeach;
            echo Html::endTag('ul');

        endif;

        // level2 end

    echo Html::endTag('li');
endforeach;

echo Html::endTag('ul');