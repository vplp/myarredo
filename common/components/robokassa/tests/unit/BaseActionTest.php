<?php

namespace common\components\robokassa\tests\unit;

use common\components\robokassa\Merchant;
use common\components\robokassa\SuccessAction;
use common\components\robokassa\tests\TestCase;
use Yii;
use yii\web\Controller;

class BaseActionTest extends TestCase
{
    public function testSuccess()
    {
        $this->mockWebApplication();

        $merchant = new Merchant([
            'sMerchantLogin' => 'demo',
            'sMerchantPass1' => 'password_1',
            'hashAlgo' => 'md5',
            'isTest' => true,
        ]);

        Yii::$app->set('robokassa', $merchant);

        $controller = new Controller('merchant', Yii::$app);

        $action = new SuccessAction('success', $controller, [
            //'callback' => function ($merchant, $nInvId, $nOutSum, $shp) { return 'SUCCESS'; }
        ]);

        $_REQUEST['OutSum'] = 100;
        $_REQUEST['InvId'] = 1;
        $_REQUEST['SignatureValue'] = md5('100:1:password_1');

        $this->expectException('yii\\base\\InvalidConfigException');
        $this->expectExceptionMessage('"robokassa\SuccessAction::callback" should be a valid callback.');

        $action->run();
    }
}
