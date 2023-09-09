<?php

use Civi\Mailchimptemplate\Config;
use Civi\RcBase\Settings;
use CRM_Mailchimptemplate_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Mailchimptemplate_Form_MailchimpTemplateSettings extends CRM_Core_Form
{
    /**
     * @var string|null
     */
    private ?string $apikey;

    /**
     * @return void
     * @throws \CRM_Core_Exception
     */
    public function preProcess(): void
    {
        $this->apikey = Settings::get(Config::SETTINGKEY);
    }

    /**
     * @return void
     * @throws \CRM_Core_Exception
     */
    public function buildQuickForm(): void
    {
        // add form elements
        $this->add(
            'password', // field type
            Config::ELFIELDNAME, // field name
            E::ts('MailChimp API key'), // field label
            null, // list of options
            false // is required
        )
            ->setValue($this->apikey);

        $this->addButtons(
            [
                [
                    'type' => 'submit',
                    'name' => E::ts('Submit'),
                    'isDefault' => true,
                ],
            ]
        );

        // export form elements
        $this->assign('elementNames', $this->getRenderableElementNames());
        parent::buildQuickForm();
    }

    /**
     * @return void
     * @throws \CRM_Core_Exception
     */
    public function postProcess(): void
    {
        $sanitizedapikey = CRM_RcBase_Processor_Base::sanitizeString($this->exportValue(Config::ELFIELDNAME));
        Settings::saveSecret(Config::SETTINGKEY, $sanitizedapikey);
        CRM_Core_Session::setStatus(E::ts('Settings updated'), '', 'success', ['expires' => 5000]);
    }

    /**
     * Get the fields/elements defined in this form.
     *
     * @return array (string)
     */
    public function getRenderableElementNames(): array
    {
        // The _elements list includes some items which should not be
        // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
        // items don't have labels.  We'll identify renderable by filtering on
        // the 'label'.
        $elementNames = [];
        foreach ($this->_elements as $element) {
            $label = $element->getLabel();
            if (!empty($label)) {
                $elementNames[] = $element->getName();
            }
        }

        return $elementNames;
    }
}
