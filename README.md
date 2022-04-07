# hu.co.farm.mailchimptemplate

[![CI](https://github.com/reflexive-communications/hu.co.farm.mailchimptemplate/actions/workflows/main.yml/badge.svg)](https://github.com/reflexive-communications/hu.co.farm.mailchimptemplate/actions/workflows/main.yml)

This extension imports mail templates from Mailchimp.

## Requirements

* PHP v7.3+
* CiviCRM (5.47) might work below - not tested

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/reflexive-communications/hu.co.farm.mailchimptemplate.git
cv en hu.co.farm.mailchimptemplate
```

## Usage

Currently Mailchimp API key is hard-coded. You need to set it in `CRM_Mailchimptemplate_Form_MailchimpTemplate::contruct()`.
Then navigate to **Mailings >> Mailchimp Campaign Import** where you can select & import a mailing.
