Google reCAPTCHA widget for Yii2
================================
Based on reCaptcha API 2.0.


* [Sign up for an reCAPTCHA API keys](https://www.google.com/recaptcha/admin#createsite).

* Configure the component in your configuration file (web.php). The parameters siteKey and secret are optional.
But if you leave them out you need to set them in every validation rule and every view where you want to use this widget.
If a siteKey or secret is set in an individual view or validation rule that would overrule what is set in the config.

```php
'components' => [
    'reCaptcha' => [
        'name' => 'reCaptcha',
        'class' => 'recaptcha\ReCaptcha',
        'siteKey' => 'your siteKey',
        'secret' => 'your secret key',
    ],
    ...
```

* Add `ReCaptchaValidator` in your model, for example:

```php
public $reCaptcha;

public function rules()
{
  return [
      // ...
      [['reCaptcha'], \recaptcha\ReCaptchaValidator::className(), 'secret' => 'your secret key', 'uncheckedMessage' => 'Please confirm that you are not a bot.']
  ];
}
```

or just

```php
public function rules()
{
  return [
      // ...
      [[], \recaptcha\ReCaptchaValidator::className(), 'secret' => 'your secret key']
  ];
}
```

or simply

```php
public function rules()
{
  return [
      // ...
      [[], \recaptcha\ReCaptchaValidator::className()]
  ];
}
```

Usage
-----
For example:

```php
<?= $form->field($model, 'reCaptcha')->widget(
    \recaptcha\ReCaptcha::className(),
    ['siteKey' => 'your siteKey']
) ?>
```

or

```php
<?= $form->field($model, 'reCaptcha')->widget(\recaptcha\ReCaptcha::className()) ?>
```

or

```php
<?= \recaptcha\ReCaptcha::widget([
    'name' => 'reCaptcha',
    'siteKey' => 'your siteKey',
    'widgetOptions' => ['class' => 'col-sm-offset-3']
]) ?>
```

or simply

```php
<?= \recaptcha\ReCaptcha::widget(['name' => 'reCaptcha']) ?>
```

* NOTE: Please disable ajax validation for ReCaptcha field!

Resources
---------
* [Google reCAPTCHA](https://developers.google.com/recaptcha)
