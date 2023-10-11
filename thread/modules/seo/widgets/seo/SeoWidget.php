<?php

namespace thread\modules\seo\widgets\seo;

use Yii;
//
use thread\app\base\widgets\Widget;
use thread\modules\seo\models\{
    Seo, SeoLang
};

/**
 * Class ActionDeleteColumn
 * @package thread\app\components\grid
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class SeoWidget extends Widget
{

    /**
     * Namespace на common модели
     *
     * @var null
     */

    public $nameSpaceModel = null;


    /**
     * Namespace на thread модели
     *
     * @var null
     */

    public $modelId = null;


    /**
     * View
     *
     * @var string
     */
    public $view = 'SeoWidgetView';


    /**
     * Seo model
     *
     * @var null
     */
    private $model = null;


    /**
     * Model lang
     *
     * @var null
     */
    private $modelLang = null;


    /**
     * Run run run
     *
     * @return string
     */
    public function init()
    {
        if ($this->modelId === null) {
            $this->modelId = Yii::$app->getRequest()->get('id', null);
        }

        $this->model = Seo::getModelByNamespace($this->nameSpaceModel, $this->modelId);
        $this->modelLang = (isset($this->model->lang)) ? $this->model->lang : new SeoLang();
    }


    /**
     * Run run run
     *
     * @return string
     */
    public function run()
    {
        return $this->render($this->view, ['model' => $this->model, 'modelLang' => $this->modelLang]);
    }
}
