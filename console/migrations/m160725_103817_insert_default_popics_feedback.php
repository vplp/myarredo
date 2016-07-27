<?php

use yii\db\Migration;

class m160725_103817_insert_default_popics_feedback extends Migration
{
    /**
     * @var string
     */
    public $tableFeedback_topics = '{{%feedback_topics}}';

    /**
     * @var string
     */
    public $tableFeedback_topics_lang = '{{%feedback_topics_lang}}';

    /**
     * @var string
     */
    public $feedbacks = '{{%feedbacks}}';


    public function safeUp()
    {
        /** Insert feedback_topics */
        $this->batchInsert(
            $this->tableFeedback_topics,
            [
                'id',
                'sort',
                'created_at',
                'updated_at',
                'published',
                'deleted',
            ],
            [
                [
                    'id' => 1,
                    'sort' => 10,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => 1,
                    'deleted' => 0,
                ],
            ]
        );

        /** Insert feedback_topics_lang */
        $this->batchInsert(
            $this->tableFeedback_topics_lang,
            [
                'rid',
                'lang',
                'title',
            ],
            [
                [
                    'rid' => 1,
                    'lang' => 'en-EN',
                    'title' => 'test_en',
                ],
                [
                    'rid' => 1,
                    'lang' => 'ru-Ru',
                    'title' => 'test_ru',
                ],
            ]
        );

        /** Insert feedbacks */
        $this->batchInsert(
            $this->feedbacks,
            [
                'id',
                'topic_id',
                'name',
                'phone',
                'question',
                'email',
                'created_at',
                'updated_at',
                'published',
                'deleted',
            ],
            [
                [
                    'id' => 1,
                    'topic_id' => 1,
                    'name' => 'test',
                    'phone' => NULL,
                    'question' => 'test-test',
                    'email'=>'test@test.com',
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => 1,
                    'deleted' => 0,
                ],

            ]
        );

    }
}
