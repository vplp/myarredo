<?php

namespace frontend\widgets\recaptcha3;

use Yii;
use Exception;
use yii\base\Component;
use yii\helpers\Json;
use yii\web\View;

/**
 * Class RecaptchaV3
 *
 * @package frontend\widgets\recaptcha3
 */
class RecaptchaV3 extends Component
{
    /** @var string */
    public $site_key = null;

    /** @var string */
    public $secret_key = null;

    /** @var string */
    public $apiJs = 'https://www.google.com/recaptcha/api.js';

    /** @var string */
    private $apiRequestUrl = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * @throws Exception
     */
    public function init()
    {
        parent::init();

        if (empty($this->site_key)) {
            throw new Exception('site key cant be null');
        }
        if (empty($this->secret_key)) {
            throw new Exception('secret key cant be null');
        }
    }

    /**
     * @param $view
     */
    public function registerScript($view)
    {
        $lang = substr(Yii::$app->language, 0, 2);

        /** @var View $view */
        $view->registerJsFile(
            $this->apiJs . '?render=' . $this->site_key . '&hl=' . $lang,
            [
                'async' => true,
                'defer' => true,
                'position' => $view::POS_HEAD,
            ],
            'recaptcha-v3-script'
        );
    }

    /**
     * @param $value
     * @return bool|string
     */
    public function getResponse($value)
    {
        try {
            $response = $this->curl([
                'secret' => $this->secret_key,
                'response' => $value,
                'remoteip' => Yii::$app->has('request') ? Yii::$app->request->userIP : null,
            ]);

            return $response;
        } catch (Exception $e) {
            return false;
        }

        return false;
    }

    /**
     * @param array $params
     * @return mixed
     */
    protected function curl(array $params)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->apiRequestUrl);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);

        $curlData = curl_exec($curl);
        curl_close($curl);

        return Json::decode($curlData, true);
    }
}
