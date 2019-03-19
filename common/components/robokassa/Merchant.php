<?php

namespace common\components\robokassa;

use Yii;
use yii\base\BaseObject;

/**
 * Class Merchant
 *
 * @package common\components\robokassa
 */
class Merchant extends BaseObject
{
    public $sMerchantLogin;

    public $sMerchantPass1;
    public $sMerchantPass2;

    public $isTest = false;

    public $baseUrl = 'https://auth.robokassa.ru/Merchant/Index.aspx';

    public $hashAlgo = 'md5';

    /**
     * @param $nOutSum
     * @param $nInvId
     * @param $sOutSumCurrency
     * @param null $sInvDesc
     * @param null $sIncCurrLabel
     * @param null $sEmail
     * @param null $sCulture
     * @param array $shp
     * @param bool $returnLink
     * @return string|\yii\console\Response|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function payment($nOutSum, $nInvId, $sOutSumCurrency = null, $sInvDesc = null, $sIncCurrLabel = null, $sEmail = null, $sCulture = null, $shp = [], $returnLink = false)
    {
        $url = $this->baseUrl;

        $signature = "{$this->sMerchantLogin}:{$nOutSum}:{$nInvId}:{$sOutSumCurrency}:{$this->sMerchantPass1}";

        if (!empty($shp)) {
            $signature .= ':' . $this->implodeShp($shp);
        }

        $sSignatureValue = $this->encryptSignature($signature);

        $url .= '?' . http_build_query([
                'MrchLogin' => $this->sMerchantLogin,
                'OutSum' => $nOutSum,
                'OutSumCurrency' => $sOutSumCurrency,
                'InvId' => $nInvId,
                'Desc' => $sInvDesc,
                'SignatureValue' => $sSignatureValue,
                'IncCurrLabel' => $sIncCurrLabel,
                'Email' => $sEmail,
                'Culture' => $sCulture,
                'IsTest' => $this->isTest ? 1 : null,
            ]);

        if (!empty($shp) && ($query = http_build_query($shp)) !== '') {
            $url .= '&' . $query;
        }

        if (!$returnLink) {
            Yii::$app->user->setReturnUrl(Yii::$app->request->getUrl());
            return Yii::$app->response->redirect($url);
        } else {
            return $url;
        }
    }

    /**
     * @param $shp
     * @return string
     */
    private function implodeShp($shp)
    {
        ksort($shp);

        foreach ($shp as $key => $value) {
            $shp[$key] = $key . '=' . $value;
        }

        return implode(':', $shp);
    }

    /**
     * @param $sSignatureValue
     * @param $nOutSum
     * @param $nInvId
     * @param $sMerchantPass
     * @param array $shp
     * @return bool
     */
    public function checkSignature($sSignatureValue, $nOutSum, $nInvId, $sMerchantPass, $shp = [])
    {
        $signature = "{$nOutSum}:{$nInvId}:{$sMerchantPass}";

        if (!empty($shp)) {
            $signature .= ':' . $this->implodeShp($shp);
        }

        return strtolower($this->encryptSignature($signature)) === strtolower($sSignatureValue);
    }

    /**
     * @param $signature
     * @return string
     */
    protected function encryptSignature($signature)
    {
        return hash($this->hashAlgo, $signature);
    }
}
