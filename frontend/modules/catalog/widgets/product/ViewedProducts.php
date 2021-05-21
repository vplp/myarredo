<?php

namespace frontend\modules\catalog\widgets\product;

use Yii;
use yii\base\Exception;
use yii\base\Widget;
use frontend\modules\catalog\models\Sale;

/**
 * Class ViewedProducts
 *
 * @property string $view
 * @property string $modelClass
 * @property string $modelLangClass
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
     * @var string
     */
    public $modelLangClass = null;

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
        $modelLangClass = new $this->modelLangClass();

        $IDs = [];

        if (isset(Yii::$app->request->cookies[$this->cookieName])) {
            $IDs = unserialize(Yii::$app->request->cookies->getValue($this->cookieName));
        }

        if (!empty($IDs)) {
            $query = $modelClass::findBase()->byID($IDs)->asArray();

            if ($this->cookieName != 'viewed_sale') {
                $query->select([
                    $modelClass::tableName() . '.id',
                    $modelClass::tableName() . '.alias',
                    $modelClass::tableName() . '.alias_en',
                    $modelClass::tableName() . '.alias_it',
                    $modelClass::tableName() . '.alias_de',
                    $modelClass::tableName() . '.alias_fr',
                    $modelClass::tableName() . '.alias_he',
                    $modelClass::tableName() . '.image_link',
                    $modelClass::tableName() . '.factory_id',
                    $modelLangClass::tableName() . '.title',
                ]);
            } else {
                $query->select([
                    $modelClass::tableName() . '.id',
                    $modelClass::tableName() . '.alias',
                    $modelClass::tableName() . '.image_link',
                    $modelClass::tableName() . '.factory_id',
                    $modelLangClass::tableName() . '.title',
                ]);
            }

            $this->models = $query->all();
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
