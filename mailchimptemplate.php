<?php

require_once 'mailchimptemplate.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function mailchimptemplate_civicrm_config(&$config) {
  _mailchimptemplate_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param array $files
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function mailchimptemplate_civicrm_xmlMenu(&$files) {
  _mailchimptemplate_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function mailchimptemplate_civicrm_install() {
  _mailchimptemplate_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function mailchimptemplate_civicrm_uninstall() {
  _mailchimptemplate_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function mailchimptemplate_civicrm_enable() {
  _mailchimptemplate_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function mailchimptemplate_civicrm_disable() {
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
function mailchimptemplate_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _mailchimptemplate_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function mailchimptemplate_civicrm_managed(&$entities) {
  _mailchimptemplate_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * @param array $caseTypes
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function mailchimptemplate_civicrm_caseTypes(&$caseTypes) {
  _mailchimptemplate_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function mailchimptemplate_civicrm_angularModules(&$angularModules) {
_mailchimptemplate_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function mailchimptemplate_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _mailchimptemplate_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function mailchimptemplate_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 */
function mailchimptemplate_civicrm_navigationMenu(&$params) {
  require_once('CRM/Core/BAO/Navigation.php');
  // Check that our item doesn't already exist
  $menu_item_search = array('url' => 'civicrm/mailchimptemplate');
  $menu_items = array();
  CRM_Core_BAO_Navigation::retrieve($menu_item_search, $menu_items);
  if (!empty($menu_items)) {
    return;
  }

  $navID = CRM_Core_DAO::singleValueQuery("SELECT max(id) FROM civicrm_navigation");
  $navID = intval($navID);
  $navID += 100; // this is weird stuff, if it's 1, it's overwriting sendgrid's

  // Find the CiviMail menu
  $parentID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_Navigation', 'Mailings', 'id', 'name');
  $params[$parentID]['child'][$navID] = array(
      'attributes' => array(
          'label' => ts('Mailchimp Campaign Import'),
          'name' => 'Mailchimp Campaign Import',
          'url' => 'civicrm/mailchimptemplate',
          'permission' => 'access CiviMail',
          'operator' => 'OR',
          'separator' => 1,
          'parentID' => $parentID,
          'navID' => $navID,
          'active' => 1
      )
  );
}
