Yii2 reCAPTCHA v3
=================
Yii2 reCAPTCHA v3

Usage
-----

Once the extension is installed, simply use it in your code by  :

add this to your components main.php

```php
'components' => [
        ...
        'recaptchaV3' => [
            'class' => \frontend\widgets\recaptcha3\RecaptchaV3::class,
            'site_key' => '###',
            'secret_key' => '###',
        ],

```

and in your model

acceptance_score the minimum score for this request (0.0 - 1.0) or null

```php
public $code;
 
 public function rules(){
 	return [
 		...
 		 [['code'], RecaptchaV3Validator::className(), 'acceptance_score' => null]
 	];
    }
```

```php
   <?= $form->field($model,'code')->widget(\frontend\widgets\recaptcha3\RecaptchaV3Widget::className());
```


