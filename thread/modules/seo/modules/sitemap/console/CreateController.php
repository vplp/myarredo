<?php

namespace thread\modules\seo\modules\sitemap\console;

use Yii;
//
use thread\modules\seo\modules\sitemap\models\{
    XMLElement, XMLSimple
};
//
use thread\modules\seo\modules\sitemap\models\Element;

/**
 * Class CreateController
 *
 * @package frontend\modules\seo\modules\sitemap\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class CreateController extends \yii\console\Controller
{
    public $defaultAction = 'index';

    public $filepath = '@root/web/sitemap.xml';

    /**
     * @param string $actionID
     * @return array
     */
    public function options($actionID)
    {
        return [
            'filepath',
        ];
    }

    /**
     * @return array
     */
    public function optionAliases()
    {
        return [
            'path' => 'filepath',
        ];
    }

    /**
     * @var array
     */
    protected $seoModelList = [

    ];

    /**
     *
     */
    public function actionIndex()
    {

        $this->stdout("Start Create\n");

        $filepath = Yii::getAlias($this->filepath);
        if ($handle = fopen($filepath, 'w+')) {

            set_time_limit(0);

            fwrite($handle, XMLSimple::headTag());
            fwrite($handle, XMLSimple::beginTag());

            $elements = Element::findAddToSitemap();

            $map = new XMLSimple();

            foreach ($elements->batch(500) as $item) {
                $r = [];
                foreach ($item as $i) {
                    $r[] = (new XMLElement([
                        'loc' => $i->url,
                        'lastmod' => $i->updated_at,
                    ]))->render();
                }
                fwrite($handle, implode('', $r));
            }

            fwrite($handle, XMLSimple::endTag());
        } else {
            $this->stdout("error open file\n");
        }
        $this->stdout("End Create\n");
    }
}