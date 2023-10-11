<?php

namespace common\modules\news\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
//
use voskobovich\behaviors\ManyToManyBehavior;
//
use common\modules\location\models\City;
use common\modules\user\models\User;
use common\modules\news\News as NewsModule;
//
use thread\app\base\models\ActiveRecord;

/**
 * Class ArticleForPartners
 *
 * @property integer $id
 * @property integer $image_link
 * @property integer $position
 * @property integer $show_all
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 * @property array $city_ids
 * @property array $user_ids
 *
 * @property ArticleForPartnersRelCity[] $cities
 * @property ArticleForPartnersRelUser[] $users
 * @property ArticleForPartnersLang $lang
 *
 * @package common\modules\news\models
 */
class ArticleForPartners extends ActiveRecord
{
    /**
     * @return null|object|\yii\db\Connection
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return NewsModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%news_article_for_partners}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'city_ids' => 'cities',
                ],
            ],
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'user_ids' => 'users',
                ],
            ],
        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['image_link'], 'string', 'max' => 255],
            [['position', 'create_time', 'update_time'], 'integer'],
            [['show_all', 'published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['position'], 'default', 'value' => '0'],
            [['city_ids', 'user_ids'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'show_all' => ['show_all'],
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => ['image_link', 'position', 'show_all', 'published', 'deleted', 'city_ids', 'user_ids'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'image_link' => Yii::t('app', 'Image link'),
            'position' => Yii::t('app', 'Position'),
            'show_all' => Yii::t('news', 'Show all'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'city_ids' => Yii::t('app', 'Cities'),
            'user_ids' => Yii::t('app', 'Users'),
        ];
    }

    /**
     * @return null|string
     */
    public function getArticleImage()
    {
        $module = Yii::$app->getModule('news');

        $path = $module->getArticleUploadPath();
        $url = $module->getArticleUploadUrl();

        $image = null;

        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            $image = $url . '/' . $this->image_link;
        }

        return $image;
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['lang'])
            ->orderBy(self::tableName() . '.position');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(ArticleForPartnersLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getCities()
    {
        return $this
            ->hasMany(City::class, ['id' => 'city_id'])
            ->viaTable(ArticleForPartnersRelCity::tableName(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getUsers()
    {
        return $this
            ->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable(ArticleForPartnersRelUser::tableName(), ['article_id' => 'id']);
    }
}
