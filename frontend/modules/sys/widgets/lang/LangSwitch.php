<?php

namespace frontend\modules\sys\widgets\lang;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
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
            /**
             * ua only for domain ua
             */
            if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) && Yii::$app->city->domain != 'ua' && in_array($lang['alias'], ['ua'])) {
                continue;
            }

            $image = Language::isImage($lang['img_flag'])
                ? Html::img(Language::getImage($lang['img_flag']))
                : '<i class="fa fa-globe" aria-hidden="true"></i>';

            /**
             * $url
             */
            if (in_array($lang['alias'], ['it', 'en'])) {
                $url = 'https://www.myarredo.com';
            } elseif (in_array($lang['alias'], ['de'])) {
                $url = 'https://www.myarredo.de';
            } elseif (!in_array($lang['alias'], ['it', 'en']) && Yii::$app->city->domain == 'com') {
                $url = 'https://www.myarredo.ru';
            } elseif (!in_array($lang['alias'], ['de']) && Yii::$app->city->domain == 'de') {
                $url = 'https://www.myarredo.ru';
            } else {
                $url = Yii::$app->request->hostInfo;
            }

            /**
             * $path
             */
            if (in_array($lang['alias'], ['it', 'en']) && Yii::$app->city->domain != 'com' && in_array(Yii::$app->controller->id, ['category', 'sale', 'sale-italy']) &&
                Yii::$app->controller->action->id == 'list') {
                $path = '/';
            } elseif (!in_array($lang['alias'], ['it', 'en']) && Yii::$app->city->domain == 'com' && in_array(Yii::$app->controller->id, ['category', 'sale', 'sale-italy']) &&
                Yii::$app->controller->action->id == 'list') {
                $path = '/';
            } else {
                $path = Yii::$app->request->url;
            }

            if ($lang['local'] == Yii::$app->language) {
                $this->current = [
                    'label' => $lang['label'],
                    'url' => $url . '/' . $lang['alias'] . $path,
                    'image' => $image,
                    'alias' => $lang['alias'],
                    'model' => $lang,
                ];
            }

            if (!$lang['by_default']) {
                $items[] = [
                    'label' => $lang['label'],
                    'url' => $url . '/' . $lang['alias'] . $path,
                    'image' => $image,
                    'alias' => $lang['alias'],
                    'model' => $lang,
                ];
            } else {
                $items[] = [
                    'label' => $lang['label'],
                    'url' => $url . $path,
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
