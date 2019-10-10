<?php

namespace common\components\translate;

use yii\base\Component;

/**
 * Class YandexTranslation
 *
 * @package common\components
 */
class YandexTranslation extends Component
{
    public $folder_id;

    const API_URL = 'https://translate.api.cloud.yandex.net/translate/v2/translate';

    public function translate($text, $sourceLanguageCode, $targetLanguageCode)
    {
        return $this->getResponse($text, $sourceLanguageCode, $targetLanguageCode);
    }

    protected function getResponse($text = '', $sourceLanguageCode = 'en', $targetLanguageCode = 'ru')
    {
        $request = self::API_URL . '?' . http_build_query([
                'sourceLanguageCode' => $sourceLanguageCode,
                'targetLanguageCode' => $targetLanguageCode,
                'format' => 'PLAIN_TEXT',
                'texts' => [Html::encode($text)],
            ]);
        $response = file_get_contents($request);

        return Json::decode($response, true);
    }
}
