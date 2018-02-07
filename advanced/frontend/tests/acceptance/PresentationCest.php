<?php
namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use common\fixtures\UserFixture;
use common\fixtures\ProfileFixture;
use common\fixtures\CategoryFixture;
use common\fixtures\PresentationFixture;
use yii\helpers\Url;


class PresentationCest
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
    
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->resizeWindow(1400, 1200);
        $I->click('Sign in');
        
        $I->fillField('login-form[login]', 'maria');
        $I->fillField('login-form[password]', 'password_0');
        
        $I->click('button[type=submit]');
        $I->wait(3);
    }

    public function viewPresentations(AcceptanceTester $I)
    {
        $I->see('Presentations', 'h1');
        
        $I->seeNumberOfElements('.grid-view tr[data-key]', 2); // 2 presentations are expected to seen
        
        $I->seeLink('Some Title');
        $I->seeLink('Paul presentation');
        
        
        // View presentation page
        $presentation = $I->grabFixture('presentation', 'presentation-paul');
        $I->amOnPage(Url::toRoute(['/presentation/slug', 'slug' => $presentation->public_url]));
        
        $I->seeInTitle($presentation->title);
        $I->seeElement('img.image-preview');
        
        $I->seeLink('View Presentation');
        
        $I->see('Comments', 'h3.comment-title');
    }

    public function searchPresentationsForm(AcceptanceTester $I)
    {
        // empty form
        $I->seeNumberOfElements('.grid-view tr[data-key]', 2); // 2 presentations are expected to seen
        
        $I->fillField('PresentationSearch[username]', 'paul');
        $I->click('Search');
        $I->wait(1);
        $I->seeNumberOfElements('.grid-view tr[data-key]', 1); // 1 presentation is found
        
        
        $I->fillField('PresentationSearch[title]', 'not-present-title');
        $I->click('Search');
        $I->wait(1);
        $I->seeNumberOfElements('.grid-view tr[data-key]', 0); // no title is found
        
        
        $I->fillField('PresentationSearch[title]', 'paul');
        $I->selectOption('PresentationSearch[category_id]', '3');
        $I->click('Search');
        $I->wait(1);
        $I->seeNumberOfElements('.grid-view tr[data-key]', 1); // presentation is found by title, username and category
    }
}
