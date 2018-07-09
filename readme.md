Gloo Single Sign-On
===================

## Description
This is a single sign-on (SSO) extension based on OAuth2 that provides the ability to log into magento using data from IdPs

## Installation
To install, you can add the repository url to your composer.json file.
Then run `composer require gloo/module-sso`

## Releases Notes

### v0.1.0
 - Authentication of Customers based on Customer Object passed to the Authentication Method now possible.
 - Account linking now handled by the Social Identity provider by passing data in the custom attribute property of Magento Customer Data Repository.

### v0.1.1
 - Fixed a bug where context object was not properly injected
 - Removed install schema as it is no longer required

### v0.1.2
 - Added ACL
 - Fixed issue related to private data not refreshed when login is not a POST request

### v0.2.1
 - Compatible with Magento 2.2.x branch
## Copyright

(c) 2017 Gloo
