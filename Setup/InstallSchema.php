<?php

    namespace Gloo\SSO\Setup;

    use Magento\Framework\Setup\InstallSchemaInterface;
    use Magento\Framework\Setup\SchemaSetupInterface;
    use Magento\Framework\Setup\ModuleContextInterface;

    class InstallSchema implements InstallSchemaInterface  {

        public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
        {
            $installer = $setup;
            $installer->startSetup();
            $table = $installer->getConnection()->newTable(
                $installer->getTable("gloo_sso_accountlinking")
            )->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id'
            )->addColumn(
                'email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [],
                'User Email'
            )->addColumn(
                'serviceProvider',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [],
                'Oauth Service Provider'
            )->addColumn(
                'payload',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [],
                'Payload'
            );

            //END
            $setup->getConnection()->createTable($table);
            $installer->endSetup();

        }

    }