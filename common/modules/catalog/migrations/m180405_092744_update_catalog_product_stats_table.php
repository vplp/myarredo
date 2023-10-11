<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180405_092744_update_catalog_product_stats_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_item_stats}}';

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
        $this->addColumn($this->table, 'ip', $this->string(45)->notNull()->after('user_id'));
        $this->addColumn($this->table, 'http_user_agent', $this->string(512)->notNull()->after('ip'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'ip');
        $this->dropColumn($this->table, 'http_user_agent');
    }
}
