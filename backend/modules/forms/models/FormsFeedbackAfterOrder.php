<?php

namespace backend\modules\forms\models;

/**
 * Class FormsFeedbackAfterOrder
 *
 * @package backend\modules\forms\models
 */
class FormsFeedbackAfterOrder extends \common\modules\forms\models\FormsFeedbackAfterOrder
{
    /**
     * @param $params
     * @return mixed
     */
    public function search($params)
    {
        return (new search\FormsFeedbackAfterOrder())->search($params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function trash($params)
    {
        return (new search\FormsFeedbackAfterOrder())->trash($params);
    }
}