<?php

namespace common\tests\unit\models;

use common\models\Profile;
use common\fixtures\ProfileFixture;

/**
 * Profile test
 */
class ProfileTest extends \Codeception\Test\Unit
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
            'profile' => [
                'class' => ProfileFixture::className(),
                'dataFile' => codecept_data_dir() . 'profile.php',
            ],
        ];
    }

    public function testGetPublicName()
    {
        $profile = $this->tester->grabFixture('profile', 'profile-maria');
        
        $profile->public_fields = 'name,second_name';
        expect('Show name and surname', $profile->getPublicName())->equals('Maria Surname');
        
        $profile->public_fields = 'name';
        expect('Show name', $profile->getPublicName())->equals('Maria');
        
        $profile->public_fields = 'second_name';
        expect('Show surname', $profile->getPublicName())->equals('Surname');
        
        $profile->public_fields = '';
        expect('Show empty string', $profile->getPublicName())->equals('');
    }

    public function testGetPublicLocation()
    {
        $profile = $this->tester->grabFixture('profile', 'profile-maria');
        
        $profile->public_fields = 'city,country';
        expect('Show city and country', $profile->getPublicLocation())->equals('Ukraine, Kyiv');
        
        $profile->public_fields = 'city';
        expect('Show city', $profile->getPublicLocation())->equals('Kyiv');
        
        $profile->public_fields = 'country';
        expect('Show country', $profile->getPublicLocation())->equals('Ukraine');
        
        $profile->public_fields = '';
        expect('Show empty string', $profile->getPublicLocation())->equals('');
    }
}
