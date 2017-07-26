<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;

/**
 * Class Factory
 *
 * @property integer $id
 * @property string $country_code
 * @property string $alias
 * @property string $first_letter
 * @property string $url
 * @property string $email
 * @property integer $popular
 * @property integer $popular_by
 * @property integer $popular_ua
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 * @property integer $novelty
 * @property string $novelty_url
 * @property string $image_link
 * @property integer $position
 * @property integer $partner_id
 * @property integer $alternative
 *
 * @property FactoryLang $lang
 *
 * @package common\modules\catalog\models
 */
class Factory extends ActiveRecord
{
    /**
     * @return string
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
        return '{{%catalog_factory}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [

        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'first_letter'], 'required'],
            [['created_at', 'updated_at', 'position', 'partner_id'], 'integer'],
            [['published', 'deleted', 'position', 'popular_ua', 'popular_by', 'novelty', 'alternative'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias', 'country_code', 'url', 'email', 'novelty_url', 'image_link'], 'string', 'max' => 255],
            [['first_letter'], 'string', 'max' => 2],
            [['alias'], 'unique'],
            [['position'], 'default', 'value' => '0']
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
            'popular' => ['popular'],
            'popular_by' => ['popular_by'],
            'popular_ua' => ['popular_ua'],
            'backend' => [
                'alias', 'country_code', 'url', 'email', 'novelty_url', 'image_link',
                'first_letter',
                'published', 'deleted', 'position', 'popular_ua', 'popular_by', 'novelty', 'alternative',
                'position', 'partner_id'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Alias'),
            'country_code' => 'Показывать для страны',
            'url' => 'url',
            'email' => 'E-Mail',
            'novelty_url' => 'Новинки url',
            'image_link' => 'Изображение',
            'novelty' => 'Новинки',
            'popular' => 'Популярный Ru',
            'popular_by' => 'Популярный By',
            'popular_ua' => 'Популярный Ua',
            'partner_id' => 'Партнер',
            'alternative' => 'Связь альтернативы',
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
        return self::find()->joinWith(['lang'])->orderBy(FactoryLang::tableName() . '.title');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(FactoryLang::class, ['rid' => 'id']);
    }

    /**
     * @return null|string
     */
    public function getFactoryImage()
    {
        $module = Yii::$app->getModule('catalog');
        $path = $module->getFactoryUploadPath();
        $url = $module->getFactoryUploadUrl();
        $image = null;
        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            $image = $url . '/' . $this->image_link;
        }
        return $image;
    }
}
