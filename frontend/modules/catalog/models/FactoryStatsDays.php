<?php

namespace frontend\modules\catalog\models;

/**
 * Class FactoryStatsDays
 *
 * @package frontend\modules\catalog\models
 */
class FactoryStatsDays extends \common\modules\catalog\models\FactoryStatsDays
{
    /**
     * @param $params
     * @return mixed
     */
    public function search($params)
    {
        return (new search\FactoryStatsDays())->search($params);
    }
}
