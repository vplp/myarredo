<?php

namespace common\components\translation;

use Yii;
use yii\base\Component;
use yii\helpers\{
    Html, Json
};
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\Converter\StandardConverter;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Algorithm\PS256;
use Jose\Component\Signature\Serializer\CompactSerializer;
use Yandex\Translate\Translator;
use Yandex\Translate\Exception;

/**
 * Class YandexTranslation
 *
 * @package common\components\translation
 */
class YandexTranslation extends Component
{
    /**
     * @var string
     */
    public $folder_id;

    /**
     * @var string
     */
    public $service_account_id;

    /**
     * @var string
     */
    public $service_account_key_id;

    /**
     * Get jwt token
     *
     * @return string
     * @throws \Exception
     */
    protected function jwtToken()
    {
        $jsonConverter = new StandardConverter();
        $algorithmManager = AlgorithmManager::create([
            new PS256()
        ]);

        $jwsBuilder = new JWSBuilder($jsonConverter, $algorithmManager);

        $now = time();

        $claims = [
            'aud' => 'https://iam.api.cloud.yandex.net/iam/v1/tokens',
            'iss' => $this->service_account_id,
            'iat' => $now,
            'exp' => $now + 60 * 60 * 1
        ];

        $header = [
            'alg' => 'PS256',
            'typ' => 'JWT',
            'kid' => $this->service_account_key_id
        ];

        $key = JWKFactory::createFromKeyFile(Yii::getAlias('@uploads') . '/yandex_translation_private.pem');

        $payload = $jsonConverter->encode($claims);

        // Signature creation.
        $jws = $jwsBuilder
            ->create()
            ->withPayload($payload)
            ->addSignature($key, $header)
            ->build();

        $serializer = new CompactSerializer($jsonConverter);

        // JWT generation.
        $jwtToken = $serializer->serialize($jws);

        return $jwtToken;
    }

    /**
     * Exchange the JWT for an IAM token
     *
     * @param string $jwtToken
     * @return string
     */
    protected function iamToken(string $jwtToken)
    {
        $headers = array(
            "Content-Type: application/json; charset=utf-8"
        );

        $params = [
            'jwt' => $jwtToken
        ];

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_URL, 'https://iam.api.cloud.yandex.net/iam/v1/tokens');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($curl);

        if (!$result) {
            die("Connection Failure");
        }

        curl_close($curl);

        $result = json_decode($result);

        return $result->iamToken;
    }

    /**
     * @param $text
     * @param $sourceLanguageCode
     * @param $targetLanguageCode
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function translate($text, $sourceLanguageCode, $targetLanguageCode)
    {
        $jwtToken = $this->jwtToken();

        $iamToken = $this->iamToken($jwtToken);

        $headers = array(
            "Authorization: Bearer $iamToken",
            "Content-Type: application/json; charset=utf-8"
        );

        $params = [
            'sourceLanguageCode' => $sourceLanguageCode,
            'targetLanguageCode' => $targetLanguageCode,
            'texts' => [Html::encode($text)],
            'folder_id' => $this->folder_id
        ];

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_URL, 'https://translate.api.cloud.yandex.net/translate/v2/translate');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($curl);

        if (!$result) {
            die("Connection Failure");
        }

        curl_close($curl);

        $result = json_decode($result);

        return isset($result->translations) ? $result->translations[0]->text : '';
    }

    public $key;

    /**
     * @param $text
     * @param $sourceLanguageCode
     * @param $targetLanguageCode
     * @return bool|string
     * @throws \Exception
     */
    public function getTranslate($text, $sourceLanguageCode, $targetLanguageCode)
    {
        try {
//            // Api v1
//            $translator = new Translator($this->key);
//            $translation = $translator->translate($text, $sourceLanguageCode . '-' . $targetLanguageCode);
//
//            if ($translation != '') {
//                return (string)$translation;
//            } else {
//                // Api v2
//                $translation = $this->translate($text, $sourceLanguageCode, $targetLanguageCode);
//                return (string)$translation;
//            }
            // Api v2
            $translation = $this->translate($text, $sourceLanguageCode, $targetLanguageCode);
            return (string)$translation;
        } catch (Exception $e) {
            // handle exception
            return false;
        }
    }
}
