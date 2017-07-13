<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

$security = Yii::$app->getSecurity();

return [
    'id' => 1,
    'alias' => 'pageone',
    'image_link' => '',
    'created_at' => time(),
    'updated_at' => time(),
    'published' => '1',
    'deleted' => '0',
];
