# htaccess_checker_drupal_7

## Goal
Tricky rewrite rules require tricky testing. Setting up vhosts across all your test domains and manually checking combinations of URLs is a daunting task. In an effort to automate this, I've created this poorly named module to automatically test URL combinations and report on whether your redirects are behaving the way you want them to.

For sites that have large amounts of rewrite rules in place and large numbers of sensitive rewrite testing, this module can help. This will also help if you are operating a multilingual site and want to test your rewrites against multiple domains, multiple language prefixes and language codes.
