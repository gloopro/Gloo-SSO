Gloo Single Sign-On
===================

## Description
This is a single sign-on (SSO) extension based on OAuth2 that provides the ability to log into magento using data from IdPs

## Installation
To install, you can add the repository url to your composer.json file.
Then run `composer require gloo/module-sso`

## Releases Notes

### v1.0.0
 - Authentication of Customers based on Customer Object passed to the Authentication Method now possible.
 - Account linking now handled by the Social Identity provider by passing data in the custom attribute property of Magento Customer Data Repository.

### v1.0.1
 - Fixed a bug where context object was not properly injected
 - Removed install schema as it is no longer required
## Copyright

(c) 2017 Gloo
