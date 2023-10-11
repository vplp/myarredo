<?php

namespace backend\modules\forms\models;

/**
 * Class FormsFeedback
 *
 * @package backend\modules\forms\models
 */
class FormsFeedback extends \common\modules\forms\models\FormsFeedback
{
    /**
     * @param $params
     * @return mixed
     */
    public function search($params)
    {
        return (new search\FormsFeedback())->search($params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function trash($params)
    {
        return (new search\FormsFeedback())->trash($params);
    }
}