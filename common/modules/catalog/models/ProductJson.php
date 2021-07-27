<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\app\base\models\ActiveRecordLang;
use common\modules\catalog\Catalog;

/**
 * Class ProductJson
 *
 * @property integer $rid
 * @property string $lang
 * @property string $content
 *
 * @property Product $parent
 *
 * @package common\modules\catalog\models
 */
class ProductJson extends ActiveRecordLang
{
    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Catalog::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%catalog_item_json}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['rid', 'exist', 'targetClass' => Product::class, 'targetAttribute' => 'id'],
            [['content'], 'string'],
            [['content'], 'default', 'value' => ''],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['content']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'content'
        ];
    }

    /**
     * @inheritDoc
     */
    public function afterFind()
    {
        $this->content = json_decode($this->content);

        parent::afterFind();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Product::class, ['id' => 'rid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'content.factory_id']);
    }

    /**
     * @param $id
     */
    public static function add($id)
    {
        $productJson = ProductJson::findOne([
            'rid' => $id,
            'lang' => Yii::$app->language
        ]);

        if ($productJson == null) {
            $productJson = new ProductJson();
            $productJson->rid = $id;
            $productJson->lang = Yii::$app->language;
        }

        /** @var $product Product */
        $product = Product::findById($id);

        $obj = $product->attributes;

        $obj['lang'] = $product->lang ? $product->lang->attributes : [];

        $obj['factoryCatalogsFiles'] = [];

        if ($product->factoryCatalogsFiles) {
            foreach ($product->factoryCatalogsFiles as $key => $item) {
                $obj['factoryCatalogsFiles'][$key] = [
                    'id' => $item->id,
                    'title' => $item->title,
                    'file_link' => $item->file_link,
                    'file_type' => $item->file_type,
                    'file_size' => $item->file_size,
                    'discount' => $item->discount,
                ];
            }
        }

        $obj['factoryPricesFiles'] = [];

        if ($product->factoryPricesFiles) {
            foreach ($product->factoryPricesFiles as $key => $item) {
                $obj['factoryPricesFiles'][$key] = [
                    'id' => $item->id,
                    'title' => $item->title,
                    'file_link' => $item->file_link,
                    'file_type' => $item->file_type,
                    'file_size' => $item->file_size,
                    'discount' => $item->discount,
                ];
            }
        }

        $obj['specificationValue'] = [];

        if ($product->specificationValue) {
            foreach ($product->specificationValue as $key => $item) {
                $obj['specificationValue'][$key] = $item->attributes;
                $obj['specificationValue'][$key]['specification'] = $item->specification->attributes;

                $obj['specificationValue'][$key]['specification']['lang'] = [];

                if ($item->specification->lang) {
                    $obj['specificationValue'][$key]['specification']['lang'] = [
                        'title' => $item->specification->lang->title
                    ];
                }
            }
        }

        $obj['category'] = [];
        if ($product->category) {
            foreach ($product->category as $key => $item) {
                $obj['category'][$key] = $item->attributes;
                $obj['category'][$key]['lang'] = $item->lang->attributes;
            }
        }

        $obj['types'] = [];

        if ($product->types) {
            $obj['types'] = $product->types->attributes;
            $obj['types']['lang'] = $product->types->lang ? $product->types->lang->attributes : [];
        }

        $obj['subTypes'] = [];
        if ($product->subTypes) {
            foreach ($product->subTypes as $key => $item) {
                $obj['subTypes'][$key] = [
                    'id' => $item->id,
                    'alias' => $item->alias,
                ];
                $obj['subTypes'][$key]['lang'] = [
                    'title' => $item->lang->title,
                    'plural_name' => $item->lang->plural_name,
                ];
            }
        }

        $obj['factory'] = [];
        if ($product->factory) {
            $obj['factory'] = [
                'id' => $product->factory->id,
                'alias' => $product->factory->alias,
                'title' => $product->factory->title,
                'show_catalogs_files' => $product->factory->show_catalogs_files,
                'factory_discount' => $product->factory->factory_discount,
            ];
            $obj['factory']['lang'] = [];
        }

        $obj['collection'] = [];
        if ($product->collection) {
            $obj['collection'] = [
                'id' => $product->collection->id,
                'title' => $product->collection->title,
            ];
        }

        $productJson->setScenario('backend');
        $productJson->content = json_encode($obj, JSON_UNESCAPED_UNICODE);
        $productJson->save();
    }
}
