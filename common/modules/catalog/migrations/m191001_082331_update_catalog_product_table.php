<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m191001_082331_update_catalog_product_table extends Migration
{

    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_item}}';

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
        $this->addColumn($this->table, 'time_promotion_in_catalog', $this->integer(11)->unsigned()->notNull()->defaultValue(0));
        $this->addColumn($this->table, 'time_promotion_in_category', $this->integer(11)->unsigned()->notNull()->defaultValue(0));

        $this->createIndex('time_promotion_in_catalog', $this->table, 'time_promotion_in_catalog');
        $this->createIndex('time_promotion_in_category', $this->table, 'time_promotion_in_category');

        $this->addColumn($this->table, 'time_vip_promotion_in_catalog', $this->integer(11)->unsigned()->notNull()->defaultValue(0));
        $this->addColumn($this->table, 'time_vip_promotion_in_category', $this->integer(11)->unsigned()->notNull()->defaultValue(0));

        $this->createIndex('time_vip_promotion_in_catalog', $this->table, 'time_vip_promotion_in_catalog');
        $this->createIndex('time_vip_promotion_in_category', $this->table, 'time_vip_promotion_in_category');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'time_promotion_in_catalog');
        $this->dropColumn($this->table, 'time_promotion_in_category');

        $this->dropIndex('time_promotion_in_catalog');
        $this->dropIndex('time_promotion_in_category');

        $this->dropColumn($this->table, 'time_vip_promotion_in_catalog');
        $this->dropColumn($this->table, 'time_vip_promotion_in_category');

        $this->dropIndex('time_vip_promotion_in_catalog');
        $this->dropIndex('time_vip_promotion_in_category');
    }
}
