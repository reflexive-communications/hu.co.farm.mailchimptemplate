<?php

use Civi\Mailchimptemplate\HeadlessTestCase;

/**
 * Test for the settings form
 *
 * @group headless
 */
class CRM_Mailchimptemplate_Form_MailchimpTemplateSettingsTest extends HeadlessTestCase
{
    public function testPreProcess()
    {
        $form = new CRM_Mailchimptemplate_Form_MailchimpTemplateSettings();
        $this->assertEmpty($form->preProcess());
    }

    public function testBuildQuickForm()
    {
        $form = new CRM_Mailchimptemplate_Form_MailchimpTemplateSettings();
        $form->preProcess();
        $this->assertEmpty($form->buildQuickForm());
    }

    public function testPostProcess()
    {
        $apikey = 'postprocess-apikey';

        $form = new CRM_Mailchimptemplate_Form_MailchimpTemplateSettings();
        $form->preProcess();
        $form->buildQuickForm();

        $submitValues = [
            CRM_Mailchimptemplate_Settings::ELFIELDNAME => $apikey,
        ];
        $form->setVar('_submitValues', $submitValues);
        $this->assertEmpty($form->postProcess());

        $savedApiKey = CRM_Mailchimptemplate_Settings::getApikey();
        $this->assertEquals($apikey, $savedApiKey, 'Form saved API key is wrong.');
    }
}
