<?php

use yii\db\Migration;
use thread\modules\menu\Menu;

/**
 * Class m160127_031125_create_fv_menu_table
 *
 * @package thread\modules\menu
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_031125_create_fv_menu_table extends Migration
{

    /**
     * Menu table name
     * @var string
     */
    public $tableMenu = '{{%menu}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Menu::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {

        $this->createTable($this->tableMenu, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'alias' => $this->string(255)->unique()->notNull()->comment('Alias'),
            'created_at' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => $this->boolean()->notNull()->defaultValue(0)->comment('Published'),
            'deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('Deleted'),
            'readonly' => $this->boolean()->notNull()->defaultValue(0)->comment('Read only')
        ]);

        $this->createIndex('published', $this->tableMenu, 'published');
        $this->createIndex('deleted', $this->tableMenu, 'deleted');

    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tableMenu);
        $this->dropIndex('published', $this->tableMenu);
        $this->dropTable($this->tableMenu);
    }
}
