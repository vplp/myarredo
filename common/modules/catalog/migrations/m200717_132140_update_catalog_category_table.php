<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m200717_132140_update_catalog_category_table extends Migration
{

    /**
     * @var string
     */
    public $table = '{{%catalog_group}}';

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
            'alias_it',
            $this->string(255)->notNull()->after('alias2')
        );
        $this->addColumn(
            $this->table,
            'alias_de',
            $this->string(255)->notNull()->after('alias_it')
        );

        $rows = (new \yii\db\Query())
            ->from($this->table)
            ->all();

        foreach ($rows as $row) {
            $connection = Yii::$app->db;
            $connection->createCommand()
                ->update(
                    $this->table,
                    [
                        'alias_it' => $row['alias2'],
                        'alias_de' => $row['alias2']
                    ],
                    'id = ' . $row['id']
                )
                ->execute();
        }

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
    }
}
