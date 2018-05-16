<?php

namespace frontend\modules\catalog\models;

use yii\elasticsearch\ActiveRecord;

/**
 * Class Elastic
 *
 * @property integer $id
 * @property string $alias
 *
 * @package frontend\modules\catalog\models
 */
class Elastic extends ActiveRecord
{
    public static function index()
    {
        return 'yiitest';
    }

    public static function primaryKey()
    {
        return ['id'];
    }

    public function attributes()
    {
        return ['id', 'alias'];
    }

    /**
     * sets up the index for this record
     * @param Command $command
     */
    public static function setUpMapping($command)
    {
        $command->deleteMapping(static::index(), static::type());
        $command->setMapping(static::index(), static::type(), [
            static::type() => [
                "_id" => ["path" => "id", "index" => "not_analyzed", "store" => "yes"],
                "properties" => [
                    "alias" => ["type" => "string", "index" => "not_analyzed"],
                ]
            ]
        ]);
    }

}