<?php

namespace frontend\modules\user\components;

use Yii;
use yii\base\Component;

/**
 * Class PartnerComponent
 *
 * @package frontend\modules\user\components
 */
class UserIpComponent extends Component
{
    /** @var string */
    public $ip;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        $this->ip = $this->RealIP();
    }

    /**
     * @return string
     */
    private function RealIP() {
    $ip = false;
    $seq = array('HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR'
        , 'HTTP_X_FORWARDED'
        , 'HTTP_X_CLUSTER_CLIENT_IP'
        , 'HTTP_FORWARDED_FOR'
        , 'HTTP_FORWARDED'
        , 'REMOTE_ADDR');

    foreach ($seq as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                    return $ip;
                }
            }
        }
    }
}
}
