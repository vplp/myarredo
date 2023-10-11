Yandex Translation API v1 and API v2

API v2:

https://translate.yandex.ru/developers/keys

API v2:

https://console.cloud.yandex.ru/cloud

https://cloud.yandex.ru/docs/translate/quickstart

https://cloud.yandex.ru/docs/translate/api-ref/Translation/translate

Create `yandex_translation_private.pem`

Add into your `composer.json`:

```json
{
  "autoload": {
    "psr-4": {
      "Jose\\": "common/components/translation/jwt-framework/src"
    }
  },
}
```
Console: `composer dump-autoload -o`

Add into `components`:

```php
'yandexTranslation' => [
    'class' => \common\components\translation\YandexTranslation::class,
    'folder_id' => \getenv('YANDEX_TRANSLATION_FOLDER_ID'),
    'service_account_id' => \getenv('YANDEX_TRANSLATION_SERVICE_ACCOUNT_ID'),
    'service_account_key_id' => \getenv('YANDEX_TRANSLATION_SERVICE_ACCOUNT_KEY_ID'),
],
```
Use v2

```php
$translate = Yii::$app->yandexTranslation->translate('Hello world', 'en', 'ru');
```

Use v1 and v2

```php
$translate = Yii::$app->yandexTranslation->getTranslate('Hello world', 'en', 'ru');
```