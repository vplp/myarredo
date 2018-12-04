<?php

namespace common\components\robokassa\actions;

use yii\base\Action;
use yii\base\InvalidConfigException;

/**
 * Class BaseAction
 *
 * @package common\components\robokassa\actions
 */
class BaseAction extends Action
{
    public $merchant = 'robokassa';

    public $callback;

    /**
     * @param Merchant $merchant Merchant.
     * @param $nInvId
     * @param $nOutSum
     * @param $shp
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    protected function callback($merchant, $nInvId, $nOutSum, $shp)
    {
        if (!is_callable($this->callback)) {
            throw new InvalidConfigException('"' . get_class($this) . '::callback" should be a valid callback.');
        }
        $response = call_user_func($this->callback, $merchant, $nInvId, $nOutSum, $shp);
        return $response;
    }
}
