<?php

namespace thread\modules\configs\models;

use Yii;
//
use thread\app\base\models\{
    ActiveRecord, query\ActiveQuery
};

use thread\modules\configs\Configs as ConfigsModule;


/**
 * Class Language
 *
 * @property integer $id
 * @property string $alias
 * @property string $local
 * @property string $label
 * @property string $img_flag
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @package thread\modules\configs\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class Language extends ActiveRecord implements \thread\app\model\interfaces\LanguageModel
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return ConfigsModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%languages}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'local', 'label'], 'string', 'max' => 50],
            [['img_flag'], 'string', 'max' => 225],
            [['alias', 'local', 'label'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['published', 'deleted', 'default'], 'in', 'range' => array_keys(static::statusKeyRange())],
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
            'backend' => ['published', 'deleted', 'alias', 'local', 'label', 'img_flag', 'default'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'alias' => Yii::t('app', 'Alias'),
            'local' => Yii::t('app', 'Local'),
            'label' => Yii::t('app', 'Label'),
            'img_flag' => Yii::t('app', 'Img_flag'),
            'default' => Yii::t('app', 'Default'),
        ];
    }

    /**
     * @return mixed
     */
    public function getLanguages():array
    {
        return self::findBase()->asArray()->all();
    }

    /**
     * @return mixed
     */
    public function getCurrent()
    {
        return self::findBase()->andWhere(['local' => \Yii::$app->language])->asArray()->one();
    }

    /**
     * @return null|string
     */
    public function getImage()
    {
        /** @var Configs $Module */
        $Module = Yii::$app->getModule('configs');
        $path = $Module->getFlagUploadUrl();
        $url = $Module->getFlagUploadUrl();
        $image = null;
        if (isset($this->img_flag) && file_exists($path . '/' . $this->img_flag)) {
            $image = $url . '/' . $this->img_flag;
        }
        return $image;
    }

}