<?php

namespace RMT\TimeScheduling\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'day_interval' table.
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
class DayIntervalTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.RMT.TimeScheduling.Model.map.DayIntervalTableMap';

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
        $this->setName('day_interval');
        $this->setPhpName('DayInterval');
        $this->setClassname('RMT\\TimeScheduling\\Model\\DayInterval');
        $this->setPackage('src.RMT.TimeScheduling.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'fos_user', 'ID', true, null, null);
        $this->addForeignKey('DAY_ID', 'DayId', 'INTEGER', 'day', 'ID', false, null, null);
        $this->addColumn('START_HOUR', 'StartHour', 'TIME', false, null, null);
        $this->addColumn('END_HOUR', 'EndHour', 'TIME', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', 'FOS\\UserBundle\\Propel\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
        $this->addRelation('Day', 'RMT\\TimeScheduling\\Model\\Day', RelationMap::MANY_TO_ONE, array('day_id' => 'id', ), null, null);
    } // buildRelations()

} // DayIntervalTableMap
