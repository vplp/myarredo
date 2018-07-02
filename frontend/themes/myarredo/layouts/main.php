<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\themes\myarredo\assets\AppAsset;
use frontend\themes\myarredo\widgets\Alert;
use frontend\modules\sys\models\Language;

$bundle = AppAsset::register($this);

$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="<?= substr(Yii::$app->language,0,2) ?>">
    <head>
        <base href="<?= Yii::$app->request->hostInfo ?>">

        <?php
        $langs = Language::getAllByLocate();
        $current_url = Url::current();

        foreach ($langs as $alternate) {
            $alternatePages[$alternate['local']] = [
                'href' => Yii::$app->request->hostInfo . ($alternate['alias'] != 'ru' ? '/' . $alternate['alias'] : '') . str_replace('/' . $langs[Yii::$app->language]['alias'], '', $current_url),
                'lang' => substr($alternate['local'], 0, 2),
                'current' => (Yii::$app->language == $alternate['local']) ? true : false
            ];
        }

        if (!empty($alternatePages)) {
            $current_link = $alternatePages[Yii::$app->language];
            unset($alternatePages[Yii::$app->language]);
            echo Html::tag('link', '', [
                'rel' => 'alternate',
                'href' =>  $current_link['href'],
                'hreflang' => $current_link['lang'] . '-' . 'ru'
            ]);
            foreach ($alternatePages as $page) {
                echo Html::tag('link', '', [
                    'rel' => 'alternate',
                    'href' => $page['href'],
                    'hreflang' => $page['lang'] . '-' . 'ru'
                ]);
            }
            unset($current_link, $alternatePages);
        }
        ?>

        <meta charset="<?= Yii::$app->charset ?>"/>
        <title><?= $this->title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php $this->head(); ?>
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js" type="text/javascript"
                charset="UTF-8"></script>
        <![endif]-->
    </head>
    <body>
    <?php $this->beginBody() ?>

    <?= Alert::widget() ?>

    <?= $this->render('parts/_header', ['bundle' => $bundle]) ?>

    <?= $content ?>

    <?= $this->render('parts/_footer', []) ?>

    <?= $this->render('parts/_jivosite', []) ?>

    <?= $this->render('parts/_yandex_metrika', []) ?>

    <?= $this->render('parts/_google_metrika', []) ?>

    <input type="hidden" id="token" value="<?= Yii::$app->request->getCsrfToken() ?>">

    <?php $this->endBody() ?>

    </body>
    </html>
<?php $this->endPage() ?>