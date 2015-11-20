# htaccess_checker_drupal_7

## Goal
Tricky rewrite rules require tricky testing. Setting up vhosts across all your test domains and manually checking combinations of URLs is a daunting task. In an effort to automate this, I've created this poorly named module to automatically test URL combinations and report on whether your redirects are behaving the way you want them to.

For sites that have large amounts of rewrite rules in place and large numbers of sensitive rewrite testing, this module can help. This will also help if you are operating a multilingual site and want to test your rewrites against multiple domains, multiple language prefixes and language codes.

### Features
- Localhost testing for any domain you manage
- SSL support
- Multilingual support
- CSV upload support

## Assumptions
- Must have all ServerAliases assigned to the appropriate VirtualHost settings.

## Installation
Download this module to your modules directory. Enable the module and go to /admin/config/search/htaccess_check in your Drupal site.

## Settings for Multilingual
### Language Domains
If you have registered TLDs pointing to your site but aren't registering them in Drupal's language settings (/admin/config/regional/language), you can target these TLDs in your redirects on the Settings page of this module. This will simply be used for string replacements for {lang-domain} of your enabled languages.

For example, if you have example.com and example.nl pointing to your site, and say you want to redirect all prefixes to their corresponding TLD, i.e., example.com/nl to example.nl, you can set the Source to example.com/{lang-prefix} and the Target to example.{lang-domain}. This will loop through your Language Domain settings and replace {lang-domain} with the assigned value.
