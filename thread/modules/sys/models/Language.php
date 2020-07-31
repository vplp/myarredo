<?php

namespace thread\modules\sys\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\app\base\models\{
    ActiveRecord
};
use thread\app\model\interfaces\LanguageModel;
use thread\modules\sys\Sys as SysModule;

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
 */
class Language extends ActiveRecord implements LanguageModel
{
    /**
     * @return null|object|\yii\db\Connection
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return SysModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%system_languages}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'label'], 'string', 'max' => 50],
            [['local'], 'string', 'max' => 5],
            [['img_flag'], 'string', 'max' => 225],
            [['alias', 'local', 'label'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['published', 'deleted', 'by_default'], 'in', 'range' => array_keys(static::statusKeyRange())],
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
            'backend' => ['published', 'deleted', 'alias', 'local', 'label', 'img_flag', 'by_default'],
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
            'img_flag' => Yii::t('app', 'Image link'),
            'by_default' => Yii::t('app', 'Default'),
        ];
    }

    /**
     * @return mixed
     */
    public function getLanguages(): array
    {
        return self::findBase()->asArray()->all();
    }

    /**
     * @return mixed
     */
    public function getCurrent(): array
    {
        return self::findBase()->andWhere(['local' => \Yii::$app->language])->asArray()->one();
    }

    /**
     * @return string|null
     */
    public function getFlagUploadUrl()
    {
        /** @var SysModule $Module */
        $Module = Yii::$app->getModule('sys');

        $path = $Module->getFlagUploadPath();
        $url = $Module->getFlagUploadUrl();
        $image = null;

        if (isset($this->img_flag) && file_exists($path . '/' . $this->img_flag)) {
            $image = $url . '/' . $this->img_flag;
        }

        return $image;
    }

    /**
     * @param string $key
     * @param string $value
     * @return array
     */
    public function getLanguageArray($key = 'id', $value = 'local'): array
    {
        return ArrayHelper::map($this->getLanguages(), $key, $value);
    }
}
