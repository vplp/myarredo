<?php

namespace thread\modules\seo\widgets\breadcrumbs;

use Yii;
use yii\helpers\{
    Url, Html
};
use thread\app\web\View;

/**
 * Class Breadcrumbs
 *
 * @package thread\modules\seo\widgets\breadcrumbs
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    public $itemsLdJson = [];

    /**
     * @param mixed $result
     * @return mixed
     */
    public function afterRun($result)
    {
        $this->generateLdJson();

        return parent::afterRun($result);
    }

    /**
     *
     */
    public function generateLdJson()
    {
        $view = Yii::$app->getView();

        $this->generateItemLdJson();

        $itemsStr = [];

        if (!empty($this->itemsLdJson)) {
            foreach ($this->itemsLdJson as $key => $item) {
                $itemsStr[] = '{
    "@type": "ListItem",
    "position": ' . ($key + 1) . ',
    "item": {
      "@id": "' . $item['url'] . '",
      "name": "' . $item['label'] . '"
    }
  }';
            }

        }

        $js = '
{
    "@context": "http://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [' . implode(',', $itemsStr) . '
  ]
}';

        $view->registerJsLdJson($js, View::POS_END);
    }

    /**
     *
     */
    public function generateItemLdJson()
    {
        if ($this->homeLink === null) {
            $this->itemsLdJson[] = [
                'label' => Yii::t('yii', 'Home'),
                'url' => Url::toRoute(Yii::$app->homeUrl, true),
            ];
        } elseif ($this->homeLink !== false) {
            if (isset($this->homeLink['label']) && isset($this->homeLink['url'])) {
                $this->itemsLdJson[] = [
                    'label' => Html::encode($this->homeLink['label']),
                    'url' => Url::toRoute($this->homeLink['url'], true),
                ];
            }
        }
        foreach ($this->links as $link) {
            if (isset($link['label']) && isset($link['url'])) {
                $this->itemsLdJson[] = [
                    'label' => Html::encode($link['label']),
                    'url' => Url::toRoute($link['url'], true),
                ];
            }
        }
    }
}