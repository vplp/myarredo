<?php

namespace frontend\modules\catalog\models;

/**
 * Class SaleStatsDays
 *
 * @package frontend\modules\catalog\models
 */
class SaleStatsDays extends \common\modules\catalog\models\SaleStatsDays
{
    /**
     * @param $params
     * @return mixed
     */
    public function search($params)
    {
        return (new search\SaleStatsDays())->search($params);
    }

    public function factorySearch($params)
    {
        return (new search\SaleStatsDays())->factorySearch($params);
    }
}
