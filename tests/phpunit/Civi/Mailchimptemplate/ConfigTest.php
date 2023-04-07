<?php

namespace Civi\Mailchimptemplate;

use Civi;

/**
 * @group headless
 */
class ConfigTest extends HeadlessTestCase
{
    /**
     * @throws \Civi\RcBase\Exception\MissingArgumentException
     * @throws \Civi\RcBase\Exception\DataBaseException|\CRM_Core_Exception
     */
    public function testSaveLoadApikey(): void
    {
        $testApiKey = 'test-apikey';
        Config::setApikey($testApiKey);
        self::assertEquals($testApiKey, Config::getApikey(), 'Loaded "apikey" has to be equal with saved "apikey".');

        // Add new encryption key & rotate API key
        Civi::service('crypto.registry')->addSymmetricKey([
            'key' => '12345678901234567890123456789012',
            'suite' => 'aes-cbc',
            'tags' => ['CRED'],
            'weight' => -1,
        ]);
        $key_raw = Civi::settings()->get(Config::SETTINGKEY);
        Config::rotateApikey();
        $key_raw_rekeyed = Civi::settings()->get(Config::SETTINGKEY);
        self::assertNotSame($key_raw, $key_raw_rekeyed, 'API key not rotated');
    }
}
