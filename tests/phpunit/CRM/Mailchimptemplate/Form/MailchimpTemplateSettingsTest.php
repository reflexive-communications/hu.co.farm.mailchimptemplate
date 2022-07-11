<?php

use Civi\Test;
use CRM_Mailchimptemplate_ExtensionUtil as E;
use Civi\Test\HeadlessInterface;
use Civi\Test\HookInterface;
use Civi\Test\TransactionalInterface;
use Civi\Test\CiviEnvBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Test for the settings form
 *
 * @group headless
 */
class CRM_Mailchimptemplate_Form_MailchimpTemplateSettingsTest extends TestCase implements
    HeadlessInterface,
    HookInterface,
    TransactionalInterface
{

    /**
     * Setup used when HeadlessInterface is implemented.
     *
     * Civi\Test has many helpers, like install(), uninstall(), sql(), and sqlFile().
     *
     * @link https://github.com/civicrm/org.civicrm.testapalooza/blob/master/civi-test.md
     *
     * @return CiviEnvBuilder
     *
     * @throws CRM_Extension_Exception_ParseException
     */
    public function setUpHeadless(): CiviEnvBuilder
    {
        return Test::headless()
            ->install('rc-base')
            ->installMe(__DIR__)
            ->apply();
    }

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
            CRM_Mailchimptemplate_Settings::ELFIELDNAME => $apikey
        ];
        $form->setVar('_submitValues', $submitValues);
        $this->assertEmpty($form->postProcess());

        $savedApiKey = CRM_Mailchimptemplate_Settings::getApikey();
        $this->assertEquals($apikey, $savedApiKey, 'Form saved API key is wrong.');
    }
}
