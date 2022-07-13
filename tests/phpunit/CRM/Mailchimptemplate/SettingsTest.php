<?php

use Civi\Test;
use PHPUnit\Framework\TestCase;
use Civi\Test\HeadlessInterface;

/**
 * This is a generic test class for the extension (implemented with PHPUnit).
 *
 * @group headless
 */
class CRM_Mailchimptemplate_SettingsTest extends TestCase implements HeadlessInterface
{
    public function setUpHeadless()
    {
        return Test::headless()
            ->install('rc-base')
            ->installMe(__DIR__)
            ->apply();
    }

    /**
     * Tests saving and loading settings
     */
    public function testSaveLoadApikey(): void
    {
        $testApiKey = 'test-apikey';
        CRM_Mailchimptemplate_Settings::setApikey($testApiKey);
        self::assertEquals($testApiKey, CRM_Mailchimptemplate_Settings::getApikey(), 'Loaded "apikey" has to be equal with saved "apikey".');
    }
}
