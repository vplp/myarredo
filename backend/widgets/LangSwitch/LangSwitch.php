<?php

namespace backend\widgets\LangSwitch;

use Yii;

//
use thread\app\base\widgets\Widget;

/**
 * Class LangSwitch
 *
 * @package backend\widgets\LangSwitch
 */
class LangSwitch extends Widget
{
    /**
     * @var string
     */
    public $view = 'LangSwitch';

    /**
     * @var string
     */
    public $name = 'LangSwitch';

    /**
     * @var string
     */
    public $current = '';

    /**
     * @var null
     */
    protected $items = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $langModel = new Yii::$app->languages->languageModel();

        $this->items = $langModel->getLanguages();
        $this->current = $langModel->getCurrent()['label'];
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $items = [];
        $request = Yii::$app->getRequest();
        $baseUrl = $request->getBaseUrl();
        $url = substr($request->getUrl(), strlen($baseUrl));

        $selected_languages = Yii::$app->user->identity->profile->selected_languages;

        if (!empty($selected_languages) && count($selected_languages) == 1 && $selected_languages[0] != Yii::$app->language) {
            foreach ($this->items as $lang) {
                if (!$lang['by_default'] && $lang['local'] == $selected_languages[0]) {
                    $url = $baseUrl . '/' . $lang['alias'] . $url;
                    Yii::$app->response->redirect($url);
                    Yii::$app->end();
                } else if ($lang['local'] == $selected_languages[0]) {
                    $url = $baseUrl . $url;
                    Yii::$app->response->redirect($url);
                    Yii::$app->end();
                }
            }
        }

        if (empty($selected_languages) || count($selected_languages) > 1) {
            foreach ($this->items as $lang) {
                if (!empty($selected_languages) && !in_array($lang['local'], $selected_languages)) {
                    break;
                }

                if (!$lang['by_default'] && $lang['local'] != Yii::$app->language) {
                    $items[] = ['label' => $lang['label'], 'url' => $baseUrl . '/' . $lang['alias'] . $url];
                } else if ($lang['local'] != Yii::$app->language) {
                    $items[] = ['label' => $lang['label'], 'url' => $baseUrl . $url];
                }
            }

            return $this->render($this->view, [
                'models' => $items,
                'current' => $this->current,
            ]);
        }
    }
}
