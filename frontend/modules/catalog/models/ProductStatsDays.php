<?php

namespace frontend\modules\catalog\models;

/**
 * Class ProductStatsDays
 *
 * @package frontend\modules\catalog\models
 */
class ProductStatsDays extends \common\modules\catalog\models\ProductStatsDays
{
    /**
     * @param $params
     * @return mixed
     */
    public function search($params)
    {
        return (new search\ProductStatsDays())->search($params);
    }

    public function factorySearch($params)
    {
        return (new search\ProductStatsDays())->factorySearch($params);
    }
}
