<?php

namespace common\components\translate;

use Yii;
use yii\base\Component;
use yii\helpers\{
    Html, Json
};
//
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\Converter\StandardConverter;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Algorithm\PS256;
use Jose\Component\Signature\Serializer\CompactSerializer;

/**
 * Class YandexTranslation
 *
 * @package common\components
 */
class YandexTranslation extends Component
{
    const API_URL = 'https://translate.api.cloud.yandex.net/translate/v2/translate';

    /**
     * @var string
     */
    public $folder_id;

    /**
     * @var string
     */
    public $token = '';

    /**
     * @var resource
     */
    protected $handler;

    public function translate($text, $sourceLanguageCode, $targetLanguageCode)
    {
        $service_account_id = 'ajefihkpokcn0i8q8oao';
        $key_id = 'b1gi4aabjn0khc57n7p1';

        $jsonConverter = new StandardConverter();
        $algorithmManager = AlgorithmManager::create([
            new PS256()
        ]);

        $jwsBuilder = new JWSBuilder($jsonConverter, $algorithmManager);

        $now = time();

        $claims = [
            'aud' => 'https://iam.api.cloud.yandex.net/iam/v1/tokens',
            'iss' => $service_account_id,
            'iat' => $now,
            'exp' => $now + 360
        ];

        $header = [
            'alg' => 'PS256',
            'typ' => 'JWT',
            'kid' => $key_id
        ];

        $key = JWKFactory::createFromKeyFile(Yii::getAlias('@uploads') . '/private.pem');

        $payload = $jsonConverter->encode($claims);

        // Формирование подписи.
        $jws = $jwsBuilder
            ->create()
            ->withPayload($payload)
            ->addSignature($key, $header)
            ->build();

        $serializer = new CompactSerializer($jsonConverter);

        // Формирование JWT.
        $token = $serializer->serialize($jws);

        /* !!! */ echo  '<pre style="color:red;">'; print_r($token); echo '</pre>'; /* !!! */
        //die;

        $headers = array(
            "Authorization: Bearer $token",                   // OAuth-токен. Использование слова Bearer обязательно
            //"Client-Login: $clientLogin",                     // Логин клиента рекламного агентства
            //"Accept-Language: ru",                            // Язык ответных сообщений
            "Content-Type: application/json; charset=utf-8"   // Тип данных и кодировка запроса
        );

        $params = [
            'sourceLanguageCode' => $sourceLanguageCode,
            'targetLanguageCode' => $targetLanguageCode,
            'texts' => [Html::encode($text)],
            'folder_id' => $this->folder_id
        ];
        // Преобразование входных параметров запроса в формат JSON
        $body = json_encode($params, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Инициализация cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, self::API_URL);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

        /*
        Для полноценного использования протокола HTTPS можно включить проверку SSL-сертификата сервера API Директа.
        Чтобы включить проверку, установите опцию CURLOPT_SSL_VERIFYPEER в true, а также раскомментируйте строку с опцией CURLOPT_CAINFO и укажите путь к локальной копии корневого SSL-сертификата.
        */
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_CAINFO, getcwd().'\CA.pem');

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        // Выполнение запроса, получение результата
        $result = curl_exec($curl);

        return $result;
    }

    protected function getPostResponse($text = '', $sourceLanguageCode = 'en', $targetLanguageCode = 'ru')
    {
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query([
                    'sourceLanguageCode' => $sourceLanguageCode,
                    'targetLanguageCode' => $targetLanguageCode,
                    //'format' => 'PLAIN_TEXT',
                    'texts' => [Html::encode($text)],
                    'folder_id' => $this->folder_id,
                ])
            )
        );
        $context = stream_context_create($opts);
        $response = file_get_contents(self::API_URL, false, $context);
        return Json::decode($response, true);
    }

    protected function getResponse($text = '', $sourceLanguageCode = 'en', $targetLanguageCode = 'ru')
    {
        $request = self::API_URL . '?' . http_build_query([
                'sourceLanguageCode' => $sourceLanguageCode,
                'targetLanguageCode' => $targetLanguageCode,
                //'format' => 'PLAIN_TEXT',
                'texts' => [Html::encode($text)],
                'folder_id' => $this->folder_id,
            ]);
        $response = file_get_contents($request);

        return Json::decode($response, true);
    }
}
