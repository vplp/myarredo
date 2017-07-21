<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170721_121222_update_catalog_samples_many_item_table
 */
class m170721_121222_update_catalog_samples_many_item_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%samples_many_item}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->renameTable('samples_many_item', 'catalog_samples_rel_catalog_item');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_samples_rel_catalog_item', 'samples_many_item');
    }
}
