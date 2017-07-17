<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
return [
    'languages' => [
        'class' => \thread\app\model\Languages::class,
        'languageModel' => \thread\modules\sys\models\Language::class,
    ],
    'user' => [
        'class' => \yii\web\User::class,
        'identityClass' => \thread\modules\user\models\User::class,
        'enableAutoLogin' => false,
        'loginUrl' => ['/user/login']
    ],
    'view' => [
        'class' => \yii\web\View::class,
        'renderers' => [
            'mustache' => \yii\mustache\ViewRenderer::class
        ]
    ],
    'i18n' => [
        'class' => \thread\modules\sys\modules\translation\components\I18N::class,
        'languageModel' => \thread\modules\sys\models\Language::class,
        'enableCaching' => false,
        'cachingDuration' => 3600
    ],
];
