<?php

namespace common\components\robokassa;

use Yii;
use yii\web\BadRequestHttpException;

/**
 * Class FailAction
 *
 * @package common\components\robokassa
 */
class FailAction extends BaseAction
{

    /**
     * Runs the action.
     */
    public function run()
    {
        if (!isset($_REQUEST['OutSum'], $_REQUEST['InvId'])) {
            throw new BadRequestHttpException();
        }

        /** @var \robokassa\Merchant $merchant */
        $merchant = Yii::$app->get($this->merchant);

        $shp = [];
        foreach ($_REQUEST as $key => $param) {
            if (strpos(strtolower($key), 'shp') === 0) {
                $shp[$key] = $param;
            }
        }

        return $this->callback($merchant, $_REQUEST['InvId'], $_REQUEST['OutSum'], $shp);
    }
}
