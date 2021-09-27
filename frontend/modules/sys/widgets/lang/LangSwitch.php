<?php

namespace frontend\modules\sys\widgets\lang;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use frontend\modules\sys\models\Language;
use frontend\modules\catalog\models\{
    Types, Category, Specification, Colors, Product, ItalianProduct
};

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
     * @var int
     */
    public $noIndex = 0;

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
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $keys = Yii::$app->catalogFilter->keys;

        $this->current['image'] = Language::isImage($this->current['img_flag'])
            ? Html::img(
                Language::getImage($this->current['img_flag']),
                ['width' => '16', 'height' => '11', 'alt' => $this->current['label']]
            )
            : '<i class="fa fa-globe" aria-hidden="true"></i>';

        $items = [];

        foreach ($this->items as $lang) {
            // ua only for domain ua
            if (!in_array(DOMAIN_TYPE, ['ua']) && in_array($lang['alias'], ['ua'])) {
                continue;
            }

            // ua only for domain he
            if (!in_array(DOMAIN_TYPE, ['co.il']) && in_array($lang['alias'], ['he'])) {
                //continue;
            }

            if (!in_array(DOMAIN_TYPE, ['fr']) && in_array($lang['alias'], ['fr'])) {
                //continue;
            }

            if (!in_array(DOMAIN_TYPE, ['uk']) && in_array($lang['alias'], ['en'])) {
                //continue;
            }

            $image = Language::isImage($lang['img_flag'])
                ? Html::img(
                    Language::getImage($lang['img_flag']),
                    ['width' => '16', 'height' => '11', 'alt' => $lang['label']]
                )
                : '<i class="fa fa-globe" aria-hidden="true"></i>';

            // $url
            if (in_array($lang['alias'], ['it'])) {
                $url = 'https://www.myarredo.com';
            } elseif (in_array($lang['alias'], ['de'])) {
                $url = 'https://www.myarredo.de';
            } elseif (in_array($lang['alias'], ['fr'])) {
                $url = 'https://www.myarredo.fr';
            } elseif (in_array($lang['alias'], ['en'])) {
                $url = 'https://www.myarredo.uk';
            } elseif (in_array($lang['alias'], ['he'])) {
                $url = 'https://www.myarredo.co.il';
            } elseif (in_array($lang['alias'], ['ru']) && in_array(DOMAIN_TYPE, ['ru'])) {
                $url = 'https://www.myarredo.ru';
            } elseif (in_array($lang['alias'], ['ru', 'ua']) && in_array(DOMAIN_TYPE, ['ua'])) {
                $url = Yii::$app->request->hostInfo;
            } else {
                $url = 'https://www.myarredo.ru';
            }

            if (in_array($lang['alias'], ['it', 'en', 'de', 'fr', 'uk', 'he'])) {
                $path = Yii::$app->request->url;

                $params = Yii::$app->catalogFilter->params;

                if (!empty($params)) {
                    if (!empty($params[$keys['category']])) {
                        $model = Category::findByAlias($params[$keys['category']][0]);
                        $params[$keys['category']] = $model['alias_' . $lang['alias']];
                    }

                    if (!empty($params[$keys['type']])) {
                        $models = Types::findByAlias($params[$keys['type']]);
                        $arr = [];
                        foreach ($models as $model) {
                            $arr[] = $model['alias_' . $lang['alias']];
                        }
                        $params[$keys['type']] = $arr;
                    }

                    if (!empty($params[$keys['style']])) {
                        $models = Specification::findByAlias($params[$keys['style']]);
                        $arr = [];
                        foreach ($models as $model) {
                            $arr[] = $model['alias_' . $lang['alias']];
                        }
                        $params[$keys['style']] = $arr;
                    }

                    if (!empty($params[$keys['colors']])) {
                        $models = Colors::findByAlias($params[$keys['colors']]);
                        $arr = [];
                        foreach ($models as $model) {
                            $arr[] = $model['alias_' . $lang['alias']];
                        }
                        $params[$keys['colors']] = $arr;
                    }

                    $path = Yii::$app->catalogFilter->createUrl(
                        $params,
                        ['/catalog/' . Yii::$app->controller->id . '/list']
                    );
                }

                if (Yii::$app->controller->id == 'product' && $model = Product::findByAlias(Yii::$app->request->get('alias'))) {
                    $path = Product::getUrl($model['alias_' . $lang['alias']], false);
                } elseif (Yii::$app->controller->id == 'sale-italy' && Yii::$app->controller->action->id == 'view' && $model = ItalianProduct::findByAlias(Yii::$app->request->get('alias'))) {
                    $path = ItalianProduct::getUrl($model['alias_' . $lang['alias']], false);
                }

                $path = str_replace($this->current['alias'] . '/', '', $path);
            } elseif (in_array($lang['alias'], ['ru']) && in_array(DOMAIN_TYPE, ['com', 'de', 'fr', 'uk', 'co.il'])) {
                $path = Yii::$app->request->url;

                $params = Yii::$app->catalogFilter->params;

                if (!empty($params)) {
                    if (!empty($params[$keys['category']])) {
                        $model = Category::findByAlias($params[$keys['category']][0]);
                        $params[$keys['category']] = $model['alias'];
                    }

                    if (!empty($params[$keys['type']])) {
                        $models = Types::findByAlias($params[$keys['type']]);
                        $arr = [];
                        foreach ($models as $model) {
                            $arr[] = $model['alias'];
                        }
                        $params[$keys['type']] = $arr;
                    }

                    if (!empty($params[$keys['style']])) {
                        $models = Specification::findByAlias($params[$keys['style']]);
                        $arr = [];
                        foreach ($models as $model) {
                            $arr[] = $model['alias'];
                        }
                        $params[$keys['style']] = $arr;
                    }

                    if (!empty($params[$keys['colors']])) {
                        $models = Colors::findByAlias($params[$keys['colors']]);
                        $arr = [];
                        foreach ($models as $model) {
                            $arr[] = $model['alias'];
                        }
                        $params[$keys['colors']] = $arr;
                    }

                    $path = Yii::$app->catalogFilter->createUrl(
                        $params,
                        ['/catalog/' . Yii::$app->controller->id . '/list']
                    );
                }

                if (Yii::$app->controller->id == 'product' && $model = Product::findByAlias(Yii::$app->request->get('alias'))) {
                    $path = Product::getUrl($model['alias'], false);
                } elseif (Yii::$app->controller->id == 'sale-italy' && Yii::$app->controller->action->id == 'view' && $model = ItalianProduct::findByAlias(Yii::$app->request->get('alias'))) {
                    $path = ItalianProduct::getUrl($model['alias'], false);
                }

                $path = str_replace($this->current['alias'] . '/', '', $path);
            } else {
                $path = Yii::$app->request->url;

                $params = Yii::$app->catalogFilter->params;

                if (!empty($params)) {
                    if (!empty($params[$keys['category']])) {
                        $model = Category::findByAlias($params[$keys['category']][0]);
                        $params[$keys['category']] = $model['alias'];
                    }

                    if (!empty($params[$keys['type']])) {
                        $models = Types::findByAlias($params[$keys['type']]);
                        $arr = [];
                        foreach ($models as $model) {
                            $arr[] = $model['alias'];
                        }
                        $params[$keys['type']] = $arr;
                    }

                    if (!empty($params[$keys['style']])) {
                        $models = Specification::findByAlias($params[$keys['style']]);
                        $arr = [];
                        foreach ($models as $model) {
                            $arr[] = $model['alias'];
                        }
                        $params[$keys['style']] = $arr;
                    }

                    if (!empty($params[$keys['colors']])) {
                        $models = Colors::findByAlias($params[$keys['colors']]);
                        $arr = [];
                        foreach ($models as $model) {
                            $arr[] = $model['alias'];
                        }
                        $params[$keys['colors']] = $arr;
                    }

                    $path = Yii::$app->catalogFilter->createUrl(
                        $params,
                        ['/catalog/' . Yii::$app->controller->id . '/list']
                    );
                }

                if (Yii::$app->controller->id == 'product' && $model = Product::findByAlias(Yii::$app->request->get('alias'))) {
                    $path = Product::getUrl($model['alias'], false);
                } elseif (Yii::$app->controller->id == 'sale-italy' && Yii::$app->controller->action->id == 'view' && $model = ItalianProduct::findByAlias(Yii::$app->request->get('alias'))) {
                    $path = ItalianProduct::getUrl($model['alias'], false);
                }

                $path = str_replace($this->current['alias'] . '/', '', $path);
            }

            if ($lang['local'] == Yii::$app->language) {
                $this->current = [
                    'label' => $lang['label'],
                    'url' => !in_array($lang['alias'], ['de', 'fr', 'uk', 'he'])
                        ? $url . '/' . $lang['alias'] . $path
                        : $url . $path,
                    'image' => $image,
                    'alias' => $lang['alias'],
                    'model' => $lang,
                ];
            }

            if (!$lang['by_default']) {
                $items[] = [
                    'label' => $lang['label'],
                    'url' => !in_array($lang['alias'], ['de', 'fr', 'uk', 'he'])
                        ? $url . '/' . $lang['alias'] . $path
                        : $url . $path,
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
            'noIndex' => $this->noIndex,
            'models' => $items,
            'current' => $this->current,
        ]);
    }
}
