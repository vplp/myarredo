<?php

namespace frontend\modules\sys\widgets\lang;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
//
use frontend\modules\sys\models\Language;

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
        $this->current = $langModel->getCurrent();
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->current['image'] = Language::isImage($this->current['img_flag'])
            ? Html::img(Language::getImage($this->current['img_flag']))
            : '<i class="fa fa-globe" aria-hidden="true"></i>';

        $items = [];

        foreach ($this->items as $lang) {
            $path = Yii::$app->request->url;

            $image =  Language::isImage($lang['img_flag'])
                ? Html::img(Language::getImage($lang['img_flag']))
                : '<i class="fa fa-globe" aria-hidden="true"></i>';

            if ($lang['local'] == Yii::$app->language) {
                $this->current = [
                    'label' => $lang['label'],
                    'url' => Yii::$app->request->hostInfo . '/' . $lang['alias'] . $path,
                    'image' => $image,
                    'alias' => $lang['alias'],
                    'model' => $lang,
                ];
            }

            if (!$lang['by_default']) {
                $items[] = [
                    'label' => $lang['label'],
                    'url' => Yii::$app->request->hostInfo . '/' . $lang['alias'] . $path,
                    'image' => $image,
                    'alias' => $lang['alias'],
                    'model' => $lang,
                ];
            } else {
                $items[] = [
                    'label' => $lang['label'],
                    'url' => Yii::$app->request->hostInfo . $path,
                    'image' => $image,
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
