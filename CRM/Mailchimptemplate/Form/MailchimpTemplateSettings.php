<?php

use CRM_Mailchimptemplate_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Mailchimptemplate_Form_MailchimpTemplateSettings extends CRM_Core_Form
{
    private $apikey = null;

    public function preProcess()
    {
        parent::preProcess();
        $this->apikey = CRM_Mailchimptemplate_Settings::getApikey();
    }

    public function buildQuickForm()
    {
        // add form elements
        $this->add(
            'text', // field type
            CRM_Mailchimptemplate_Settings::ELFIELDNAME, // field name
            E::ts('MailChimp API key'), // field label
            null, // list of options
            false // is required
        )
            ->setValue($this->apikey);

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
        $sanitizedapikey = CRM_RcBase_Processor_Base::sanitizeString($this->exportValue(CRM_Mailchimptemplate_Settings::ELFIELDNAME));
        CRM_Mailchimptemplate_Settings::setApikey($sanitizedapikey);
        CRM_Utils_System::redirect('/civicrm/admin');
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
