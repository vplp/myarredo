<?php

namespace frontend\modules\seo\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Component;
use yii\log\Logger;
//
use frontend\modules\seo\modules\{
    modellink\models\Modellink,
    directlink\models\Directlink
};
use thread\app\base\models\ActiveRecord;

/**
 * Class MetaTag
 *
 * @package frontend\modules\seo\components
 */
class MetaTag extends Component
{
    protected $model = null;
    protected $direct_model = null;
    protected $local_url = '';

    public $seo_title = '';
    public $seo_description = '';
    protected $seo_keywords = '';
    protected $seo_robots = '';
    protected $seo_image_url = '';

    protected $set_seo_title = '';
    protected $set_seo_description = '';
    protected $set_seo_keywords = '';
    protected $set_seo_image_url = '';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->getLocalUrl();

        parent::init();
    }

    /**
     * @param string $title
     * @return $this
     */
    public function set_title(string $title)
    {
        $this->set_seo_title = $title;
        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function set_description(string $description)
    {
        $this->set_seo_description = $description;
        return $this;
    }

    /**
     * @param string $keywords
     * @return $this
     */
    public function set_keywords(string $keywords)
    {
        $this->set_seo_keywords = $keywords;
        return $this;
    }

    /**
     * @param string $image_url
     * @return $this
     */
    public function set_image_url(string $image_url)
    {
        $this->set_seo_image_url = $image_url;
        return $this;
    }

    /**
     * @param ActiveRecord $model
     * @return $this
     */
    public function registerModel(ActiveRecord $model)
    {
        $this->findModel(self::getModelKey($model), $model['id']);

        return $this;
    }

    /**
     * @return $this
     * @throws \yii\base\InvalidConfigException
     */
    protected function getLocalUrl()
    {
        $url = Yii::$app->getRequest()->getUrl();
        $base_url = Yii::$app->getRequest()->getBaseUrl();

        $local_url = str_replace($base_url, '', $url);

        $exp = explode('?', $local_url);

        $local_url = $exp[0];

        $this->local_url = $local_url;

        return $this;
    }

    /**
     * @return $this
     */
    protected function getDirectModel()
    {
        if (!empty($this->local_url)) {
            $this->direct_model = Directlink::find()->url($this->local_url)->enabled()->one();
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function analyze()
    {
        // LOW PRIORITY
        if ($this->model) {
            Yii::getLogger()->log('SEO MODEL REGISTER', Logger::LEVEL_INFO);

            $model = $this->model;

            $this->seo_title = $model['lang']['title'];
            $this->seo_description = $model['lang']['description'];
            $this->seo_keywords = $model['lang']['keywords'];
            $this->seo_robots = Modellink::statusMetaRobotsRange()[$model['meta_robots']];
            $this->seo_image_url = $model['image_url'];
        }

        // MIDDLE PRIORITY
        if (!empty($this->set_seo_title)) {
            $this->seo_title = $this->set_seo_title;
        }
        if (!empty($this->set_seo_description)) {
            $this->seo_description = $this->set_seo_description;
        }
        if (!empty($this->set_seo_keywords)) {
            $this->seo_keywords = $this->set_seo_keywords;
        }
        if (!empty($this->set_seo_image_url)) {
            $this->seo_image_url = $this->set_seo_image_url;
        }

        // TOP PRIORITY
        if ($this->direct_model) {
            Yii::getLogger()->log('DIRECT MODEL REGISTER', Logger::LEVEL_INFO);

            $model = $this->direct_model;

            if ($model->cities != null
                && !in_array(Yii::$app->city->getCityId(), ArrayHelper::map($model->cities, 'id', 'id'))
            ) {
                return $this;
            }

            $this->seo_title = (!empty($model['lang']['title'])) ? $model['lang']['title'] : $this->seo_title;
            $this->seo_description = (!empty($model['lang']['description'])) ? $model['lang']['description'] : $this->seo_description;
            $this->seo_keywords = (!empty($model['lang']['keywords'])) ? $model['lang']['keywords'] : $this->seo_keywords;
            $this->seo_robots = Directlink::statusMetaRobotsRange()[$model['meta_robots']];
            $this->seo_image_url = (!empty($model['image_url'])) ? $model['image_url'] : $this->seo_image_url;
        }

        $this->seo_title = str_replace(
            ['#городе#', '#nella citta#', '#телефон#'],
            [Yii::$app->city->getCityTitleWhere(), Yii::$app->city->getCityTitleWhere(), Yii::$app->partner->getPartnerPhone()],
            $this->seo_title
        );
        $this->seo_description = str_replace(
            ['#городе#', '#nella citta#', '#телефон#'],
            [Yii::$app->city->getCityTitleWhere(), Yii::$app->city->getCityTitleWhere(), Yii::$app->partner->getPartnerPhone()],
            $this->seo_description
        );

        return $this;
    }

    /**
     * @return $this
     */
    public function render()
    {
        $this->getDirectModel()->analyze();
        $view = Yii::$app->getView();

        $lang = substr(Yii::$app->language, 0, 2);
        $lang = $lang != 'ru' ? $lang . '/' : '';

        // title_register
        if ($this->seo_title) {
            $view->title = $this->seo_title;
        }

        // description_register
        if ($this->seo_description) {
            $view->registerMetaTag([
                'name' => 'description',
                'content' => $this->seo_description,
            ]);
        }

        // keywords_register
        if ($this->seo_keywords) {
            $view->registerMetaTag([
                'name' => 'keywords',
                'content' => $this->seo_keywords,
            ]);
        }

        // robots_register
        if ($this->seo_robots && !Yii::$app->getRequest()->get('page')) {
            $view->registerMetaTag([
                'name' => 'robots',
                'content' => $this->seo_robots,
            ]);

            $view->registerLinkTag([
                'rel' => 'canonical',
                'href' => Yii::$app->request->hostInfo . '/' . $lang . Yii::$app->request->pathInfo
            ]);
        } elseif (Yii::$app->getRequest()->get('page') && !in_array(Yii::$app->controller->id, ['sale', 'category'])) {
            $view->registerMetaTag([
                'name' => 'robots',
                'content' => 'index, follow',
            ]);

            $view->registerLinkTag([
                'rel' => 'canonical',
                'href' => Yii::$app->request->hostInfo . '/' . $lang . Yii::$app->request->pathInfo
            ]);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function render_graph()
    {
        $this->getDirectModel()->analyze();
        $view = Yii::$app->getView();

        // og_title_register
        $view->registerMetaTag([
            'property' => 'og:title',
            'content' => $this->seo_title,
        ]);

        // og_type_register
        $view->registerMetaTag([
            'property' => 'og:type',
            'content' => 'website',
        ]);

        // og_url_register
        $view->registerMetaTag([
            'property' => 'og:url',
            'content' => Yii::$app->getRequest()->getAbsoluteUrl(),
        ]);

        // og_url_register
        $view->registerMetaTag([
            'property' => 'og:description',
            'content' => $this->seo_description,
        ]);

        // og_image_register
        $view->registerMetaTag([
            'property' => 'og:image',
            'content' => $this->seo_image_url,
        ]);

        return $this;
    }

    /**
     * @param string $model_key
     * @param int $model_id
     * @return $this
     */
    public function findModel(string $model_key, int $model_id)
    {
        $this->model = Modellink::findModel($model_key, $model_id)->enabled()->one();

        return $this;
    }

    /**
     * @param ActiveRecord $model
     * @return string
     */
    public static function getModelKey(ActiveRecord $model)
    {
        return Modellink::getModelKey($model);
    }
}