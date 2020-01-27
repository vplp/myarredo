<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
use thread\app\base\models\ActiveRecord;
use common\modules\catalog\Catalog;
use common\actions\upload\UploadBehavior;

/**
 * Class Samples
 *
 * @property integer $id
 * @property integer $factory_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 * @property string $image_link
 * @property integer $moderation
 *
 * @property SamplesLang $lang
 *
 * @package common\modules\catalog\models
 */
class Samples extends ActiveRecord
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
        return '{{%catalog_samples}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'uploadBehavior' => [
                'class' => UploadBehavior::class,
                'attributes' => [
                    'image_link' => [
                        'path' => Yii::$app->getModule('catalog')->getSamplesUploadPath(),
                        'tempPath' => Yii::getAlias('@temp'),
                        'url' => Yii::$app->getModule('catalog')->getSamplesUploadPath(),
                    ]
                ]
            ],
        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['factory_id'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['published', 'deleted', 'moderation'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['image_link'], 'string', 'max' => 255],
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
            'backend' => ['factory_id', 'enabled', 'deleted', 'image_link', 'moderation'],
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
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'image_link' => Yii::t('app', 'Image link'),
            'moderation' => 'На модерации',
        ];
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->joinWith(['lang'])->orderBy(SamplesLang::tableName() . '.title');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(SamplesLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id']);
    }

    /**
     * @return null|string
     */
    public function getImageLink()
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $path = $module->getSamplesUploadPath();
        $url = $module->getSamplesUploadUrl();

        $image = null;

        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            $image = $url . '/' . $this->image_link;
        }

        return $image;
    }
}
