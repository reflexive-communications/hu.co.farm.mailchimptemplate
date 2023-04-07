<?php

use Civi\Mailchimptemplate\Config;
use Civi\Mailchimptemplate\HeadlessTestCase;

/**
 * @group headless
 */
class CRM_Mailchimptemplate_Form_MailchimpTemplateSettingsTest extends HeadlessTestCase
{
    /**
     * @return void
     * @throws \CRM_Core_Exception
     */
    public function testPreProcess()
    {
        $form = new CRM_Mailchimptemplate_Form_MailchimpTemplateSettings();
        $this->assertEmpty($form->preProcess());
    }

    /**
     * @return void
     * @throws \CRM_Core_Exception
     */
    public function testBuildQuickForm()
    {
        $form = new CRM_Mailchimptemplate_Form_MailchimpTemplateSettings();
        $form->preProcess();
        $this->assertEmpty($form->buildQuickForm());
    }

    /**
     * @return void
     * @throws \CRM_Core_Exception
     */
    public function testPostProcess()
    {
        $apikey = 'postprocess-apikey';

        $form = new CRM_Mailchimptemplate_Form_MailchimpTemplateSettings();
        $form->preProcess();
        $form->buildQuickForm();

        $submitValues = [
            Config::ELFIELDNAME => $apikey,
        ];
        $form->setVar('_submitValues', $submitValues);
        $this->assertEmpty($form->postProcess());

        $savedApiKey = Config::getApikey();
        $this->assertEquals($apikey, $savedApiKey, 'Form saved API key is wrong.');
    }
}
