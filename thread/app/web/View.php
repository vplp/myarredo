<?php

namespace thread\app\web;

use Yii;
use yii\helpers\Html;
use yii\web\View as yiiWebView;

/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class View extends yiiWebView
{
    /**
     * @var array the registered JS Ld Json code blocks
     * @see registerJsLdJson()
     */
    public $jsLdJson;

    /**
     * @param $js
     * @param int $position
     * @param null $key
     */
    public function registerJsLdJson($js, $position = self::POS_READY, $key = null)
    {
        $key = $key ?: md5($js);
        $this->jsLdJson[$position][$key] = $js;
    }

    /**
     *
     */
    public function beginPage()
    {
        //render seo meta tags
        Yii::$app->metatag->render(); //->render_graph();
        parent::beginPage();
    }

    /**
     * Renders the content to be inserted in the head section.
     * The content is rendered using the registered meta tags, link tags, CSS/JS code blocks and files.
     * @return string the rendered content
     */
    protected function renderHeadHtml()
    {
        $lines = [];
        if (!empty($this->metaTags)) {
            $lines[] = implode("\n", $this->metaTags);
        }
        if (!empty($this->linkTags)) {
            $lines[] = implode("\n", $this->linkTags);
        }
        if (!empty($this->cssFiles)) {
            $lines[] = implode("\n", $this->cssFiles);
        }
        if (!empty($this->css)) {
            $lines[] = implode("\n", $this->css);
        }
        if (!empty($this->jsFiles[self::POS_HEAD])) {
            $lines[] = implode("\n", $this->jsFiles[self::POS_HEAD]);
        }
        if (!empty($this->js[self::POS_HEAD])) {
            $lines[] = Html::script(implode("\n", $this->js[self::POS_HEAD]), ['type' => 'text/javascript']);
        }
        if (!empty($this->jsLdJson[self::POS_HEAD])) {
            $jsonld = $this->jsLdJson[self::POS_HEAD];
            foreach ($jsonld as $value) {
                $lines[] = Html::script($value, ['type' => 'application/ld+json']);
            }
        }

        return empty($lines) ? '' : implode("\n", $lines);
    }

    /**
     * Renders the content to be inserted at the beginning of the body section.
     * The content is rendered using the registered JS code blocks and files.
     * @return string the rendered content
     */
    protected function renderBodyBeginHtml()
    {
        $lines = [];
        if (!empty($this->jsFiles[self::POS_BEGIN])) {
            $lines[] = implode("\n", $this->jsFiles[self::POS_BEGIN]);
        }
        if (!empty($this->js[self::POS_BEGIN])) {
            $lines[] = Html::script(implode("\n", $this->js[self::POS_BEGIN]), ['type' => 'text/javascript']);
        }
        if (!empty($this->jsLdJson[self::POS_BEGIN])) {
            $jsonld = $this->jsLdJson[self::POS_BEGIN];
            foreach ($jsonld as $value) {
                $lines[] = Html::script($value, ['type' => 'application/ld+json']);
            }
        }

        return empty($lines) ? '' : implode("\n", $lines);
    }

    /**
     * Renders the content to be inserted at the end of the body section.
     * The content is rendered using the registered JS code blocks and files.
     * @param bool $ajaxMode whether the view is rendering in AJAX mode.
     * If true, the JS scripts registered at [[POS_READY]] and [[POS_LOAD]] positions
     * will be rendered at the end of the view like normal scripts.
     * @return string the rendered content
     */
    protected function renderBodyEndHtml($ajaxMode)
    {
        $lines = [];

        if (!empty($this->jsFiles[self::POS_END])) {
            $lines[] = implode("\n", $this->jsFiles[self::POS_END]);
        }

        if ($ajaxMode) {
            $scripts = [];
            if (!empty($this->js[self::POS_END])) {
                $scripts[] = implode("\n", $this->js[self::POS_END]);
            }
            if (!empty($this->js[self::POS_READY])) {
                $scripts[] = implode("\n", $this->js[self::POS_READY]);
            }
            if (!empty($this->js[self::POS_LOAD])) {
                $scripts[] = implode("\n", $this->js[self::POS_LOAD]);
            }
            if (!empty($scripts)) {
                $lines[] = Html::script(implode("\n", $scripts), ['type' => 'text/javascript']);
            }
        } else {
            if (!empty($this->js[self::POS_END])) {
                $lines[] = Html::script(implode("\n", $this->js[self::POS_END]), ['type' => 'text/javascript']);
            }
            if (!empty($this->jsLdJson[self::POS_END])) {
                $jsonld = $this->jsLdJson[self::POS_END];
                foreach ($jsonld as $value) {
                    $lines[] = Html::script($value, ['type' => 'application/ld+json']);
                }
            }
            if (!empty($this->js[self::POS_READY])) {
                $js = "jQuery(document).ready(function () {\n" . implode("\n", $this->js[self::POS_READY]) . "\n});";
                $lines[] = Html::script($js, ['type' => 'text/javascript']);
            }
            if (!empty($this->js[self::POS_LOAD])) {
                $js = "jQuery(window).on('load', function () {\n" . implode("\n", $this->js[self::POS_LOAD]) . "\n});";
                $lines[] = Html::script($js, ['type' => 'text/javascript']);
            }
        }

        return empty($lines) ? '' : implode("\n", $lines);
    }

}