<?php

use yii\db\Migration;
use common\modules\files\FilesModule;

/**
 * Class m230217_085522_create_files_lang_table
 *
 */
class m230217_085522_create_files_lang_table extends Migration
{

    /**
     * Related Files table name
     * @var string
     */
    public $tableFile = '{{%files}}';

    /**
     * Language Files table name
     * @var string
     */
    public $tableFilesLang = '{{%files_lang}}';

    /**
     *
     */
    public function init()
    {
        $this->db = FilesModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableFilesLang, [
            'rid' => $this->integer(11)->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),
            'content' => $this->text()->defaultValue(null)->comment('Content')
        ]);

        $this->createIndex('rid', $this->tableFilesLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-files_lang-rid-files-id',
            $this->tableFilesLang,
            'rid',
            $this->tableFile,
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
        $this->dropForeignKey('fk-files_lang-rid-files-id', $this->tableFilesLang);
        $this->dropIndex('rid', $this->tableFilesLang);
        $this->dropTable($this->tableFilesLang);
    }
}

