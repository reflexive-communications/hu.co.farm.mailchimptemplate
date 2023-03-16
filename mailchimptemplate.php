<?php

require_once 'mailchimptemplate.civix.php';

use CRM_Mailchimptemplate_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function mailchimptemplate_civicrm_config(&$config): void
{
    _mailchimptemplate_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 */
function mailchimptemplate_civicrm_navigationMenu(&$params): void
{
    require_once('CRM/Core/BAO/Navigation.php');
    // Check that our item doesn't already exist
    $menu_item_search = ['url' => 'civicrm/mailchimptemplate'];
    $menu_items = [];
    CRM_Core_BAO_Navigation::retrieve($menu_item_search, $menu_items);
    if (!empty($menu_items)) {
        return;
    }

    $navID = CRM_Core_DAO::singleValueQuery("SELECT max(id) FROM civicrm_navigation");
    $navID = intval($navID);
    $navID += 100; // this is weird stuff, if it's 1, it's overwriting sendgrid's

    // Find the CiviMail menu
    $parentID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_Navigation', 'Mailings', 'id', 'name');
    $params[$parentID]['child'][$navID] = [
        'attributes' => [
            'label' => E::ts('Mailchimp Campaign Import'),
            'name' => 'Mailchimp Campaign Import',
            'url' => 'civicrm/mailchimptemplate',
            'permission' => 'access CiviMail',
            'operator' => 'OR',
            'separator' => 1,
            'parentID' => $parentID,
            'navID' => $navID,
            'active' => 1,
        ],
    ];

    // Settings menu
    _mailchimptemplate_civix_insert_navigation_menu($params, 'Administer/CiviMail', [
        'label' => E::ts('MailChimp Settings'),
        'name' => 'MailChimp Settings',
        'url' => 'civicrm/mailchimptemplate/settings',
        'permission' => 'administer CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
        'active' => 1,
    ]);

    _mailchimptemplate_civix_navigationMenu($params);
}

/**
 * Implements hook_civicrm_cryptoRotateKey().
 *
 * @param $tag
 * @param $log
 *
 * @return void
 * @throws \Civi\RcBase\Exception\DataBaseException
 * @throws \Civi\RcBase\Exception\MissingArgumentException
 */
function mailchimptemplate_civicrm_cryptoRotateKey($tag, $log): void
{
    if ($tag !== 'CRED') {
        return;
    }
    CRM_Mailchimptemplate_Settings::rotateApikey();
    $log->info(E::LONG_NAME.': Successful re-keying');
}
