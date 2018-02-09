<?php

namespace common\tests\unit\models;

use Yii;
use common\models\Presentation;
use common\fixtures\PresentationFixture;
use common\fixtures\UserFixture;
use common\fixtures\CategoryFixture;
use dektrium\user\models\LoginForm;

/**
 * Presentation test
 */
class PresentationTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
            'category' => [
                'class' => CategoryFixture::className(),
                'dataFile' => codecept_data_dir() . 'category.php',
            ],
            'presentation' => [
                'class' => PresentationFixture::className(),
                'dataFile' => codecept_data_dir() . 'presentation.php',
            ],
        ];
    }

    public function testGetCurrentRating()
    {
        $mariaUser = $this->tester->grabFixture('user', 'user-maria');
        expect('Maria presentations', Presentation::getCurrentRating($mariaUser->id))->equals(2);
        
        $paulUser = $this->tester->grabFixture('user', 'user-paul');
        expect('Paul presentations', Presentation::getCurrentRating($paulUser->id))->equals(1);
    }

    public function testFillDefaultValues()
    {
        $mariaUser = $this->tester->grabFixture('user', 'user-maria');
        
        $loginForm = Yii::createObject(LoginForm::className());
        $loginForm->setAttributes([
            'login' => $mariaUser->username,
            'password' => 'password_0',
        ]);
        
        expect_that($loginForm->login());
        
        $presentation = new Presentation();
        $presentation->fillDefaultValues();
        
        expect('presentation user_id', $presentation->user_id)->equals($mariaUser->id);
        expect('presentation rating', $presentation->rating)->equals(2);
        expect('presentation is_public', $presentation->is_public)->equals(0);
    }
}
