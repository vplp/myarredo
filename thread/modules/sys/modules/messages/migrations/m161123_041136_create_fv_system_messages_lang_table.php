<?php

use yii\db\Migration;
use thread\modules\sys\modules\messages\Messages;

/**
 * Class m161123_031136_create_fv_system_messages_lang_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161123_041136_create_fv_system_messages_lang_table extends Migration
{

    /**
     * Menu table name
     * @var string
     */
    public $table = '{{%system_messages}}';

    /**
     * Menu language table name
     * @var string
     */
    public $tableLang = '{{%system_messages_lang}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Messages::getDb();
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
            'title' => $this->text()->notNull()->comment('Title'),
        ]);

        $this->createIndex('rid', $this->tableLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-system_messages_-rid-menu-id',
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
        $this->dropForeignKey('fk-system_messages_-rid-menu-id', $this->tableLang);
        $this->dropIndex('rid', $this->tableLang);
        $this->dropTable($this->tableLang);
    }
}
