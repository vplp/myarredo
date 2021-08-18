<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m210818_125656_update_catalog_factory_lang_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%catalog_factory_lang}}';

    /**
     *
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    public function safeUp()
    {
        $this->addColumn($this->table, 'wc_additional_discount_info', $this->string(255)->defaultValue(null));
        $this->addColumn($this->table, 'wc_additional_cost_calculations_info', $this->string(255)->defaultValue(null));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'wc_additional_cost_calculations_info');
        $this->dropColumn($this->table, 'wc_additional_discount_info');
    }
}
