<?php

namespace RMT\TimeScheduling\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelDateTime;
use \PropelException;
use \PropelPDO;
use FOS\UserBundle\Propel\User;
use FOS\UserBundle\Propel\UserQuery;
use RMT\TimeScheduling\Model\Day;
use RMT\TimeScheduling\Model\DayQuery;
use RMT\TimeScheduling\Model\Reservation;
use RMT\TimeScheduling\Model\ReservationPeer;
use RMT\TimeScheduling\Model\ReservationQuery;

abstract class BaseReservation extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'RMT\\TimeScheduling\\Model\\ReservationPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ReservationPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the reservee_user_id field.
     * @var        int
     */
    protected $reservee_user_id;

    /**
     * The value for the reserver_user_id field.
     * @var        int
     */
    protected $reserver_user_id;

    /**
     * The value for the day_id field.
     * @var        int
     */
    protected $day_id;

    /**
     * The value for the start_time field.
     * @var        string
     */
    protected $start_time;

    /**
     * The value for the end_time field.
     * @var        string
     */
    protected $end_time;

    /**
     * @var        User
     */
    protected $aUserRelatedByReserveeUserId;

    /**
     * @var        User
     */
    protected $aUserRelatedByReserverUserId;

    /**
     * @var        Day
     */
    protected $aDay;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [reservee_user_id] column value.
     *
     * @return int
     */
    public function getReserveeUserId()
    {
        return $this->reservee_user_id;
    }

    /**
     * Get the [reserver_user_id] column value.
     *
     * @return int
     */
    public function getReserverUserId()
    {
        return $this->reserver_user_id;
    }

    /**
     * Get the [day_id] column value.
     *
     * @return int
     */
    public function getDayId()
    {
        return $this->day_id;
    }

    /**
     * Get the [optionally formatted] temporal [start_time] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getStartTime($format = null)
    {
        if ($this->start_time === null) {
            return null;
        }


        try {
            $dt = new DateTime($this->start_time);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->start_time, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [end_time] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getEndTime($format = null)
    {
        if ($this->end_time === null) {
            return null;
        }


        try {
            $dt = new DateTime($this->end_time);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->end_time, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return Reservation The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = ReservationPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [reservee_user_id] column.
     *
     * @param int $v new value
     * @return Reservation The current object (for fluent API support)
     */
    public function setReserveeUserId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->reservee_user_id !== $v) {
            $this->reservee_user_id = $v;
            $this->modifiedColumns[] = ReservationPeer::RESERVEE_USER_ID;
        }

        if ($this->aUserRelatedByReserveeUserId !== null && $this->aUserRelatedByReserveeUserId->getId() !== $v) {
            $this->aUserRelatedByReserveeUserId = null;
        }


        return $this;
    } // setReserveeUserId()

    /**
     * Set the value of [reserver_user_id] column.
     *
     * @param int $v new value
     * @return Reservation The current object (for fluent API support)
     */
    public function setReserverUserId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->reserver_user_id !== $v) {
            $this->reserver_user_id = $v;
            $this->modifiedColumns[] = ReservationPeer::RESERVER_USER_ID;
        }

        if ($this->aUserRelatedByReserverUserId !== null && $this->aUserRelatedByReserverUserId->getId() !== $v) {
            $this->aUserRelatedByReserverUserId = null;
        }


        return $this;
    } // setReserverUserId()

    /**
     * Set the value of [day_id] column.
     *
     * @param int $v new value
     * @return Reservation The current object (for fluent API support)
     */
    public function setDayId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->day_id !== $v) {
            $this->day_id = $v;
            $this->modifiedColumns[] = ReservationPeer::DAY_ID;
        }

        if ($this->aDay !== null && $this->aDay->getId() !== $v) {
            $this->aDay = null;
        }


        return $this;
    } // setDayId()

    /**
     * Sets the value of [start_time] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Reservation The current object (for fluent API support)
     */
    public function setStartTime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->start_time !== null || $dt !== null) {
            $currentDateAsString = ($this->start_time !== null && $tmpDt = new DateTime($this->start_time)) ? $tmpDt->format('H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->start_time = $newDateAsString;
                $this->modifiedColumns[] = ReservationPeer::START_TIME;
            }
        } // if either are not null


        return $this;
    } // setStartTime()

    /**
     * Sets the value of [end_time] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Reservation The current object (for fluent API support)
     */
    public function setEndTime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->end_time !== null || $dt !== null) {
            $currentDateAsString = ($this->end_time !== null && $tmpDt = new DateTime($this->end_time)) ? $tmpDt->format('H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->end_time = $newDateAsString;
                $this->modifiedColumns[] = ReservationPeer::END_TIME;
            }
        } // if either are not null


        return $this;
    } // setEndTime()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->reservee_user_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->reserver_user_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->day_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->start_time = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->end_time = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 6; // 6 = ReservationPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Reservation object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

        if ($this->aUserRelatedByReserveeUserId !== null && $this->reservee_user_id !== $this->aUserRelatedByReserveeUserId->getId()) {
            $this->aUserRelatedByReserveeUserId = null;
        }
        if ($this->aUserRelatedByReserverUserId !== null && $this->reserver_user_id !== $this->aUserRelatedByReserverUserId->getId()) {
            $this->aUserRelatedByReserverUserId = null;
        }
        if ($this->aDay !== null && $this->day_id !== $this->aDay->getId()) {
            $this->aDay = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ReservationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ReservationPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUserRelatedByReserveeUserId = null;
            $this->aUserRelatedByReserverUserId = null;
            $this->aDay = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ReservationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ReservationQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ReservationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ReservationPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUserRelatedByReserveeUserId !== null) {
                if ($this->aUserRelatedByReserveeUserId->isModified() || $this->aUserRelatedByReserveeUserId->isNew()) {
                    $affectedRows += $this->aUserRelatedByReserveeUserId->save($con);
                }
                $this->setUserRelatedByReserveeUserId($this->aUserRelatedByReserveeUserId);
            }

            if ($this->aUserRelatedByReserverUserId !== null) {
                if ($this->aUserRelatedByReserverUserId->isModified() || $this->aUserRelatedByReserverUserId->isNew()) {
                    $affectedRows += $this->aUserRelatedByReserverUserId->save($con);
                }
                $this->setUserRelatedByReserverUserId($this->aUserRelatedByReserverUserId);
            }

            if ($this->aDay !== null) {
                if ($this->aDay->isModified() || $this->aDay->isNew()) {
                    $affectedRows += $this->aDay->save($con);
                }
                $this->setDay($this->aDay);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = ReservationPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ReservationPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ReservationPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(ReservationPeer::RESERVEE_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`reservee_user_id`';
        }
        if ($this->isColumnModified(ReservationPeer::RESERVER_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`reserver_user_id`';
        }
        if ($this->isColumnModified(ReservationPeer::DAY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`day_id`';
        }
        if ($this->isColumnModified(ReservationPeer::START_TIME)) {
            $modifiedColumns[':p' . $index++]  = '`start_time`';
        }
        if ($this->isColumnModified(ReservationPeer::END_TIME)) {
            $modifiedColumns[':p' . $index++]  = '`end_time`';
        }

        $sql = sprintf(
            'INSERT INTO `reservation` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`reservee_user_id`':
                        $stmt->bindValue($identifier, $this->reservee_user_id, PDO::PARAM_INT);
                        break;
                    case '`reserver_user_id`':
                        $stmt->bindValue($identifier, $this->reserver_user_id, PDO::PARAM_INT);
                        break;
                    case '`day_id`':
                        $stmt->bindValue($identifier, $this->day_id, PDO::PARAM_INT);
                        break;
                    case '`start_time`':
                        $stmt->bindValue($identifier, $this->start_time, PDO::PARAM_STR);
                        break;
                    case '`end_time`':
                        $stmt->bindValue($identifier, $this->end_time, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUserRelatedByReserveeUserId !== null) {
                if (!$this->aUserRelatedByReserveeUserId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aUserRelatedByReserveeUserId->getValidationFailures());
                }
            }

            if ($this->aUserRelatedByReserverUserId !== null) {
                if (!$this->aUserRelatedByReserverUserId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aUserRelatedByReserverUserId->getValidationFailures());
                }
            }

            if ($this->aDay !== null) {
                if (!$this->aDay->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aDay->getValidationFailures());
                }
            }


            if (($retval = ReservationPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }



            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ReservationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getReserveeUserId();
                break;
            case 2:
                return $this->getReserverUserId();
                break;
            case 3:
                return $this->getDayId();
                break;
            case 4:
                return $this->getStartTime();
                break;
            case 5:
                return $this->getEndTime();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Reservation'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Reservation'][$this->getPrimaryKey()] = true;
        $keys = ReservationPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getReserveeUserId(),
            $keys[2] => $this->getReserverUserId(),
            $keys[3] => $this->getDayId(),
            $keys[4] => $this->getStartTime(),
            $keys[5] => $this->getEndTime(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aUserRelatedByReserveeUserId) {
                $result['UserRelatedByReserveeUserId'] = $this->aUserRelatedByReserveeUserId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUserRelatedByReserverUserId) {
                $result['UserRelatedByReserverUserId'] = $this->aUserRelatedByReserverUserId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aDay) {
                $result['Day'] = $this->aDay->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ReservationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setReserveeUserId($value);
                break;
            case 2:
                $this->setReserverUserId($value);
                break;
            case 3:
                $this->setDayId($value);
                break;
            case 4:
                $this->setStartTime($value);
                break;
            case 5:
                $this->setEndTime($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = ReservationPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setReserveeUserId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setReserverUserId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDayId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setStartTime($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setEndTime($arr[$keys[5]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ReservationPeer::DATABASE_NAME);

        if ($this->isColumnModified(ReservationPeer::ID)) $criteria->add(ReservationPeer::ID, $this->id);
        if ($this->isColumnModified(ReservationPeer::RESERVEE_USER_ID)) $criteria->add(ReservationPeer::RESERVEE_USER_ID, $this->reservee_user_id);
        if ($this->isColumnModified(ReservationPeer::RESERVER_USER_ID)) $criteria->add(ReservationPeer::RESERVER_USER_ID, $this->reserver_user_id);
        if ($this->isColumnModified(ReservationPeer::DAY_ID)) $criteria->add(ReservationPeer::DAY_ID, $this->day_id);
        if ($this->isColumnModified(ReservationPeer::START_TIME)) $criteria->add(ReservationPeer::START_TIME, $this->start_time);
        if ($this->isColumnModified(ReservationPeer::END_TIME)) $criteria->add(ReservationPeer::END_TIME, $this->end_time);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(ReservationPeer::DATABASE_NAME);
        $criteria->add(ReservationPeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Reservation (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setReserveeUserId($this->getReserveeUserId());
        $copyObj->setReserverUserId($this->getReserverUserId());
        $copyObj->setDayId($this->getDayId());
        $copyObj->setStartTime($this->getStartTime());
        $copyObj->setEndTime($this->getEndTime());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Reservation Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return ReservationPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ReservationPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param             User $v
     * @return Reservation The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUserRelatedByReserveeUserId(User $v = null)
    {
        if ($v === null) {
            $this->setReserveeUserId(NULL);
        } else {
            $this->setReserveeUserId($v->getId());
        }

        $this->aUserRelatedByReserveeUserId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the User object, it will not be re-added.
        if ($v !== null) {
            $v->addReservationRelatedByReserveeUserId($this);
        }


        return $this;
    }


    /**
     * Get the associated User object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return User The associated User object.
     * @throws PropelException
     */
    public function getUserRelatedByReserveeUserId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aUserRelatedByReserveeUserId === null && ($this->reservee_user_id !== null) && $doQuery) {
            $this->aUserRelatedByReserveeUserId = UserQuery::create()->findPk($this->reservee_user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserRelatedByReserveeUserId->addReservationsRelatedByReserveeUserId($this);
             */
        }

        return $this->aUserRelatedByReserveeUserId;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param             User $v
     * @return Reservation The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUserRelatedByReserverUserId(User $v = null)
    {
        if ($v === null) {
            $this->setReserverUserId(NULL);
        } else {
            $this->setReserverUserId($v->getId());
        }

        $this->aUserRelatedByReserverUserId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the User object, it will not be re-added.
        if ($v !== null) {
            $v->addReservationRelatedByReserverUserId($this);
        }


        return $this;
    }


    /**
     * Get the associated User object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return User The associated User object.
     * @throws PropelException
     */
    public function getUserRelatedByReserverUserId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aUserRelatedByReserverUserId === null && ($this->reserver_user_id !== null) && $doQuery) {
            $this->aUserRelatedByReserverUserId = UserQuery::create()->findPk($this->reserver_user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserRelatedByReserverUserId->addReservationsRelatedByReserverUserId($this);
             */
        }

        return $this->aUserRelatedByReserverUserId;
    }

    /**
     * Declares an association between this object and a Day object.
     *
     * @param             Day $v
     * @return Reservation The current object (for fluent API support)
     * @throws PropelException
     */
    public function setDay(Day $v = null)
    {
        if ($v === null) {
            $this->setDayId(NULL);
        } else {
            $this->setDayId($v->getId());
        }

        $this->aDay = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Day object, it will not be re-added.
        if ($v !== null) {
            $v->addReservation($this);
        }


        return $this;
    }


    /**
     * Get the associated Day object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Day The associated Day object.
     * @throws PropelException
     */
    public function getDay(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aDay === null && ($this->day_id !== null) && $doQuery) {
            $this->aDay = DayQuery::create()->findPk($this->day_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aDay->addReservations($this);
             */
        }

        return $this->aDay;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->reservee_user_id = null;
        $this->reserver_user_id = null;
        $this->day_id = null;
        $this->start_time = null;
        $this->end_time = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->aUserRelatedByReserveeUserId instanceof Persistent) {
              $this->aUserRelatedByReserveeUserId->clearAllReferences($deep);
            }
            if ($this->aUserRelatedByReserverUserId instanceof Persistent) {
              $this->aUserRelatedByReserverUserId->clearAllReferences($deep);
            }
            if ($this->aDay instanceof Persistent) {
              $this->aDay->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aUserRelatedByReserveeUserId = null;
        $this->aUserRelatedByReserverUserId = null;
        $this->aDay = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ReservationPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
