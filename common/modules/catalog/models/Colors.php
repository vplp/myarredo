<?php

namespace common\modules\catalog\models;

use Yii;
//
use common\modules\catalog\Catalog;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class Colors
 *
 * @property integer $id
 * @property string $alias
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
            [['alias', 'color_code'], 'required'],
            [['created_at', 'updated_at', 'position'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['default_title'], 'string', 'max' => 255],
            [['alias', 'color_code'], 'string', 'max' => 32],
            [['alias', 'color_code'], 'unique'],
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
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->joinWith(['lang'])->orderBy(ColorsLang::tableName() . '.title');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(ColorsLang::class, ['rid' => 'id']);
    }
}
