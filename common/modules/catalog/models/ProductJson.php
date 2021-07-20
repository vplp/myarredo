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
     * @param $alias
     * @return mixed
     */
    public static function findByAlias($alias)
    {
        $data = self::find()
            ->innerJoinWith(['parent'], false)
            ->andWhere([Product::tableName() . '.' . Yii::$app->languages->getDomainAlias() => $alias])
            ->one();

        if ($data != null) {
            $data = $data->content;
        }

        return $data;
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

        $obj['specificationValue'] = [];
        if ($product->specificationValue) {
            foreach ($product->specificationValue as $item) {
                $obj['specificationValue'][] = $item->attributes + [
                        'specification' => $item->specification->attributes + [
                                'lang' => $item->specification->lang->attributes
                            ]
                    ];
            }
        }

        $obj['category'] = [];
        if ($product->category) {
            foreach ($product->category as $item) {
                $obj['category'][] = $item->attributes + [
                        'lang' => $item->lang->attributes
                    ];
            }
        }

        $obj['types'] = [];
        if ($product->types) {
            foreach ($product->types as $item) {
                $obj['types'][] = $item->attributes + [
                        'lang' => $item->lang->attributes
                    ];
            }
        }

        $obj['subTypes'] = [];
        if ($product->subTypes) {
            foreach ($product->subTypes as $item) {
                $obj['subTypes'][] = $item->attributes + [
                        'lang' => $item->lang->attributes
                    ];
            }
        }

//        $obj['factory'] = [];
//        if ($product->factory) {
//            $obj['factory'] = $product->factory->attributes + [
//                    'lang' => $product->factory->lang->attributes
//                ];
//        }

        $obj['collection'] = $product->collection ? $product->collection->attributes : [];

//        /* !!! */
//        echo '<pre style="color:red;">';
//        print_r($obj);
//        echo '</pre>'; /* !!! */
//        die;

        $productJson->setScenario('backend');
        $productJson->content = json_encode($obj);
        $productJson->save();
    }
}
