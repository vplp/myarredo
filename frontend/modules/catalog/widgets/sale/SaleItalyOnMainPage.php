<?php

namespace frontend\modules\catalog\widgets\sale;

use Yii;
use yii\base\Widget;
use frontend\modules\catalog\models\{ItalianProduct, ItalianProductLang, search\Specification};

/**
 * Class SaleItalyOnMainPage
 *
 * @package frontend\modules\catalog\widgets\sale
 */
class SaleItalyOnMainPage extends Widget
{
    /**
     * @var string
     */
    public $view = 'sale_italy_on_main_page';

    /**
     * @var object
     */
    protected $models = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->models = ItalianProduct::getDb()->cache(function ($db) {
            /** orderBy */

            if (!empty(Yii::$app->partner) && Yii::$app->partner->id) {
                $order['FIELD (' . ItalianProduct::tableName() . '.user_id, ' . Yii::$app->partner->id . ')'] = SORT_DESC;
            }

            if (DOMAIN_TYPE == 'com') {
                $order['(CASE WHEN ' . Specification::tableName() . '.id = 28 THEN 0 ELSE 1 END), ' . ItalianProduct::tableName() . '.position'] = SORT_DESC;
            }

            $order[ItalianProduct::tableName() . '.updated_at'] = SORT_DESC;

            return ItalianProduct::findBaseArray()
                ->select([
                    ItalianProduct::tableName() . '.id',
                    ItalianProduct::tableName() . '.alias',
                    ItalianProduct::tableName() . '.alias_en',
                    ItalianProduct::tableName() . '.alias_it',
                    ItalianProduct::tableName() . '.alias_de',
                    ItalianProduct::tableName() . '.alias_fr',
                    ItalianProduct::tableName() . '.alias_he',
                    ItalianProduct::tableName() . '.image_link',
                    ItalianProduct::tableName() . '.factory_id',
                    ItalianProduct::tableName() . '.bestseller',
                    ItalianProduct::tableName() . '.price',
                    ItalianProduct::tableName() . '.price_new',
                    ItalianProduct::tableName() . '.currency',
                    ItalianProductLang::tableName() . '.title',
                ])
                ->innerJoinWith(["specification"])
                ->limit(8)
                ->orderBy($order)
                ->all();
        }, 7200);


        if ($this->models != null) {
            $i = 0;
            $_models = [];
            foreach ($this->models as $key => $model) {
                if ($key % 3 == 0) {
                    $i++;
                }
                $_models[$i][] = $model;
            }
            $this->models = $_models;
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        if (!empty($this->models)) {
            return $this->render(
                $this->view,
                [
                    'models' => $this->models
                ]
            );
        }
    }
}
