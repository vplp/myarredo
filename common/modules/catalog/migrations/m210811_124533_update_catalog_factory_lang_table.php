<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m210811_124533_update_catalog_factory_lang_table extends Migration
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
        $this->renameColumn($this->table, 'wc_phone', 'wc_phone_supplier');
        $this->renameColumn($this->table, 'wc_email', 'wc_email_supplier');

        $this->addColumn($this->table, 'wc_contact_person_supplier', $this->string(255)->defaultValue(null));

        $this->addColumn($this->table, 'wc_phone_factory', $this->string(255)->defaultValue(null));
        $this->addColumn($this->table, 'wc_email_factory', $this->string(255)->defaultValue(null));

        $this->addColumn($this->table, 'wc_contact_person_factory', $this->string(255)->defaultValue(null));

        $this->addColumn($this->table, 'wc_expiration_date', $this->string(255)->defaultValue(null));
        $this->addColumn($this->table, 'wc_terms_of_payment', $this->string(255)->defaultValue(null));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameColumn($this->table, 'wc_phone_supplier', 'wc_phone');
        $this->renameColumn($this->table, 'wc_email_supplier', 'wc_email');

        $this->dropColumn($this->table, 'wc_contact_person_supplier');
        $this->dropColumn($this->table, 'wc_phone_factory');
        $this->dropColumn($this->table, 'wc_email_factory');
        $this->dropColumn($this->table, 'wc_contact_person_factory');
        $this->dropColumn($this->table, 'wc_expiration_date');
        $this->dropColumn($this->table, 'wc_terms_of_payment');
    }
}
