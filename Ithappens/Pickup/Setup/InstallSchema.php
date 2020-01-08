<?php
/*
 * @package     Ithappens_Pickup
 * @copyright   Copyright (c) 2016 Gamuza Technologies (http://www.gamuza.com.br/)
 * @author      Eneias Ramos de Melo <eneias@gamuza.com.br>
 */

namespace Ithappens\Pickup\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
 
class InstallSchema implements InstallSchemaInterface
{

public function install (SchemaSetupInterface $setup, ModuleContextInterface $context)
{
    $installer = $setup;

    $installer->startSetup ();

    /*
     * Ithappens Pickup Stores
     */
    $table = $installer->getConnection ()
        ->newTable ($installer->getTable ('ithappens_pickup_stores'))
        ->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Entity ID'
        )
        ->addColumn(
            'id_loja',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'ID Loja'
        )
        ->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            [],
            'Name'
        )
        ->addColumn(
            'address',
            Table::TYPE_TEXT,
            255,
            [],
            'Address'
        )
        ->addColumn(
            'number',
            Table::TYPE_TEXT,
            255,
            [],
            'Number'
        )
        ->addColumn(
            'complement',
            Table::TYPE_TEXT,
            255,
            [],
            'Complement'
        )
        ->addColumn(
            'zipcode',
            Table::TYPE_TEXT,
            255,
            [],
            'Zipcode'
        )
        ->addColumn(
            'city',
            Table::TYPE_TEXT,
            255,
            [],
            'City'
        )
        ->addColumn(
            'state',
            Table::TYPE_TEXT,
            255,
            [],
            'State'
        )
        ->addColumn(
            'opening',
            Table::TYPE_TEXT,
            255,
            [],
            'Opening'
        )
        ->addColumn(
            'begin_zipcode',
            Table::TYPE_TEXT,
            255,
            [],
            'Begin Zipcode'
        )
        ->addColumn(
            'end_zipcode',
            Table::TYPE_TEXT,
            255,
            [],
            'End Zipcode'
        )
        ->addColumn(
            'observations',
            Table::TYPE_TEXT,
            255,
            [],
            'Observations'
        )
        ->addColumn(
            'delivered_cdg',
            Table::TYPE_BOOLEAN,
            null,
            [],
            'Delivered by CDG'
        )
        ->addColumn(
            'is_active',
            Table::TYPE_BOOLEAN,
            null,
            [],
            'Is Active'
        )
        ->addIndex(
            $installer->getIdxName('ithappens_pickup_stores', ['id_loja']), ['id_loja'], AdapterInterface::INDEX_TYPE_UNIQUE
        )
        ->setComment(
            'Ithappens Pickup Stores'
        );
    $installer->getConnection()
        ->createTable($table);

    /*
     * Ithappens Pickup Items
     */
    $table = $installer->getConnection ()
        ->newTable ($installer->getTable ('ithappens_pickup_items'))
        ->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Entity ID'
        )
        ->addColumn(
            'store_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Store ID'
        )
        ->addColumn(
            'id_loja',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'ID Loja'
        )
        ->addColumn(
            'departure_date',
            Table::TYPE_TEXT,
            255,
            [],
            'Departure Date'
        )
        ->addColumn(
            'arrival_date',
            Table::TYPE_TEXT,
            255,
            [],
            'Arrival Date'
        )
        ->addColumn(
            'operation_time',
            Table::TYPE_INTEGER,
            null,
            ['unsigend' => true, 'nullable' => false],
            'Operation Time'
        )
        ->addIndex(
            $installer->getIdxName('ithappens_pickup_items', ['id_loja']), ['id_loja'], AdapterInterface::INDEX_TYPE_UNIQUE
        )
        ->addForeignKey(
            $installer->getFkName(
                'ithappens_pickup_stores_items',
                'id_loja',
                $installer->getTable ('ithappens_pickup_stores'),
                'id_loja'
            ),
           'id_loja', $installer->getTable ('ithappens_pickup_stores'), 'id_loja',
            Table::ACTION_RESTRICT
        )
        ->setComment(
            'Ithappens Pickup Items'
        );
    $installer->getConnection()
        ->createTable($table);

    $installer->endSetup();

    /*
     * Sales Order
     */
    $result = $installer->getConnection()
        ->addColumn(
            $installer->getTable('sales_order'),
            'ithappens_pickup',
            array(
                'type' => Table::TYPE_TEXT,
                'comment' => 'Ithappens Pickup'
            )
        );
}

}

