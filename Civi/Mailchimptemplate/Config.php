<?php

namespace Civi\Mailchimptemplate;

use Civi\RcBase\Settings;

/**
 * MailChimp settings
 */
class Config
{
    public const SETTINGKEY = 'MailchimpTemplate_apikey';

    public const ELFIELDNAME = 'apikey';

    /**
     * Re-encrypt API key with new credential key
     *
     * @return void
     * @throws \Civi\RcBase\Exception\DataBaseException
     * @throws \Civi\RcBase\Exception\MissingArgumentException
     */
    public static function rotateApikey(): void
    {
        Settings::rotateSecret(self::SETTINGKEY);
    }
}
