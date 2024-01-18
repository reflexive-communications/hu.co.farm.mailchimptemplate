<?php

namespace Civi\Mailchimptemplate;

use Civi;
use Civi\RcBase\Settings;

/**
 * @group headless
 */
class ConfigTest extends HeadlessTestCase
{
    /**
     * @return void
     * @throws \Civi\RcBase\Exception\DataBaseException
     * @throws \Civi\RcBase\Exception\MissingArgumentException
     */
    public function testRotateKeys()
    {
        Settings::saveSecret(Config::SETTINGKEY, 'old-pass');
        // Use Civi::settings() to fetch the cipher, as \Civi\RcBase\Settings::get will decrypt it
        $old_cipher = Civi::settings()->get(Config::SETTINGKEY);

        // Add new encryption key & rotate tokens
        Civi::service('crypto.registry')->addSymmetricKey([
            'key' => '12345678901234567890123456789012',
            'suite' => 'aes-cbc',
            'tags' => ['CRED'],
            'weight' => -1,
        ]);
        Config::rotateApikey();

        // Use Civi::settings() to fetch the cipher, as \Civi\RcBase\Settings::get will decrypt it
        $new_cipher = Civi::settings()->get(Config::SETTINGKEY);
        self::assertTrue(Settings::isEncrypted($new_cipher), 'API key not encrypted');
        self::assertNotSame($old_cipher, $new_cipher, 'Key not rotated');
    }
}
