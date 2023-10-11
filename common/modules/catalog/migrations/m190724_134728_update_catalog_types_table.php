<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190724_134728_update_catalog_types_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_type}}';

    /**
     * table name
     * @var string
     */
    public $tableLang = '{{%catalog_type_lang}}';

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
        $this->addForeignKey(
            'fk-catalog_types_lang-rid-catalog_types-id',
            $this->tableLang,
            'rid',
            $this->table,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-catalog_types_lang-rid-catalog_types-id', $this->tableLang);
    }
}
