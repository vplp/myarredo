<?php
use thread\app\web\View;

if (isset($params['base-url'])) {
    if (isset($params['web-site-logo'])) {
        $this->registerJsLdJson($this->render('parts/logos', [
            'params' => $params
        ]), View::POS_END);
    }
    if (isset($params['web-site-search-action'])) {
        $this->registerJsLdJson($this->render('parts/searchbox', [
            'params' => $params
        ]), View::POS_END);
    }
    if (isset($params['web-site-name'])) {
        $this->registerJsLdJson($this->render('parts/site-in-result', [
            'params' => $params
        ]), View::POS_END);
    }
    if (isset($params['web-site-telephone'])) {
        $this->registerJsLdJson($this->render('parts/corporate-contact', [
            'params' => $params
        ]), View::POS_END);
    }
}
