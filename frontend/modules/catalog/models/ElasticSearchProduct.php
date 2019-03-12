<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\data\ArrayDataProvider;
//
use yii\elasticsearch\ActiveRecord;

/**
 * Class ElasticSearchProduct
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $title_it
 * @property string $description_ru
 * @property string $description_it
 *
 * @property Product $product
 *
 * @package frontend\modules\catalog\models
 */
class ElasticSearchProduct extends ActiveRecord
{
    /**
     * @return string
     */
    public static function index()
    {
        return 'c1myarredo';
    }

    /**
     * @return string
     */
    public static function type()
    {
        return "catalog_item";
    }

    /**
     * @return array|string[]
     */
    public function attributes()
    {
        return ['id', 'title_ru', 'title_it', 'description_ru', 'description_it'];
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
                    'title_ru' => ['type' => 'text'],
                    'title_it' => ['type' => 'text'],
                    'description_ru' => ['type' => 'text'],
                    'description_it' => ['type' => 'text'],
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

    /**
     * @param $product_id
     * @param $columns
     * @return bool|int
     */
    public static function updateRecord($product_id, $columns)
    {
        try {
            $record = self::get($product_id);
            foreach ($columns as $key => $value) {
                $record->$key = $value;
            }

            return $record->update();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $product_id
     * @return bool|int
     */
    public static function deleteRecord($product_id)
    {
        try {
            $record = self::get($product_id);
            $record->delete();
            return 1;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $product
     * @return bool|int
     */
    public static function addRecord($product)
    {
        $isExist = false;

        try {
            $record = self::get($product['id']);
            if (!$record) {
                $record = new self();
                $record->setPrimaryKey($product['id']);
            } else {
                $isExist = true;
            }
        } catch (\Exception $e) {
            $record = new self();
            $record->setPrimaryKey($product['id']);
        }

        $lang = substr($product['lang']['lang'], 0, 2);

        $title = 'title_' . $lang;
        $description = 'description_' . $lang;

        $record->id = $product['id'];

        $record->$title = $product['lang']['title'];
        $record->$description = $product['lang']['description'];

        try {
            if (!$isExist) {
                $result = $record->insert();
            } else {
                $result = $record->update();
            }
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'id']);
    }

    /**
     * @param $params
     * @return ArrayDataProvider
     */
    public function search($params)
    {
        $lang = substr(Yii::$app->language, 0, 2);

        $query = self::find()->with(["product"]);

        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $queryBool = [
            'should' => [
                [
                    'multi_match' => [
                        'fields' => ['title_' . $lang, 'description_' . $lang],
                        "query" => $params['search'],
                        "type" => "best_fields",
                        'fuzziness' => 'AUTO',
                        "minimum_should_match" => "70%",
                        'boost' => 10
                    ],
                ],
                [
                    'query_string' => [
                        'fields' => ['title_' . $lang, 'description_' . $lang],
                        "query" => '*' . $params['search'] . '*',
                        'fuzziness' => 'AUTO',
                        "minimum_should_match" => "60%",
                        'boost' => 5
                    ],
                ]
            ],
        ];

        $query->query(['bool' => $queryBool]);

        $query->limit(10000);

        $data = $query->all();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => $module->itemOnPage,
            ],
        ]);

        return $dataProvider;
    }
}
