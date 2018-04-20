<?php

namespace frontend\modules\sys\widgets\lang;

use Yii;
use yii\base\Widget;

/**
 * Class LangSwitch
 *
 * @package frontend\modules\sys\widgets\lang
 */
class LangSwitch extends Widget
{
    /**
     * @var string
     */
    public $view = 'lang_switch';

    /**
     * @var string
     */
    public $current = '';
    /**
     * @var null
     */
    protected $items = null;

    /**
     *
     */
    public function init()
    {
        parent::init();
        $langModel = new Yii::$app->languages->languageModel;
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

        foreach ($this->items as $lang) {
//            if (!$lang['by_default']) {
//                $items[] = ['label' => $lang['label'], 'url' => $baseUrl . '/' . $lang['alias'] . $url];
//            } else {
//                $items[] = ['label' => $lang['label'], 'url' => $baseUrl . $url];
//            }
            $path = \Yii::$app->request->pathInfo;
            /* if (Yii::$app->controller->module->id == 'page') {
              //   $path = '';
             }*/

            if ($lang['local'] == Yii::$app->language) {
                $this->current = [
                    'label' => $lang['label'],
                    'url' => '/' . $lang['alias'] . '/' . $path,
                    'alias' => $lang['alias'],
                    'model' => $lang,
                ];
            }

            if (!$lang['by_default']) {
                $items[] = [
                    'label' => $lang['label'],
                    'url' => '/' . $lang['alias'] . '/' . $path,
                    'alias' => $lang['alias'],
                    'model' => $lang,
                ];
            } else {
                $items[] = [
                    'label' => $lang['label'],
                    'url' => '/' . $path,
                    'alias' => $lang['alias'],
                    'model' => $lang,
                ];
            }
        }
        return $this->render($this->view, [
            'models' => $items,
            'current' => $this->current,
        ]);
    }
}
