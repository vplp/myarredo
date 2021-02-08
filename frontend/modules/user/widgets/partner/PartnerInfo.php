<?php

namespace frontend\modules\user\widgets\partner;

use Yii;
use yii\base\Widget;

/**
 * Class PartnerInfo
 *
 * @package frontend\modules\user\widgets\partner
 */
class PartnerInfo extends Widget
{
    /**
     * @var string
     */
    public $view = 'partner_info';

    /**
     * @return string
     */
    public function run()
    {
        $partner = Yii::$app->partner->getPartner();

        if ($partner) {
            return $this->render(
                $this->view,
                [
                    'partner' => $partner,
                    'city' => Yii::$app->city->getCity(),
                ]
            );
        }
    }
}
