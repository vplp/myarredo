<?php

namespace backend\modules\files\models;

/**
 * Class Files
 *
 * @package backend\modules\files\models
 */
class Files extends \common\modules\files\models\Files
{
    /**
     * @param $params
     * @return mixed
     */
    public function search($params)
    {
        return (new search\Files())->search($params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function trash($params)
    {
        return (new search\Files())->trash($params);
    }
}