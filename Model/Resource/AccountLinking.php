<?php

    namespace Gloo\SSO\Model\Resource;

    use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

    class AccountLinking extends AbstractDb  {

        public function _construct()
        {
            $this->_init("gloo_sso_accountlinking", 'id');
        }

    }