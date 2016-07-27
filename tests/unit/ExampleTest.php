<?php

use thread\modules\user\models\User;

class ExampleTest extends \PHPUnit_Framework_TestCase
{

    protected $tester;
    protected $user_id;

    protected function setUp()
    {
        $this->user_id = 1;
    }

    protected function tearDown()
    {
    }

    // tests
    function testUserExist()
    {
//        $user = User::find($this->user_id);
//        $this->assertFalse($user);
//        $this->tester->dontSeeRecord('users', [
//            'id' => $this->user_id,
//        ]);
//        echo 'complited';
    }
}
