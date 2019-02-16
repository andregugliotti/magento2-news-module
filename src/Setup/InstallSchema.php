<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Psr\Log\LoggerInterface;

/**
 * Class InstallSchema
 *
 * Gugliotti News SQL Installer.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * InstallSchema constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->_logger = $logger;
    }

    /**
     * install
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        // start the setup process
        $setup->startSetup();

        // prepare the table for entity "category"
        $tableCategory = $setup->getConnection()->newTable($setup->getTable('gugliotti_news_category'));

        // create columns
        try {
            $tableCategory->addColumn(
                'category_id',
                Table::TYPE_INTEGER,
                null,
                array('nullable' => false, 'identity' => true, 'primary' => true),
                'News Category ID'
            )->addColumn(
                'code',
                Table::TYPE_TEXT,
                64,
                array('nullable' => false),
                'News Category Code'
            )->addColumn(
                'label',
                Table::TYPE_TEXT,
                128,
                array('nullable' => false),
                'News Category Label'
            )->addColumn(
                'status',
                Table::TYPE_BOOLEAN,
                null,
                array('nullable' => false, 'default' => 0),
                'News Category Status'
            )->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                array('default' => Table::TIMESTAMP_INIT),
                'News Category Created At'
            )->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                array('default' => Table::TIMESTAMP_INIT_UPDATE),
                'News Category Updated At'
            )->setComment('Gugliotti News Categories');
        } catch (\Exception $e) {
            $this->_logger->critical($e);
        }

        // prepare the table for the entity "story"
        $tableStory = $setup->getConnection()->newTable($setup->getTable('gugliotti_news_story'));

        // create columns
        try {
            $tableStory->addColumn(
                'story_id',
                Table::TYPE_INTEGER,
                null,
                array('nullable' => false, 'identity' => true, 'primary' => true),
                'News Story ID'
            )->addColumn(
                'title',
                Table::TYPE_TEXT,
                128,
                array('nullable' => false),
                'News Story Title'
            )->addColumn(
                'thumbnail_path',
                Table::TYPE_TEXT,
                128,
                array('nullable' => true),
                'News Story Thumbnail Path'
            )->addColumn(
                'content',
                Table::TYPE_TEXT,
                null,
                array('nullable' => false),
                'News Story Content'
            )->addColumn(
                'status',
                Table::TYPE_BOOLEAN,
                null,
                array('nullable' => false, 'default' => 0),
                'News Category Status'
            )->addColumn(
                'category_id',
                Table::TYPE_INTEGER,
                null,
                array('nullable' => true),
                'News Story Category'
            )->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                array('default' => Table::TIMESTAMP_INIT),
                'News Story Created At'
            )->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                array('default' => Table::TIMESTAMP_INIT_UPDATE),
                'News Story Updated At'
            )->addForeignKey(
                $setup->getFkName(
                    'gugliotti_news/story',
                    'category_id',
                    'gugliotti_news/category',
                    'category_id'
                ),
                'category_id',
                $setup->getTable('gugliotti_news_category'),
                'category_id'
            )->setComment('Gugliotti News Stories');
        } catch (\Exception $e) {
            $this->_logger->critical($e);
        }

        // create tables
        try {
            $setup->getConnection()->createTable($tableCategory);
            $setup->getConnection()->createTable($tableStory);
        } catch (\Exception $e) {
            $this->_logger->critical($e);
        }

        // end the setup process
        $setup->endSetup();
    }
}
