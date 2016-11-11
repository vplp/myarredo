<?php

namespace thread\modules\seo\models;

use Yii;
//
use  thread\app\base\models\ActiveRecord;
use thread\modules\seo\Seo as SeoModule;

/**
 * Class Page
 *
 * @property integer $id
 * @property integer $model_id
 * @property string $model_namespace
 * @property boolean $in_search
 * @property boolean $in_robots
 * @property boolean $in_site_map
 * @property integer $published
 * @property integer $deleted
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Lang $lang
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Seo extends ActiveRecord
{
    public $modelName = 'Seo';

    /**
     * Using db connection
     *
     * @return null|object|string
     */
    public static function getDb()
    {
        return SeoModule::getDb();
    }

    /**
     * Page table name
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%seo}}';
    }

    /**
     * Description
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['alias'], 'required'],
            [
                ['published', 'deleted', 'in_search', 'in_robots', 'in_site_map'],
                'in',
                'range' => array_keys(static::statusKeyRange())
            ],
            [['created_at', 'updated_at', 'model_id',], 'integer'],
            [['model_namespace'], 'string', 'max' => 255],
            [['alias'], 'unique'],
        ];
    }


    /**
     * Description
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => [
                'model_id',
                'model_namespace',
                'in_search',
                'in_robots',
                'in_site_map',
                'published',
                'deleted'
            ],
        ];
    }

    /**
     *  Description
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model_id' => Yii::t('seo', 'Model id'),
            'model_namespace' => Yii::t('seo', 'Model namespace'),
            'in_search' => Yii::t('seo', 'Display in the search engine'),
            'in_robots' => Yii::t('seo', 'Write to robots'),
            'in_site_map' => Yii::t('seo', 'Write to siteMap'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * Description
     *
     * @return $this
     */
    public function getLang()
    {
        return $this->hasOne(SeoLang::class, ['rid' => 'id'])->andOnCondition(['lang' => \Yii::$app->language]);
    }


    /**
     * get model by namespace and model id
     *
     * @param $namespace - common namespace
     * @param $modelId
     * @return mixed|Seo
     */

    public static function getModelByNamespace($namespace, $modelId)
    {
        $seoModel = self::findByNamespace($namespace, $modelId);

        if ($seoModel === null) {
            $seoModel = new self();
            //TODO Пересмотреть
            $seoModel->setScenario('backend');
            $seoModel->model_namespace = $namespace;
            $seoModel->model_id = $modelId;
        }

        return $seoModel;
    }


    /**
     * Поиск модели с помощью namespace и model id
     *
     * @param $namespace - !!! namespace Thread Модели
     * @param $modelId - modelId
     * @return mixed
     */

    public static function findByNamespace($namespace, $modelId)
    {
        return self::find()->andWhere(['model_namespace' => $namespace, 'model_id' => $modelId])->one();
    }

    /**
     * get lang Model
     *
     * @return null|Lang|SeoLang
     */

    public function getLangModel()
    {
        $langModel = (isset($this->lang)) ? $this->lang : null;

        if ($langModel === null) {
            $langModel = new SeoLang(['scenario' => 'backend']);
            $langModel->rid = $this->id;
            $langModel->lang = Yii::$app->language;
        }

        return $langModel;
    }
}
