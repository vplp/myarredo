<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m210512_131251_update_catalog_factory_lang_table extends Migration
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

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'wc_provider', $this->string(255)->defaultValue(null));
        $this->addColumn($this->table, 'wc_phone', $this->string(255)->defaultValue(null));
        $this->addColumn($this->table, 'wc_email', $this->string(255)->defaultValue(null));
        $this->addColumn($this->table, 'wc_prepayment', $this->string(255)->defaultValue(null));
        $this->addColumn($this->table, 'wc_balance', $this->string(255)->defaultValue(null));
        $this->renameColumn($this->table, 'working_conditions', 'wc_additional_terms');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameColumn($this->table, 'wc_additional_terms', 'working_conditions');
        $this->dropColumn($this->table, 'wc_balance');
        $this->dropColumn($this->table, 'wc_prepayment');
        $this->dropColumn($this->table, 'wc_email');
        $this->dropColumn($this->table, 'wc_phone');
        $this->dropColumn($this->table, 'wc_provider');
    }
}
