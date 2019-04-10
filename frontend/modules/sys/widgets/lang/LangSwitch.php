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
     */
    public function run()
    {
        $items = [];

        foreach ($this->items as $lang) {
            $path = Yii::$app->request->url;

            if ($lang['local'] == Yii::$app->language) {
                $this->current = [
                    'label' => $lang['label'],
                    'url' => Yii::$app->request->hostInfo . '/' . $lang['alias'] . $path,
                    'alias' => $lang['alias'],
                    'model' => $lang,
                ];
            }

            if (!$lang['by_default']) {
                $items[] = [
                    'label' => $lang['label'],
                    'url' => Yii::$app->request->hostInfo . '/' . $lang['alias'] . $path,
                    'alias' => $lang['alias'],
                    'model' => $lang,
                ];
            } else {
                $items[] = [
                    'label' => $lang['label'],
                    'url' => Yii::$app->request->hostInfo . $path,
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
