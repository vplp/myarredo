<?php

namespace frontend\modules\catalog\models;

use Yii;
use yii\data\ArrayDataProvider;
use yii\elasticsearch\ActiveRecord;

/**
 * Class ElasticSearchProduct
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $title_it
 * @property string $title_en
 * @property string $title_uk
 * @property string $description_ru
 * @property string $description_it
 * @property string $description_en
 * @property string $description_uk
 * @property string $collection
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
        return 'catalog_item';
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
        return [
            'id',
            'title_ru',
            'title_it',
            'title_en',
            'title_uk',
            'description_ru',
            'description_it',
            'description_en',
            'description_uk',
            'collection'
        ];
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
                    'title_en' => ['type' => 'text'],
                    'title_uk' => ['type' => 'text'],
                    'description_ru' => ['type' => 'text'],
                    'description_it' => ['type' => 'text'],
                    'description_en' => ['type' => 'text'],
                    'description_uk' => ['type' => 'text'],
                    'collection' => ['type' => 'text'],
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
            'settings' => [
                'index' => [
                    'refresh_interval' => '1s'
                ]
            ],
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

            return $record->update(false);
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
            if ($record != null) {
                $record->delete();
            }
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
        $collection = 'collection';


        $record->$title = $product['lang']['title'];
        $record->$description = '';
        $record->$collection = $product['collection']['title'] ?? '';

        try {
            if (!$isExist) {
                $record->id = $product['id'];
                $result = $record->insert();
            } else {
                //$result = $record->save();
                $result = $record->update(false, ['title_' . $lang]);
            }
        } catch (\Exception $e) {
            echo 'Exception: ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ")\n";
            $result = false;
        }
        var_dump($result);
        return $result;
    }

    public function getProduct()
    {
        return $this
            ->hasOne(Product::class, ['id' => 'id'])
            ->innerJoinWith(['lang', 'factory']);
    }

    /**
     * @param $params
     * @return ArrayDataProvider
     */
    public function search($params)
    {
        $lang = substr(Yii::$app->language, 0, 2);

        $query = self::find()->with(['product', 'product.factory']);

        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $queryBool = [
            'bool' => [
                'should' => [
                    [
                        'match' => [
                            'title_' . $lang => [
                                'query' => $params['search'],
                                'operator' => 'AND'
                            ]
                        ]
                    ],
                    [
                        'match' => [
                            'description_' . $lang => [
                                'query' => $params['search'],
                                'operator' => 'AND'
                            ]
                        ]
                    ],
                    [
                        'match' => [
                            'collection' => [
                                'query' => $params['search'],
                                'operator' => 'AND'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $query->query($queryBool);

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
