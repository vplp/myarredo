<?php

use yii\db\Migration;
use thread\modules\sys\modules\mailcarrier\MailCarrier as ParentModule;

/**
 * Class m170901_163134_create_table_system_mail_box_lang
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170901_163134_create_table_system_mail_box_lang extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%system_mail_box}}';

    /**
     * @var string
     */
    public $tableLang = '{{%system_mail_box_lang}}';

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
        $this->createTable($this->tableLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),
        ]);

        $this->createIndex('rid', $this->tableLang, ['rid', 'lang'], true);
        $this->createIndex('rid_2', $this->tableLang, 'rid');

        $this->addForeignKey(
            'fv_system_mail_box_lang_ibfk_1',
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
        $this->dropForeignKey('fv_system_mail_box_lang_ibfk_1', $this->tableLang);
        $this->dropIndex('rid', $this->tableLang);
        $this->dropIndex('rid_2', $this->tableLang);
        $this->dropTable($this->tableLang);
    }
}
