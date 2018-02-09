<?php

namespace api\tests\api;

use api\tests\ApiTester;
use common\fixtures\UserFixture;
use common\fixtures\ProfileFixture;
use yii\helpers\Url;
use yii\helpers\Json;


class ProfileCest
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

    public function checkViewOwn(ApiTester $I)
    {
        $I->wantTo('test the profile view REST API');
        
        $I->sendGET(Url::toRoute('/v1/profile/view-own'));
        
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseContainsJson([
            'name' => 'Maria',
            'second_name' => 'Surname',
            'public_email' => null,
            'website' => null,
            'country' => 'Ukraine',
            'city' => 'Kyiv',
            'timezone' => null,
            'language' => null,
            'gravatar_email' => null,
            'bio' => null,
        ]);
        
    }

    public function checkUpdateOwn(ApiTester $I)
    {
        $I->wantTo('test the profile update REST API');
        
        $I->sendPOST(Url::toRoute('/v1/profile/update-own'), [
            'public_email' => 'someemail@mail.com',
            'website' => 'http://github.com',
            'country' => 'Uruguay',
            'language' => 'Russian',
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        
        $I->sendGET(Url::toRoute('/v1/profile/view-own'));
        $I->seeResponseContainsJson([
            'name' => 'Maria',
            'second_name' => 'Surname',
            'public_email' => 'someemail@mail.com',
            'website' => 'http://github.com',
            'country' => 'Uruguay',
            'city' => 'Kyiv',
            'timezone' => null,
            'language' => 'Russian',
            'gravatar_email' => null,
            'bio' => null,
        ]);
    }

}
