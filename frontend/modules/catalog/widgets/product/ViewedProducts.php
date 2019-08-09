<?php

namespace frontend\modules\catalog\widgets\product;

use Yii;
//
use yii\base\Exception;
use yii\base\Widget;

/**
 * Class ViewedProducts
 *
 * @property string $view
 * @property string $modelClass
 * @property string $cookieName
 * @property object $models
 *
 * @package frontend\modules\catalog\widgets\products
 */
class ViewedProducts extends Widget
{
    /**
     * @var string
     */
    public $view = 'viewed_products';

    /**
     * @var string
     */
    public $cookieName = null;

    /**
     * @var string
     */
    public $modelClass = null;

    /**
     * @var object
     */
    protected $models = null;

    /**
     * Init model for run method
     */
    public function init()
    {
        if ($this->modelClass === null) {
            throw new Exception(__CLASS__ . '::$modelClass must be set.');
        }

        if ($this->cookieName === null) {
            throw new Exception(__CLASS__ . '::$cookieName must be set.');
        }

        $modelClass = new $this->modelClass();

        $IDs = [];

        if (isset(Yii::$app->request->cookies[$this->cookieName])) {
            $IDs = unserialize(Yii::$app->request->cookies->getValue($this->cookieName));
        }

        if (!empty($IDs)) {
            $this->models = $modelClass::findBase()->byID($IDs)->asArray()->all();
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render(
            $this->view,
            [
                'products' => $this->models,
                'modelClass' => $this->modelClass
            ]
        );
    }
}
