<?php

namespace RMT\TimeScheduling\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use RMT\TimeScheduling\Model\Day;
use RMT\TimeScheduling\Model\DayInterval;
use RMT\TimeScheduling\Model\DayIntervalPeer;
use RMT\TimeScheduling\Model\DayIntervalQuery;

/**
 * @method DayIntervalQuery orderById($order = Criteria::ASC) Order by the id column
 * @method DayIntervalQuery orderByDayId($order = Criteria::ASC) Order by the day_id column
 * @method DayIntervalQuery orderByStartHour($order = Criteria::ASC) Order by the start_hour column
 * @method DayIntervalQuery orderByEndHour($order = Criteria::ASC) Order by the end_hour column
 *
 * @method DayIntervalQuery groupById() Group by the id column
 * @method DayIntervalQuery groupByDayId() Group by the day_id column
 * @method DayIntervalQuery groupByStartHour() Group by the start_hour column
 * @method DayIntervalQuery groupByEndHour() Group by the end_hour column
 *
 * @method DayIntervalQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method DayIntervalQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method DayIntervalQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method DayIntervalQuery leftJoinDay($relationAlias = null) Adds a LEFT JOIN clause to the query using the Day relation
 * @method DayIntervalQuery rightJoinDay($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Day relation
 * @method DayIntervalQuery innerJoinDay($relationAlias = null) Adds a INNER JOIN clause to the query using the Day relation
 *
 * @method DayInterval findOne(PropelPDO $con = null) Return the first DayInterval matching the query
 * @method DayInterval findOneOrCreate(PropelPDO $con = null) Return the first DayInterval matching the query, or a new DayInterval object populated from the query conditions when no match is found
 *
 * @method DayInterval findOneById(int $id) Return the first DayInterval filtered by the id column
 * @method DayInterval findOneByDayId(int $day_id) Return the first DayInterval filtered by the day_id column
 * @method DayInterval findOneByStartHour(string $start_hour) Return the first DayInterval filtered by the start_hour column
 * @method DayInterval findOneByEndHour(string $end_hour) Return the first DayInterval filtered by the end_hour column
 *
 * @method array findById(int $id) Return DayInterval objects filtered by the id column
 * @method array findByDayId(int $day_id) Return DayInterval objects filtered by the day_id column
 * @method array findByStartHour(string $start_hour) Return DayInterval objects filtered by the start_hour column
 * @method array findByEndHour(string $end_hour) Return DayInterval objects filtered by the end_hour column
 */
abstract class BaseDayIntervalQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseDayIntervalQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'RMT\\TimeScheduling\\Model\\DayInterval', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new DayIntervalQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     DayIntervalQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return DayIntervalQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof DayIntervalQuery) {
            return $criteria;
        }
        $query = new DayIntervalQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   DayInterval|DayInterval[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DayIntervalPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(DayIntervalPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return   DayInterval A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ID`, `DAY_ID`, `START_HOUR`, `END_HOUR` FROM `day_interval` WHERE `ID` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new DayInterval();
            $obj->hydrate($row);
            DayIntervalPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return DayInterval|DayInterval[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|DayInterval[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return DayIntervalQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DayIntervalPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return DayIntervalQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DayIntervalPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DayIntervalQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(DayIntervalPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the day_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDayId(1234); // WHERE day_id = 1234
     * $query->filterByDayId(array(12, 34)); // WHERE day_id IN (12, 34)
     * $query->filterByDayId(array('min' => 12)); // WHERE day_id > 12
     * </code>
     *
     * @see       filterByDay()
     *
     * @param     mixed $dayId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DayIntervalQuery The current query, for fluid interface
     */
    public function filterByDayId($dayId = null, $comparison = null)
    {
        if (is_array($dayId)) {
            $useMinMax = false;
            if (isset($dayId['min'])) {
                $this->addUsingAlias(DayIntervalPeer::DAY_ID, $dayId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dayId['max'])) {
                $this->addUsingAlias(DayIntervalPeer::DAY_ID, $dayId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DayIntervalPeer::DAY_ID, $dayId, $comparison);
    }

    /**
     * Filter the query on the start_hour column
     *
     * Example usage:
     * <code>
     * $query->filterByStartHour('2011-03-14'); // WHERE start_hour = '2011-03-14'
     * $query->filterByStartHour('now'); // WHERE start_hour = '2011-03-14'
     * $query->filterByStartHour(array('max' => 'yesterday')); // WHERE start_hour > '2011-03-13'
     * </code>
     *
     * @param     mixed $startHour The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DayIntervalQuery The current query, for fluid interface
     */
    public function filterByStartHour($startHour = null, $comparison = null)
    {
        if (is_array($startHour)) {
            $useMinMax = false;
            if (isset($startHour['min'])) {
                $this->addUsingAlias(DayIntervalPeer::START_HOUR, $startHour['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startHour['max'])) {
                $this->addUsingAlias(DayIntervalPeer::START_HOUR, $startHour['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DayIntervalPeer::START_HOUR, $startHour, $comparison);
    }

    /**
     * Filter the query on the end_hour column
     *
     * Example usage:
     * <code>
     * $query->filterByEndHour('2011-03-14'); // WHERE end_hour = '2011-03-14'
     * $query->filterByEndHour('now'); // WHERE end_hour = '2011-03-14'
     * $query->filterByEndHour(array('max' => 'yesterday')); // WHERE end_hour > '2011-03-13'
     * </code>
     *
     * @param     mixed $endHour The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DayIntervalQuery The current query, for fluid interface
     */
    public function filterByEndHour($endHour = null, $comparison = null)
    {
        if (is_array($endHour)) {
            $useMinMax = false;
            if (isset($endHour['min'])) {
                $this->addUsingAlias(DayIntervalPeer::END_HOUR, $endHour['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($endHour['max'])) {
                $this->addUsingAlias(DayIntervalPeer::END_HOUR, $endHour['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DayIntervalPeer::END_HOUR, $endHour, $comparison);
    }

    /**
     * Filter the query by a related Day object
     *
     * @param   Day|PropelObjectCollection $day The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   DayIntervalQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByDay($day, $comparison = null)
    {
        if ($day instanceof Day) {
            return $this
                ->addUsingAlias(DayIntervalPeer::DAY_ID, $day->getId(), $comparison);
        } elseif ($day instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DayIntervalPeer::DAY_ID, $day->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByDay() only accepts arguments of type Day or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Day relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return DayIntervalQuery The current query, for fluid interface
     */
    public function joinDay($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Day');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Day');
        }

        return $this;
    }

    /**
     * Use the Day relation Day object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \RMT\TimeScheduling\Model\DayQuery A secondary query class using the current class as primary query
     */
    public function useDayQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDay($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Day', '\RMT\TimeScheduling\Model\DayQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   DayInterval $dayInterval Object to remove from the list of results
     *
     * @return DayIntervalQuery The current query, for fluid interface
     */
    public function prune($dayInterval = null)
    {
        if ($dayInterval) {
            $this->addUsingAlias(DayIntervalPeer::ID, $dayInterval->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
