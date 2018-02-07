<?php
namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use common\fixtures\UserFixture;
use common\fixtures\ProfileFixture;
use yii\helpers\Url;


class HomeCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
            'profile' => [
                'class' => ProfileFixture::className(),
                'dataFile' => codecept_data_dir() . 'profile.php',
            ],
        ];
    }

    public function checkHome(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->resizeWindow(1400, 1200);
        
        $I->see('Here You can see example of our users works');
        $I->seeLink('Sign up');
        $I->seeLink('Sign in');
    }

    public function checkLoginRegistrationForm(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->resizeWindow(1400, 1200);
        $I->click('Sign in');
        
        $I->fillField('login-form[login]', 'wrong_login');
        $I->fillField('login-form[password]', 'wrong_password');
        
        $I->click('button[type=submit]');
        $I->seeValidationError('Invalid login or password');
        
        
        $mariaUser = $I->grabFixture('user', 'user-maria');
        
        $I->fillField('login-form[login]', $mariaUser->username);
        $I->fillField('login-form[password]', 'password_0');
        
        $I->click('button[type=submit]');
        $I->wait(3);
        $I->see('Presentations', 'h1'); // user is logged in and can see presentations list
        $I->see('Search', 'button[type=submit]');
    }
}
