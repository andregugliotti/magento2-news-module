<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Psr\Log\LoggerInterface;

/**
 * Class UpgradeSchema
 *
 * Gugliotti News SQL Upgrade Script.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * UpgradeSchema constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        // updates between 0.1.0 and 0.2.0
        if (version_compare($context->getVersion(), '0.2.0', '<')) {
            $this->logger->info('Gugliotti_News: updating to the version 0.2.0');
            $this->addIndexesToEntities($setup);
        }

        $setup->endSetup();
    }

    /**
     * addIndexesToEntities
     * @param SchemaSetupInterface $setup
     * @return $this
     */
    protected function addIndexesToEntities(SchemaSetupInterface $setup)
    {
        try {
            // adds category index to be used on fulltext search
            $setup->getConnection()->addIndex(
                $setup->getTable('gugliotti_news_category'),
                $setup->getConnection()->getIndexName(
                    $setup->getTable('gugliotti_news_category'),
                    ['code', 'label'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['code', 'label'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );

            // adds story index to be used on fulltext search
            $setup->getConnection()->addIndex(
                $setup->getTable('gugliotti_news_story'),
                $setup->getConnection()->getIndexName(
                    $setup->getTable('gugliotti_news_story'),
                    ['title', 'content'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['title', 'content'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        } catch (\Exception $e) {
            $this->logger->critical($e);
        }
        return $this;
    }
}
