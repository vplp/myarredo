<?php

namespace frontend\widgets;

use yii\bootstrap\Modal;

/**
 * Class Popup
 *
 * Popup widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * \Yii::$app->getSession()->setFlash('error', 'This is the message');
 * \Yii::$app->getSession()->setFlash('success', 'This is the message');
 * \Yii::$app->getSession()->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * \Yii::$app->getSession()->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @package frontend\widgets
 */
class Popup extends \yii\bootstrap\Widget
{
    public $clientOptions = [];

    public function init()
    {
        parent::init();

        $session = \Yii::$app->getSession();
        $flashes = $session->getAllFlashes();

        foreach ($flashes as $type => $data) {
            $data = (array)$data;

            Modal::begin([
                //'header' => '<h2>Hello world</h2>',
                //'toggleButton' => ['label' => 'click me'],
                //'footer' => 'Низ окна',
                'clientOptions' => $this->clientOptions
            ]);

            foreach ($data as $i => $message) {
                echo $message;
            }

            $session->removeFlash($type);

            Modal::end();
        }
    }
}
