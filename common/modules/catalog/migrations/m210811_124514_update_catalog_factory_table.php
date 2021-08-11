<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m210811_124514_update_catalog_factory_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%catalog_factory}}';

    /**
     *
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'factory_discount_with_exposure', $this->integer(11)->unsigned()->notNull()->defaultValue(0));
        $this->addColumn($this->table, 'factory_discount_on_exposure', $this->integer(11)->unsigned()->notNull()->defaultValue(0));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'factory_discount_on_exposure');
        $this->dropColumn($this->table, 'factory_discount_with_exposure');
    }
}
