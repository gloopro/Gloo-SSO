<?php

    namespace Gloo\SSO\Controller\Index;

    use Magento\Framework\App\Action\Context;

    class Index extends \Gloo\SSO\Controller\Index {

        public function __construct(Context $context)
        {
            return parent::__construct($context);
        }

        public function execute()
        {
            die("Hello World");
        }
    }