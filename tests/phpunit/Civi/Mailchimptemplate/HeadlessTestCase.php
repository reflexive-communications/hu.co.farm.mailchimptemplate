<?php

namespace Civi\Mailchimptemplate;

use Civi\Test;
use PHPUnit\Framework\TestCase;
use Civi\Test\HeadlessInterface;

/**
 * @group headless
 */
class HeadlessTestCase extends TestCase implements HeadlessInterface
{
    /**
     * Apply a forced rebuild of DB, thus
     * create a clean DB before running tests
     *
     * @throws \CRM_Extension_Exception_ParseException
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
     * @return void
     */
    public function setUpHeadless(): void
    {
    }
}
