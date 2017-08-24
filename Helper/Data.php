<?php
  namespace Gloo\SSO\Helper;

  use Magento\Framework\App\Helper\AbstractHelper;

  class Data extends AbstractHelper
  {
      public static $ACTIVATE_CONFIG = "active";
      public static $APP_ID = "app_id";
      public static $APP_SECRET = "app_secret";
      public static $CLIENT_TOKEN = "client_token";
      public static $SCOPE = "scope";
      public static $REDIRECT_URI = "redirect_uri";

      /* @param \Magento\Framework\App\Helper\Context $context
       */
      public function __construct(Context $context)
      {
          parent::__construct($context);
      }

      public function getConfig($config_path)
      {
          return $this->scopeConfig->getValue(
              "gloo_sso_config/general/{$config_path}",
              \Magento\Store\Model\ScopeInterface::SCOPE_STORE
          );
      }
  }