<?php

namespace RMT\TimeScheduling\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'reservation' table.
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
class ReservationTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.RMT.TimeScheduling.Model.map.ReservationTableMap';

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
        $this->setName('reservation');
        $this->setPhpName('Reservation');
        $this->setClassname('RMT\\TimeScheduling\\Model\\Reservation');
        $this->setPackage('src.RMT.TimeScheduling.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('reservee_user_id', 'ReserveeUserId', 'INTEGER', 'fos_user', 'id', true, null, null);
        $this->addForeignKey('reserver_user_id', 'ReserverUserId', 'INTEGER', 'fos_user', 'id', true, null, null);
        $this->addForeignKey('day_id', 'DayId', 'INTEGER', 'day', 'id', false, null, null);
        $this->addColumn('start_time', 'StartTime', 'TIME', false, null, null);
        $this->addColumn('end_time', 'EndTime', 'TIME', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Reservee', 'FOS\\UserBundle\\Propel\\User', RelationMap::MANY_TO_ONE, array('reservee_user_id' => 'id', ), null, null);
        $this->addRelation('Reserver', 'FOS\\UserBundle\\Propel\\User', RelationMap::MANY_TO_ONE, array('reserver_user_id' => 'id', ), null, null);
        $this->addRelation('Day', 'RMT\\TimeScheduling\\Model\\Day', RelationMap::MANY_TO_ONE, array('day_id' => 'id', ), null, null);
    } // buildRelations()

} // ReservationTableMap
