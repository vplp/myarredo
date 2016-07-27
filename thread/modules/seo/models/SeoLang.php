<?php

namespace thread\modules\seo\models;

use thread\app\base\models\ActiveRecordLang;
use thread\modules\seo\Seo as SeoModel;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class PageLang
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $content
 *
 * @property Page[] $seos
 * @property Lang[] $langs
 *
 * @package thread\modules\seo\models
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class SeoLang extends ActiveRecordLang
{
    /**
     * Db connection
     *
     * @return string
     */
    public static function getDb()
    {
        return SeoModel::getDb();
    }

    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%seo_lang}}';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['title'], 'required'],
                ['rid', 'exist', 'targetClass' => Seo::class, 'targetAttribute' => 'id'],
                [['title', 'description', 'keywords'], 'string', 'max' => 255],
            ]
        );
    }

    /**
     * Labels
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'rid' => Yii::t('app', 'rid'),
            'lang' => Yii::t('app', 'lang'),
            'title' => Yii::t('app', 'title'),
            'description' => Yii::t('app', 'description'),
            'keywords' => Yii::t('app', 'keywords'),
        ];
    }

    /**
     * Scenarios
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title', 'description', 'keywords'],
        ];
    }

}
