<?php

namespace api\components;

use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;

/**
 * Class RestController
 *
 * @package api\components
 */
abstract class RestController extends Controller
{
    /**
     * @return array|array[]
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'pattern' => '/(.*?)$/'
        ];

        return $behaviors;
    }
}
