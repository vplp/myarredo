<?php

namespace common\modules\files\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\modules\files\FilesModule;
use thread\app\base\models\ActiveRecordLang;
/**
 * Class FilesLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $content
 *
 * @property Files[] $Files
 * @property FilesLang[] $langs
 *
 * @package common\modules\files\models
 */
class FilesLang extends ActiveRecordLang
{
    /**
     * @return object|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return FilesModule::getDb();
    }

    /**
     * @inheritdoc
     * @return string
     */
    public static function tableName()
    {
        return '{{%files_lang}}';
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['title'], 'required'],
                ['rid', 'exist', 'targetClass' => Files::class, 'targetAttribute' => 'id'],
                ['content', 'string'],
                ['title', 'string', 'max' => 255],
            ]
        );
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title', 'content'],
        ];
    }
}
