<?php

namespace console\controllers;

use Yii;
use SoapClient;
use SimpleXMLElement;
//
use yii\helpers\Console;
use yii\console\Controller;
//
use common\modules\location\models\Currency;

/**
 * Class ExchangeRatesController
 *
 * @package console\controllers
 */
class ExchangeRatesController extends Controller
{
    /**
     * Generate product it title
     */
    public function actionUpdate()
    {
        $this->stdout("ExchangeRates update: start. \n", Console::FG_GREEN);

        $wsdl = 'http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL';

        $client = new SoapClient($wsdl, [
            'exceptions' => 1,
            'cache_wsdl' => WSDL_CACHE_MEMORY,
        ]);

        $result = $client->GetCursOnDate([
            'On_date' => date('Y-m-d'),
        ]);

        $data = new SimpleXMLElement($result->GetCursOnDateResult->any);

        foreach ($data->ValuteData->ValuteCursOnDate as $curs) {
            $currency = Currency::findByCode2($curs->VchCode);

            /** @var Currency $currency */

            if ($currency != null) {
                $currency->setScenario('setCourse');

                $currency->course = floatval($curs->Vcurs) / floatval($curs->Vnom);

                $currency->save();
            }
        }

        $this->stdout("ExchangeRates update: finish. \n", Console::FG_GREEN);
    }
}
