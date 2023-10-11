<?php

/**
use thread\actions\fileapi\UploadBehavior;

public function behaviors()
{
    $module = Yii::$app->getModule('news');
    $path = $module->getArticleUploadPath();
    $url = $module->getArticleUploadPath();

    return ArrayHelper::merge(parent::behaviors(), [
        'uploadBehavior' => [
            'class' => UploadBehavior::class,
            'attributes' => [
                'image_link' => [
                    'path' => $path,
                    'url' => Yii::$app->getRequest()->BaseUrl . $url
                ]
            ]
        ],
    ]);
}
 */