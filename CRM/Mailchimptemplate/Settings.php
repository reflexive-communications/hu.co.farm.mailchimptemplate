<?php

use Civi\RcBase\Settings;

class CRM_Mailchimptemplate_Settings
{
    public const SETTINGKEY = 'MailchimpTemplate_apikey';

    public const ELFIELDNAME = 'apikey';

    public static function getApikey(): ?string
    {
        return CRM_RcBase_Setting::get(self::SETTINGKEY);
    }

    public static function setApikey($value): void
    {
        CRM_RcBase_Setting::saveSecret(self::SETTINGKEY, $value);
    }

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
