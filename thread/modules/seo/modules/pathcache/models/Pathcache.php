<?php

namespace thread\modules\seo\modules\pathcache\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\seo\helpers\CommonFunc;
use thread\modules\seo\modules\pathcache\Pathcache as ParentModule;

/**
 * Class Pathcache
 *
 * @package thread\modules\seo\modules\pathcache\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Pathcache extends ActiveRecord
{

    /**
     * @var
     */
    public static $commonQuery = query\ActiveQuery::class;

    /**
     * @return string
     */
    public static function getDb()
    {
        return ParentModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%seo_path_cache}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['model_key', 'classname'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['classname'], 'string', 'max' => 255],
            [['model_key'], 'string', 'max' => 40],
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
            'backend' => ['model_key', 'classname', 'published', 'deleted'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model_key' => Yii::t('seo', 'Model key'),
            'classname' => Yii::t('app', 'Class name'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @param ActiveRecord $model
     * @return string
     */
    public static function getModelKey(ActiveRecord $model)
    {
        return CommonFunc::getModelKey($model);
    }

    /**
     * @param string $classname
     * @return mixed
     */
    public static function findByClassName(string $classname)
    {
        return self::find()->_classname($classname);
    }

    /**
     * @param string $classname
     * @return mixed
     */
    public static function getByClassName(string $classname)
    {
        return self::find()->_classname($classname)->one();
    }

    /**
     * @return mixed
     */
    public static function getAllasArrayEnabled()
    {
        return self::find()->enabled()->asArray()->all();
    }
}
