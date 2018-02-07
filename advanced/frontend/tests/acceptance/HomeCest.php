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
        
        $I->see('Here You can see example of our users workss');
        $I->seeLink('Sign up');
        $I->seeLink('Sign in');
    }

    public function checkLoginRegistrationForm(AcceptanceTester $I)
    {
        $I->amOnPage('/user/login');
        $I->resizeWindow(1400, 1200);
        
        $I->fillField('login-form[login]', 'wrong_login');
        $I->fillField('login-form[password]', 'wrong_password');
        
        $I->click('button[type=submit]');
        $I->dontSeeLink('Logout (maria)');  // user is not logged in
        
        /*
        $I->amOnPage('/user/register');
        //$I->resizeWindow(1400, 1200);
        
        $I->fillField('register-form[email]', 'max@mail.com');
        $I->fillField('register-form[username]', 'max');
        $I->fillField('register-form[password]', '123456');
        $I->click('button[type=submit]');
        
        $I->see('Your account has been created');
        
        $I->amOnPage('/user/login');
        //$I->resizeWindow(1400, 1200);
        */
        $I->fillField('login-form[login]', 'admin');
        $I->fillField('login-form[password]', 'admin');
        
        $I->click('button[type=submit]');
        $I->seeLink('Presentations');
        $I->seeLink('Logout (maxx)');  // user is logged in
        
        
        
        /*
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester.email',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->seeValidationError('Email is not a valid email address.');
        $I->dontSeeValidationError('Name cannot be blank');
        */
    }
}
