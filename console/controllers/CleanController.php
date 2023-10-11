<?php

namespace console\controllers;

use yii\helpers\FileHelper;
use thread\modules\shop\models\CartItem;
use thread\modules\shop\models\OrderItem;

/**
 * Class ClearController
 */
class CleanController extends \yii\console\Controller
{
    public $assetPaths = ['@app/web/assets'];
    public $runtimePaths = ['@runtime'];

    /**
     * Removes temporary assets.
     */
    public function actionAssets()
    {
        foreach ((array)$this->assetPaths as $path) {
            $this->cleanDir($path);
        }
        $this->stdout('Done' . PHP_EOL);
    }

    /**
     * Removes runtime content.
     */
    public function actionRuntime()
    {
        foreach ((array)$this->runtimePaths as $path) {
            $this->cleanDir($path);
        }
        $this->stdout('Done' . PHP_EOL);
    }

    /**
     * Remove all
     */
    public function actionAll()
    {
        $this->actionAssets();
        $this->actionRuntime();
    }

    /**
     * Add access to file paths
     */
    public function actionAddAccess()
    {
    }

    public function actionOrderItem()
    {
        $rows = OrderItem::find()
            ->select(['order_id', 'product_id', 'COUNT(*) AS count'])
            ->groupBy(['order_id', 'product_id'])
            ->having('count > 1')
            ->asArray()
            ->all();

        foreach ($rows as $row) {
            $model = OrderItem::find()
                ->select(['id', 'order_id', 'product_id'])
                ->groupBy(['order_id', 'product_id'])
                ->where(['order_id' => $row['order_id'], 'product_id' => $row['product_id']])
                ->one();

            $model->delete();
        }

        /* !!! */ echo  '<pre style="color:red;">'; print_r($rows); echo '</pre>'; /* !!! */
    }

    public function actionCartItem()
    {
        $rows = CartItem::find()
            ->select(['cart_id', 'product_id', 'COUNT(*) AS count'])
            ->groupBy(['cart_id', 'product_id'])
            ->having('count > 1')
            ->asArray()
            ->all();

        foreach ($rows as $row) {
            $model = CartItem::find()
                ->select(['id', 'cart_id', 'product_id'])
                ->groupBy(['cart_id', 'product_id'])
                ->where(['cart_id' => $row['cart_id'], 'product_id' => $row['product_id']])
                ->one();

            $model->delete();
        }

        /* !!! */ echo  '<pre style="color:red;">'; print_r($rows); echo '</pre>'; /* !!! */
    }

    /**
     * @param $dir
     * @throws \yii\base\ErrorException
     */
    private function cleanDir($dir)
    {
        $iterator = new \DirectoryIterator(\Yii::getAlias($dir));
        foreach ($iterator as $sub) {
            if (!$sub->isDot() && $sub->isDir()) {
                $this->stdout('Removed ' . $sub->getPathname() . PHP_EOL);
                FileHelper::removeDirectory($sub->getPathname());
            }
        }
    }
}
