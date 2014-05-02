<?php

namespace lbarulski\GateKeeperPropelBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'gatekeeper' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.lbarulski.GateKeeperPropelBundle.Model.map
 */
class GateKeeperTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.lbarulski.GateKeeperPropelBundle.Model.map.GateKeeperTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('gatekeeper');
        $this->setPhpName('GateKeeper');
        $this->setClassname('lbarulski\\GateKeeperPropelBundle\\Model\\GateKeeper');
        $this->setPackage('src.lbarulski.GateKeeperPropelBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('gate', 'Gate', 'VARCHAR', true, 255, null);
        $this->addColumn('access', 'Access', 'VARCHAR', true, 255, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' =>  array (
  'create_column' => 'created_at',
  'update_column' => 'updated_at',
  'disable_updated_at' => 'false',
),
        );
    } // getBehaviors()

} // GateKeeperTableMap
