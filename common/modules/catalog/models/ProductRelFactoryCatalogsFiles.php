<?php

namespace common\modules\catalog\models;

use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;

/**
 * Class ProductRelFactoryCatalogsFiles
 *
 * @property string $catalog_item_id
 * @property string $factory_file_id
 *
 * @package common\modules\catalog\models
 */
class ProductRelFactoryCatalogsFiles extends ActiveRecord
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
        return '{{%catalog_factory_file_catalog_rel_catalog_item}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['catalog_item_id', 'exist', 'targetClass' => Product::class, 'targetAttribute' => 'id'],
            ['factory_file_id', 'exist', 'targetClass' => FactoryFile::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => [
                'catalog_item_id',
                'factory_file_id',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'catalog_item_id',
            'factory_file_id',
        ];
    }
}
