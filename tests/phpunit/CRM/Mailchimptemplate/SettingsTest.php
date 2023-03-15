<?php

use Civi\Mailchimptemplate\HeadlessTestCase;

/**
 * @group headless
 */
class CRM_Mailchimptemplate_SettingsTest extends HeadlessTestCase
{
    /**
     * Tests saving and loading settings
     *
     * @throws \Civi\RcBase\Exception\MissingArgumentException
     * @throws \Civi\RcBase\Exception\DataBaseException
     */
    public function testSaveLoadApikey(): void
    {
        $testApiKey = 'test-apikey';
        CRM_Mailchimptemplate_Settings::setApikey($testApiKey);
        self::assertEquals($testApiKey, CRM_Mailchimptemplate_Settings::getApikey(), 'Loaded "apikey" has to be equal with saved "apikey".');

        // Add new encryption key & rotate API key
        Civi::service('crypto.registry')->addSymmetricKey([
            'key' => '12345678901234567890123456789012',
            'suite' => 'aes-cbc',
            'tags' => ['CRED'],
            'weight' => -1,
        ]);
        $key_raw = Civi::settings()->get(CRM_Mailchimptemplate_Settings::SETTINGKEY);
        CRM_Mailchimptemplate_Settings::rotateApikey();
        $key_raw_rekeyed = Civi::settings()->get(CRM_Mailchimptemplate_Settings::SETTINGKEY);
        self::assertNotSame($key_raw, $key_raw_rekeyed, 'API key not rotated');
    }
}
