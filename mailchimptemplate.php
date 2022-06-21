<?php

use CRM_Mailchimptemplate_ExtensionUtil as E;

require_once 'mailchimptemplate.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function mailchimptemplate_civicrm_config(&$config)
{
    _mailchimptemplate_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function mailchimptemplate_civicrm_install()
{
    _mailchimptemplate_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function mailchimptemplate_civicrm_uninstall()
{
    _mailchimptemplate_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function mailchimptemplate_civicrm_enable()
{
    _mailchimptemplate_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function mailchimptemplate_civicrm_disable()
{
    _mailchimptemplate_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function mailchimptemplate_civicrm_upgrade($op, CRM_Queue_Queue $queue = null)
{
    return _mailchimptemplate_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
 * function mailchimptemplate_civicrm_preProcess($formName, &$form) {
 *
 * } // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 */
function mailchimptemplate_civicrm_navigationMenu(&$params)
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
        'active' => 1
    ]);

    _mailchimptemplate_civix_navigationMenu($params);
}

function mailchimptemplate_civicrm_xmlMenu(&$files)
{
    $files[] = dirname(__FILE__) . '/xml/Menu/mailchimptemplate.xml';
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function mailchimptemplate_civicrm_postInstall()
{
    _mailchimptemplate_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function mailchimptemplate_civicrm_entityTypes(&$entityTypes)
{
    _mailchimptemplate_civix_civicrm_entityTypes($entityTypes);
}
