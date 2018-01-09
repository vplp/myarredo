<?php

namespace frontend\modules\user\components;

use Yii;
use yii\base\Component;
//
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
     * @return object
     */
    public function getPartnerPhone()
    {
        return $this->partner['profile']['phone'];
    }

    /**
     * @inheritdoc
     */
    private function setup()
    {
        $this->partner = User::getPartner(Yii::$app->city->getCityId());
    }
}