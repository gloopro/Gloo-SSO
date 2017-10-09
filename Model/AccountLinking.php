<?php

    namespace Gloo\SSO\Model;

    use Magento\Framework\Model\AbstractModel;

    class AccountLinking extends AbstractModel {

        public function _construct()
        {
            $this->_init('Gloo\SSO\Model\Resource\AccountLinking');
        }
        
        
        
    }