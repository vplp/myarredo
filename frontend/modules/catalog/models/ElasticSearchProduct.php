<?php

namespace frontend\modules\catalog\models;

use Yii;
//
use yii\elasticsearch\ActiveRecord;
use yii\elasticsearch\Query;
use yii\elasticsearch\ActiveDataProvider;

/**
 * Class ElasticSearchProduct
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 *
 * @package frontend\modules\catalog\models
 */
class ElasticSearchProduct extends ActiveRecord
{
    public static function index()
    {
        return 'c1myarredo';
    }

    public static function type()
    {
        return "catalog_item";
    }

    public function attributes()
    {
        return ['id', 'title', 'description'];
    }

    /**
     * @return array This model's mapping
     */
    public static function mapping()
    {
        return [
            static::type() => [
                'properties' => [
                    'id' => ['type' => 'long'],
                    'title' => ['type' => 'text'],
                    'description' => ['type' => 'text'],
//                    'publisher_name' => ['type' => 'string', "index" => "not_analyzed"],
//                    'created_at' => ['type' => 'long'],
//                    'updated_at' => ['type' => 'long'],
//                    'status' => ['type' => 'long'],
//                    'suppliers' => [
//                        'type' => 'nested',
//                        'properties' => [
//                            'id' => ['type' => 'long'],
//                            'name' => ['type' => 'string', 'index' => 'not_analyzed'],
//                        ]
//                    ]
                ]
            ],
        ];
    }

    /**
     * Set (update) mappings for this model
     */
    public static function updateMapping()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->setMapping(static::index(), static::type(), static::mapping());
    }

    /**
     * Create this model's index
     */
    public static function createIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->createIndex(static::index(), [
            'settings' => ['index' => ['refresh_interval' => '1s']],
            'mappings' => static::mapping(),
            //'warmers' => [ /* ... */ ],
            //'aliases' => [ /* ... */ ],
            //'creation_date' => '...'
        ]);
    }

    /**
     * Delete this model's index
     */
    public static function deleteIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->deleteIndex(static::index(), static::type());
    }

    public static function updateRecord($product_id, $columns)
    {
        try {
            $record = self::get($product_id);
            foreach ($columns as $key => $value) {
                $record->$key = $value;
            }

            return $record->update();
        } catch (\Exception $e) {
            //handle error here
            return false;
        }
    }

    public static function deleteRecord($product_id)
    {
        try {
            $record = self::get($product_id);
            $record->delete();
            return 1;
        } catch (\Exception $e) {
            //handle error here
            return false;
        }
    }

    public static function addRecord($product)
    {
        $isExist = false;

        try {
            $record = self::get($product->id);
            if (!$record) {
                $record = new self();
                $record->setPrimaryKey($product->id);
            } else {
                $isExist = true;
            }
        } catch (\Exception $e) {
            $record = new self();
            $record->setPrimaryKey($product->id);
        }

//        $suppliers = [
//            ['id' => '1', 'name' => 'ABC'],
//            ['id' => '2', 'name' => 'XYZ'],
//        ];

        $record->id = $product->id;
        $record->title = $product->lang->title;
        $record->description = $product->lang->description;

        //$record->status = 1;
        //$record->suppliers = $suppliers;

        try {
            if (!$isExist) {
                $result = $record->insert();
            } else {
                $result = $record->update();
            }
        } catch (\Exception $e) {
            $result = false;
            //handle error here
        }

        return $result;
    }

    public function search($params)
    {
        $query = new Query();

        $query->from(self::index(), self::type());

        $filters = [
            'multi_match' => [
                'query' => $params['search'],
                'type' => 'phrase_prefix',
                'fields' => ['title', 'description']
            ]
        ];

        $query->query($filters);

        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        return $dataProvider;
    }
}