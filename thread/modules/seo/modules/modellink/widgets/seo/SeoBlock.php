<?php

namespace thread\modules\seo\modules\modellink\widgets\seo;

use thread\app\base\widgets\Widget;
//
use thread\modules\seo\modules\modellink\models\Modellink;

/**
 * Class SeoBlock
 *
 * @package thread\modules\seo\modules\modellink\widgets\seo
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class SeoBlock extends Widget
{

    /**
     * @var string
     */
    public $view = 'SeoBlock';
    /**
     * @var null|ActiveForm
     */
    public $form = null;
    /**
     * @var null|ActiveRecord
     */
    public $model = null;

    //
    public $seo_title;
    public $seo_description;
    public $seo_keywords;
    public $seo_image_url;
    //

    /**
     * Seo model
     *
     * @var null
     */
    private $seo_model = null;

    /**
     *
     */
    public function init()
    {
        parent::init();

        //find model
        $this->seo_model = Modellink::findModel(Modellink::getModelKey($this->model), $this->model->id)->one();

        if ($this->seo_model == null) {
            $this->seo_model = new Modellink([
                'model_key' => Modellink::getModelKey($this->model),
                'model_id' => $this->model->id,
                'lang' => \Yii::$app->language
            ]);
        }

        $this->init_seo();
    }

    public function init_seo()
    {
        if (!empty($this->seo_title)) {
            $this->seo_model->title = $this->seo_title;
        }
        if (!empty($this->seo_description)) {
            $this->seo_model->description = $this->seo_description;
        }
        if (!empty($this->seo_keywords)) {
            $this->seo_model->keywords = $this->seo_keywords;
        }
        if (!empty($this->seo_image_url)) {
            $this->seo_model->image_url = $this->seo_image_url;
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render($this->view, [
            'form' => $this->form,
            'model' => $this->seo_model
        ]);
    }
}
