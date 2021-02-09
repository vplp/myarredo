<?php

namespace frontend\modules\user\components;

use Yii;
use yii\base\Component;
use frontend\modules\user\models\User;

/**
 * Class PartnerComponent
 *
 * @package frontend\modules\user\components
 */
class PartnerComponent extends Component
{
    /** @var object */
    private $partner;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setup();

        parent::init();
    }

    /**
     * @return object
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->partner[$name] ?? '';
    }

    /**
     * @return object
     */
    public function getPartnerPhone()
    {
        if ($this->partner) {
            return ($this->partner['profile']['additional_phone'] != '')
                ? $this->partner['profile']['additional_phone']
                : $this->partner['profile']['phone'];
        } elseif (DOMAIN_TYPE == 'ru') {
            return '8 (800) 302 92 95';
        }

        return '';
    }

    /**
     * @inheritdoc
     */
    private function setup()
    {
        $this->partner = User::getPartner(Yii::$app->city->getCityId());
    }
}
