<?php

require_once 'CRM/Core/Form.php';
require_once 'vendor/MailChimp.php';

use DrewM\MailChimp\MailChimp;
use CRM_Mailchimptemplate_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Mailchimptemplate_Form_MailchimpTemplate extends CRM_Core_Form
{
    private $MailChimp = null;

    public function __construct()
    {
        $apikey = CRM_Mailchimptemplate_Settings::getApikey();
        $this->MailChimp = new MailChimp($apikey);
        parent::__construct();
    }

    public function buildQuickForm()
    {
        // add form elements
        $this->add(
            'select', // field type
            'campaign', // field name
            E::ts('Campaign to import'), // field label
            $this->getCampaigns(), // list of options
            true // is required
        );
        $this->addButtons(
            array(
                array(
                    'type' => 'submit',
                    'name' => E::ts('Submit'),
                    'isDefault' => true,
                ),
            )
        );

        // export form elements
        $this->assign('elementNames', $this->getRenderableElementNames());
        parent::buildQuickForm();
    }

    public function postProcess()
    {
        $values = $this->exportValues();
        $campaign_id = $values['campaign'];

        $campaign = $this->MailChimp->get("campaigns/$campaign_id");
        $content = $this->MailChimp->get("campaigns/$campaign_id/content");

        $chimp_tokens = [
            '*|LIST:ADDRESS|*',
            '*|LIST:ADDRESS_HTML|*',
            '*|LIST:ADDRESSLINE|*',
            '*|LIST_ADDRESSLINE_TEXT|*',
            '*|EMAIL|*',
            '*|ARCHIVE|*',
            '*|UNSUB|*',
            '*|REWARDS|*',
            '*|REWARDS_TEXT|*',
            '*|MC_PREVIEW_TEXT|*',
            '*|ABOUT_LIST|*',
        ];
        $civi_tokens = [
            '{domain.address}',
            '{domain.address}',
            '{domain.address}',
            '{domain.address}',
            '{contact.email}',
            $campaign['archive_url'],
            '{action.optOutUrl}',
            '',
            '',
            '',
            ''
        ];

        $html = str_replace($chimp_tokens, $civi_tokens, $content['html']);
        $html = preg_replace('/<!--(.|\s)*?-->/', '', $html); // remove html comments, ms office comments break stuff

        $text = str_replace($chimp_tokens, $civi_tokens, $content['plain_text']);

        $result = civicrm_api3(
            'Mailing',
            'create',
            array(
                'sequential' => 1,
                'created_id' => "user_contact_id",
                'name' => $campaign['settings']['title'],
                'subject' => $campaign['settings']['subject_line'],
                'body_html' => $html,
                'body_text' => $text,
            )
        );
        // dpm($result, 'mailing result');

        CRM_Utils_System::redirect('/civicrm/a#/mailing/' . $result['id']);

        // CRM_Core_Session::setStatus(ts('You picked campaign "%1"', array(
        //   1 => $options[$values['campaign']]
        // )));
        // parent::postProcess();
    }

    public function getCampaigns()
    {
        $limit = 999;

        $result = $this->MailChimp->get(
            'campaigns',
            [
                'count' => $limit,
                // 'since_create_time' => date("c", strtotime("-12 months")),
                'fields' => ['settings.title'],
            ]
        );

        $campaigns = [];
        foreach ($result['campaigns'] as $campaign) {
            if (!empty($campaign['settings']['title'])) {
                $campaigns[$campaign['id']] = $campaign['settings']['title'];
            }
        }
        array_multisort($campaigns);

        return $campaigns;
    }

    /**
     * Get the fields/elements defined in this form.
     *
     * @return array (string)
     */
    public function getRenderableElementNames()
    {
        // The _elements list includes some items which should not be
        // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
        // items don't have labels.  We'll identify renderable by filtering on
        // the 'label'.
        $elementNames = array();
        foreach ($this->_elements as $element) {
            /** @var HTML_QuickForm_Element $element */
            $label = $element->getLabel();
            if (!empty($label)) {
                $elementNames[] = $element->getName();
            }
        }

        return $elementNames;
    }
}
