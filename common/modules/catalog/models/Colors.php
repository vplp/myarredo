<?php

namespace common\modules\catalog\models;

use Yii;
use common\modules\catalog\Catalog;
use thread\app\base\models\ActiveRecord;

/**
 * Class Colors
 *
 * @property integer $id
 * @property string $alias
 * @property string $alias_en
 * @property string $alias_it
 * @property string $alias_de
 * @property string $alias_fr
 * @property string $alias_he
 * @property string $default_title
 * @property string $color_code
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property ColorsLang $lang
 *
 * @property Product $product
 * @property Sale $sale
 * @property ItalianProduct $italianProduct
 *
 * @package common\modules\catalog\models
 */
class Colors extends ActiveRecord
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
        return '{{%catalog_colors}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'alias_en', 'alias_it', 'alias_de', 'alias_fr', 'alias_he', 'color_code'], 'required'],
            [['created_at', 'updated_at', 'position'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['default_title'], 'string', 'max' => 255],
            [['alias', 'alias_en', 'alias_it', 'alias_de', 'alias_fr', 'alias_he', 'color_code'], 'string', 'max' => 32],
            [['alias', 'alias_en', 'alias_it', 'alias_de', 'alias_fr', 'alias_he', 'color_code'], 'unique'],
            [['position'], 'default', 'value' => '0'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'position' => ['position'],
            'backend' => [
                'alias',
                'alias_en',
                'alias_it',
                'alias_de',
                'alias_fr',
                'alias_he',
                'default_title',
                'color_code',
                'position',
                'published',
                'deleted'
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (Yii::$app->language == 'ru-RU') {
            $dataModelLang = Yii::$app->request->getBodyParam('ColorsLang');
            $this->default_title = $dataModelLang['title'];
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Alias'),
            'alias_en' => 'Alias for en',
            'alias_it' => 'Alias for it',
            'alias_de' => 'Alias for de',
            'alias_fr' => 'Alias for fr',
            'alias_he' => 'Alias for he',
            'default_title' => Yii::t('app', 'Default title'),
            'color_code' => Yii::t('app', 'Color code'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return (isset($this->lang->title)) ? $this->lang->title : "{{$this->default_title}}";
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->joinWith(['lang'])->orderBy(self::tableName() . '.position');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(ColorsLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getProduct()
    {
        return $this
            ->hasMany(Product::class, ['id' => 'item_id'])
            ->viaTable(ColorsRelProduct::tableName(), ['color_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getItalianProduct()
    {
        return $this
            ->hasMany(ItalianProduct::class, ['id' => 'item_id'])
            ->viaTable(ColorsRelItalianProduct::tableName(), ['color_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getSale()
    {
        return $this
            ->hasMany(Sale::class, ['id' => 'item_id'])
            ->viaTable(ColorsRelSaleProduct::tableName(), ['color_id' => 'id']);
    }
}
