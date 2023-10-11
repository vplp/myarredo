<?php

namespace frontend\modules\catalog\models;

/**
 * Class ItalianProductStatsDays
 *
 * @package frontend\modules\catalog\models
 */
class ItalianProductStatsDays extends \common\modules\catalog\models\ItalianProductStatsDays
{
    /**
     * @param $params
     * @return mixed
     */
    public function search($params)
    {
        return (new search\ItalianProductStatsDays())->search($params);
    }

    public function factorySearch($params)
    {
        return (new search\ItalianProductStatsDays())->factorySearch($params);
    }
}
