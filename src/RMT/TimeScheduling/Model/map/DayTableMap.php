<?php

namespace RMT\TimeScheduling\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'day' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.RMT.TimeScheduling.Model.map
 */
class DayTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.RMT.TimeScheduling.Model.map.DayTableMap';

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
        $this->setName('day');
        $this->setPhpName('Day');
        $this->setClassname('RMT\\TimeScheduling\\Model\\Day');
        $this->setPackage('src.RMT.TimeScheduling.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('value', 'Value', 'VARCHAR', false, 255, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Reservation', 'RMT\\TimeScheduling\\Model\\Reservation', RelationMap::ONE_TO_MANY, array('id' => 'day_id', ), null, null, 'Reservations');
        $this->addRelation('DayInterval', 'RMT\\TimeScheduling\\Model\\DayInterval', RelationMap::ONE_TO_MANY, array('id' => 'day_id', ), null, null, 'DayIntervals');
    } // buildRelations()

} // DayTableMap
