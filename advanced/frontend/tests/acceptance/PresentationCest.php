<?php
namespace frontend\tests\acceptance;

//use Yii;
use frontend\tests\AcceptanceTester;
use common\fixtures\UserFixture;
use common\fixtures\ProfileFixture;
use common\fixtures\CategoryFixture;
use common\fixtures\PresentationFixture;


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

    public function viewPresentation(AcceptanceTester $I)
    {
        
        
        /*
        $mariaUser = $I->grabFixture('user', 'user-maria');
        
        $I->amLoggedInAs($mariaUser->id);
        $I->amOnPage('/presentation');
        
        $I->see('Presentations', 'div.presentation-index h1');
        $I->seeLink('Create Presentation', '/presentation/create');
        
        $I->seeNumberOfElements('.grid-view tr[data-key]', 3); // 3 presentations are expected to seen
        
        */
        
        
        
        /*
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see('My Application');

        $I->seeLink('About');
        $I->click('About');
        $I->wait(2); // wait for page to be opened

        $I->see('This is the About page.');
        */
        
        
        
        
        
    }
}
