<?php

namespace common\modules\files\models;

use Yii;
use thread\app\base\models\ActiveRecord;

/**
 * Class Files
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @package common\modules\files\models
 */
class Files extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%files}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['name', 'url'],
            'frontend' => [
                'url'
            ],
        ];
    }


    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'URL'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
        ];
    }


    /**
     * @return string
     */
    public function getPublishedTime()
    {
        $format = FilesModule::getFormatDate();
        return $this->created_at == 0 ? date($format) : date($format, $this->created_at);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->orderBy(self::tableName() . '.id DESC');
    }

}
