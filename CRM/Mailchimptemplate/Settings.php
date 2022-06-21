<?php

class CRM_Mailchimptemplate_Settings
{
    private const SETTINGKEY = 'MailchimpTemplate_apikey';
    public const ELFIELDNAME = 'apikey';

    public static function getApikey()
    {
        return CRM_RcBase_Setting::get(self::SETTINGKEY);
    }

    public static function setApikey($value)
    {
        CRM_RcBase_Setting::saveSecret(self::SETTINGKEY, $value);
    }
}
