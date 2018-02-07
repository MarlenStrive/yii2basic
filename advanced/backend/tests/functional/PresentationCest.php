<?php

namespace backend\tests\functional;

use Yii;
use backend\tests\FunctionalTester;
use common\fixtures\PresentationFixture;
use common\fixtures\UserFixture;
use common\fixtures\ProfileFixture;
use common\fixtures\CategoryFixture;


/**
 * Class PresentationCest
 */
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

    /**
     * @param FunctionalTester $I
     */
    public function viewPresentations(FunctionalTester $I)
    {
        $mariaUser = $I->grabFixture('user', 'user-maria');
        
        $I->amLoggedInAs($mariaUser->id);
        $I->amOnPage('/presentation');
        
        $I->see('Presentations', 'div.presentation-index h1');
        $I->seeLink('Create Presentation', '/presentation/create');
        
        $I->seeNumberOfElements('.grid-view tr[data-key]', 3); // 3 presentations are expected to seen
    }

    /**
     * @param FunctionalTester $I
     */
    public function viewPresentation(FunctionalTester $I)
    {
        $mariaUser = $I->grabFixture('user', 'user-maria');
        $presentation = $I->grabFixture('presentation', 'presentation-maria');
        
        $I->amLoggedInAs($mariaUser->id);
        
        $I->amOnPage(['presentation/view', 'id' => $presentation->id]);
        
        $I->seeInTitle($presentation->title);
        $I->seeLink('Update', Yii::$app->getUrlManager()->createUrl(['presentation/update', 'id' => $presentation->id]));
        $I->seeLink('Delete', Yii::$app->getUrlManager()->createUrl(['presentation/delete', 'id' => $presentation->id]));
        
        $I->seeNumberOfElements('.detail-view tr', 14); // number of lines in the view table
        
        /*
        //$I->seeRecord($model)
        */
    }
    
}
