<?php

namespace thread\app\web;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class Pagination
 * 
 * @package thread\components
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Pagination extends \yii\data\Pagination {

    public $generateExeption = true;

    /**
     * 
     * @param type $value
     * @param boolean $validatePage
     * @throws NotFoundHttpException
     */
    public function setPage($value, $validatePage = false) {
        parent::setPage($value, $validatePage);

        if ($value < 0 && $this->generateExeption == true) {
            throw new NotFoundHttpException;
        }
        $pageCount = $this->getPageCount();
        if ($value >= $pageCount && $this->generateExeption == true) {
            throw new NotFoundHttpException;
        }
        if (Yii::$app->getRequest()->get($this->pageParam) == 1 && $this->generateExeption == true) {
            throw new NotFoundHttpException;
        }
    }

    /**
     * 
     * @param type $page
     * @param type $pageSize
     * @param type $absolute
     * @return type
     */
    public function createUrl($page, $pageSize = null, $absolute = false) {
        if (($params = $this->params) === null) {
            $request = Yii::$app->getRequest();
            $params = $request instanceof Request ? $request->getQueryParams() : [];
        }
        if ($page > 1 || $page >= 1 && $this->forcePageParam) {
            $params[$this->pageParam] = $page + 1;
        } else {
            unset($params[$this->pageParam]);
        }

        $params[0] = $this->route === null ? Yii::$app->controller->getRoute() : $this->route;
        $urlManager = $this->urlManager === null ? Yii::$app->getUrlManager() : $this->urlManager;
        if ($absolute) {
            return $urlManager->createAbsoluteUrl($params);
        } else {
            return $urlManager->createUrl($params);
        }
    }

}
