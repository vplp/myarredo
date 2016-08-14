<?php
namespace backend\modules\news\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use thread\modules\seo\behaviors\SeoBehavior;
use thread\app\model\interfaces\BaseBackendModel;
//
use common\modules\news\models\Article as CommonArticleModel;
use common\modules\seo\models\Seo;
//
use backend\modules\news\News;

class Article extends CommonArticleModel implements BaseBackendModel
{

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Article())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Article())->trash($params);
    }

    /**
     * @return array
     */

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'SeoBehavior' => [
                    'class' => SeoBehavior::class,
                    'modelNamespace' => self::COMMON_NAMESPACE
                ],
            ]
        );
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'image_link', 'content'], 'required'],
            [['title', 'image_link', 'description', 'content', 'published_time'], 'string'],
            [['group_id', 'created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
        ];
    }


    //TODO Перемотреть
    /**
     * @return null|string
     */
    public function getArticleImage()
    {
        /** @var News $newsModule */
        $newsModule = Yii::$app->getModule('news');
        $path = $newsModule->getUploadPath() . 'article/';
        $url = $newsModule->getUploadUrl() . 'article/';
        $image = null;
        if (!empty($this->image_link) && file_exists($path . $this->image_link)) {
            $image = $url . $this->image_link;
        }
        return $image;
    }

    //TODO Убрать
    /**
     * @return array
     */
    public function getArticleGallery()
    {
        /** @var News $newsModule */
        $newsModule = Yii::$app->getModule('news');
        $path = $newsModule->getUploadPath() . 'article/';
        $url = $newsModule->getUploadUrl() . 'article/';
        $images = [];
        if (!empty($this->gallery_link)) {
            $this->gallery_link = $this->gallery_link[0] == ',' ? substr($this->gallery_link, 1) : $this->gallery_link;
            $images = explode(',', $this->gallery_link);
        }
        $imagesSources = [];
        foreach ($images as $image) {
            if (file_exists($path . $image)) {
                $imagesSources[] = $url . $image;
            }
        }
        return $imagesSources;
    }

    //TODO Что с этим делать
    /**
     * @return $this
     */
    public function getSeo()
    {
        return $this->hasOne(Seo::class, ['model_id' => 'id'])->andWhere(['model_namespace' => self::COMMON_NAMESPACE]);
    }
}
