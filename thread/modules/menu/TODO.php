<?php
/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
//TODO: Внутрення линковка на модули
//TODO: 1. Модель линковки

[
    'key' => 'page',
    'label' => 'Page',
    'class' => Page::class,
    'method' => 'dropDownList()',
]

//TODO: Если формировать с селект 2 (с автоподсказкой)
//TODO: то выбор простого дпродаун подойдет.


ALTER TABLE `fv_menu_item` CHANGE `internal_source` `internal_source` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'page-page' COMMENT 'Internal source';