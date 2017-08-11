<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;

/**
 * Class Collection
 *
 * @property integer $id
 * @property integer $factory_id
 * @property string $first_letter
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 * @property integer $moderation
 *
 * @property CollectionLang $lang
 *
 * @package common\modules\catalog\models
 */
class Collection extends ActiveRecord
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
        return '{{%catalog_collection}}';
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
            [['factory_id', 'first_letter'], 'required'],
            [['factory_id', 'created_at', 'updated_at', 'position'], 'integer'],
            [['published', 'deleted', 'moderation'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['first_letter'], 'string', 'max' => 1],
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $title = (Yii::$app->request->post('CollectionLang'))['title'];
        $this->first_letter = mb_strtoupper(mb_substr(trim($title), 0, 1, 'UTF-8'), 'UTF-8');

        return parent::beforeValidate();
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => ['factory_id', 'first_letter', 'published', 'deleted', 'moderation'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'factory_id' => Yii::t('app', 'Factory'),
            'first_letter',
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'moderation'
        ];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->innerJoinWith(['lang'])->orderBy(CollectionLang::tableName() . '.title');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(CollectionLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id']);
    }
}