<?php

    namespace Gloo\SSO\Model\Resource\AccountLinking;

    use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

    class Collection extends AbstractCollection  {

        public function _construct()
        {
            $this->_init('Gloo/SSO/Model/AccountLinking', 'Gloo/SSO/Model/Resource/AccountLinking');
        }

    }