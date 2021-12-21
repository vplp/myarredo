<?php

use common\modules\seo\Seo as ParentModule;
use yii\db\Migration;

class m211221_145103_update_seo_direct_link_lang_table extends Migration
{

    /**
     * @var string
     */
    public $table = '{{%seo_direct_link}}';

    /**
     * @var string
     */
    public $tableLang = '{{%seo_direct_link_lang}}';


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
        $this->createIndex('rid_2', $this->tableLang, 'rid');

        $this->addForeignKey(
            'fk-seo_direct_link_lang-rid-seo_direct_link-id2',
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
        $this->dropForeignKey('fk-seo_direct_link_lang-rid-seo_direct_link-id2', $this->tableLang);
        $this->dropIndex('rid_2', $this->tableLang);
    }
}
