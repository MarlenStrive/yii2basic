<?php

namespace api\tests\api;

use api\tests\ApiTester;
use common\fixtures\UserFixture;
use common\fixtures\ProfileFixture;
use common\fixtures\CategoryFixture;
use common\fixtures\PresentationFixture;
use common\fixtures\PresentationPageFixture;
use yii\helpers\Url;
use yii\helpers\Json;


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
            'presentation_page' => [
                'class' => PresentationPageFixture::className(),
                'dataFile' => codecept_data_dir() . 'presentation_page.php',
            ],
        ];
    }

    public function _before(ApiTester $I)
    {
        // Authenticate user
        $I->sendPOST(Url::toRoute('/oauth2/rest/token'), [
            'grant_type' => 'password',
            'username' => 'maria',
            'password' => 'password_0',
            'client_id' => 'testclient',
            'client_secret' => 'testpass',
        ]);
        
        $response = Json::decode($I->grabResponse());
        if (array_key_exists('access_token', $response)) {
            $I->amBearerAuthenticated($response['access_token']);
        }
    }

    public function checkPresentationsList(ApiTester $I)
    {
        $I->sendGET(Url::toRoute('/v1/presentation/list'));
        
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseContainsJson([
            [
                'id' => 1,
                'user_id' => 1,
                'title' => 'Some Title',
                'description' => 'Some Description',
                'description_pure' => 'Some Description',
                'is_public' => 1,
                'image_preview' => 0,
                'image' => null,
                'created_at' => '1517834543',
                'updated_at' => '1517834543',
                'publication_date' => null,
                'expiration_date' => null,
                'public_url' => 'some_title',
                'rating' => 0,
                'category_id' => 1,
            ], [
                'id' => 2,
                'user_id' => 1,
                'title' => 'Some Another Title',
                'description' => 'Some Another Description',
                'description_pure' => 'Some Another Description',
                'is_public' => 0,
                'image_preview' => 0,
                'image' => null,
                'created_at' => '1517834545',
                'updated_at' => '1517834545',
                'publication_date' => null,
                'expiration_date' => null,
                'public_url' => 'some_another_title',
                'rating' => 1,
                'category_id' => 2,
            ],
        ]);
        
    }

    public function checkUpdatePage(ApiTester $I)
    {
        $I->sendPOST(Url::toRoute(['/v1/presentation/update-page', 'slug' => 'some_title', 'number' => 8]), [
            'content' => 'Some new page content',
            'note' => 'Some new note',
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND); // 404
        
        
        $I->sendPOST(Url::toRoute(['/v1/presentation/update-page', 'slug' => 'some_title', 'number' => 2]), [
            'content' => 'Some new page content',
            'note' => 'Some new note',
        ]);
        
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'content' => 'Some new page content',
            'note' => 'Some new note',
        ]);
    }

}
