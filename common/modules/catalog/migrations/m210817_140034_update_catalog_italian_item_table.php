<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m210817_140034_update_catalog_italian_item_table extends Migration
{

    /**
     * @var string
     */
    public $table = '{{%catalog_italian_item}}';

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
        $this->addColumn(
            $this->table,
            'alias_en',
            $this->string(255)->notNull()->after('alias')
        );
        $this->addColumn(
            $this->table,
            'alias_it',
            $this->string(255)->notNull()->after('alias_en')
        );
        $this->addColumn(
            $this->table,
            'alias_de',
            $this->string(255)->notNull()->after('alias_it')
        );

        $query = (new \yii\db\Query())
            ->select(['id', 'alias'])
            ->from($this->table);

        foreach ($query->batch(100) as $rows) {
            foreach ($rows as $row) {
                $connection = Yii::$app->db;
                $connection->createCommand()
                    ->update(
                        $this->table,
                        [
                            'alias_en' => $row['alias'],
                            'alias_it' => $row['alias'],
                            'alias_de' => $row['alias']
                        ],
                        'id = ' . $row['id']
                    )
                    ->execute();
            }
        }

        $this->alterColumn($this->table, 'alias_en', $this->string(255)->unique()->notNull());
        $this->alterColumn($this->table, 'alias_it', $this->string(255)->unique()->notNull());
        $this->alterColumn($this->table, 'alias_de', $this->string(255)->unique()->notNull());
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'alias_de');
        $this->dropColumn($this->table, 'alias_it');
        $this->dropColumn($this->table, 'alias_en');
    }
}
