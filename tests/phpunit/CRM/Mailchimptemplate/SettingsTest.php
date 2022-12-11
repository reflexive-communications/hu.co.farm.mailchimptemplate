<?php

use Civi\Test;
use PHPUnit\Framework\TestCase;
use Civi\Test\HeadlessInterface;

/**
 * @group headless
 */
class CRM_Mailchimptemplate_SettingsTest extends TestCase implements HeadlessInterface
{
    public function setUpHeadless()
    {
    }

    /**
     * Apply a forced rebuild of DB, thus
     * create a clean DB before running tests
     *
     * @throws CRM_Extension_Exception_ParseException
     */
    public static function setUpBeforeClass(): void
    {
        // Resets DB and install depended extension
        Test::headless()
            ->install('rc-base')
            ->installMe(__DIR__)
            ->apply(true);
    }

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
