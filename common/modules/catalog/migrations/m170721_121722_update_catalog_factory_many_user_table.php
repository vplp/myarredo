<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170721_121722_update_catalog_factory_many_user_table
 */
class m170721_121722_update_catalog_factory_many_user_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%factory_many_user}}';

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
        $this->renameTable('factory_many_user', 'catalog_factory_rel_user');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_factory_rel_user', 'factory_many_user');
    }
}
