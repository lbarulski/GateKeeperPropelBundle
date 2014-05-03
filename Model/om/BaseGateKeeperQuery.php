<?php

namespace GateKeeperPropelBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use GateKeeperPropelBundle\Model\GateKeeper;
use GateKeeperPropelBundle\Model\GateKeeperPeer;
use GateKeeperPropelBundle\Model\GateKeeperQuery;

/**
 * @method GateKeeperQuery orderById($order = Criteria::ASC) Order by the id column
 * @method GateKeeperQuery orderByGate($order = Criteria::ASC) Order by the gate column
 * @method GateKeeperQuery orderByAccess($order = Criteria::ASC) Order by the access column
 * @method GateKeeperQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method GateKeeperQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method GateKeeperQuery groupById() Group by the id column
 * @method GateKeeperQuery groupByGate() Group by the gate column
 * @method GateKeeperQuery groupByAccess() Group by the access column
 * @method GateKeeperQuery groupByCreatedAt() Group by the created_at column
 * @method GateKeeperQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method GateKeeperQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method GateKeeperQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method GateKeeperQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method GateKeeper findOne(PropelPDO $con = null) Return the first GateKeeper matching the query
 * @method GateKeeper findOneOrCreate(PropelPDO $con = null) Return the first GateKeeper matching the query, or a new GateKeeper object populated from the query conditions when no match is found
 *
 * @method GateKeeper findOneByGate(string $gate) Return the first GateKeeper filtered by the gate column
 * @method GateKeeper findOneByAccess(string $access) Return the first GateKeeper filtered by the access column
 * @method GateKeeper findOneByCreatedAt(string $created_at) Return the first GateKeeper filtered by the created_at column
 * @method GateKeeper findOneByUpdatedAt(string $updated_at) Return the first GateKeeper filtered by the updated_at column
 *
 * @method array findById(int $id) Return GateKeeper objects filtered by the id column
 * @method array findByGate(string $gate) Return GateKeeper objects filtered by the gate column
 * @method array findByAccess(string $access) Return GateKeeper objects filtered by the access column
 * @method array findByCreatedAt(string $created_at) Return GateKeeper objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return GateKeeper objects filtered by the updated_at column
 */
abstract class BaseGateKeeperQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseGateKeeperQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'default';
        }
        if (null === $modelName) {
            $modelName = 'GateKeeperPropelBundle\\Model\\GateKeeper';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new GateKeeperQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   GateKeeperQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return GateKeeperQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof GateKeeperQuery) {
            return $criteria;
        }
        $query = new GateKeeperQuery(null, null, $modelAlias);

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
     * @return   GateKeeper|GateKeeper[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = GateKeeperPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(GateKeeperPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 GateKeeper A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 GateKeeper A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `gate`, `access`, `created_at`, `updated_at` FROM `gatekeeper` WHERE `id` = :p0';
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
            $obj = new GateKeeper();
            $obj->hydrate($row);
            GateKeeperPeer::addInstanceToPool($obj, (string) $key);
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
     * @return GateKeeper|GateKeeper[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|GateKeeper[]|mixed the list of results, formatted by the current formatter
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
     * @return GateKeeperQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GateKeeperPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return GateKeeperQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GateKeeperPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GateKeeperQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GateKeeperPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GateKeeperPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GateKeeperPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the gate column
     *
     * Example usage:
     * <code>
     * $query->filterByGate('fooValue');   // WHERE gate = 'fooValue'
     * $query->filterByGate('%fooValue%'); // WHERE gate LIKE '%fooValue%'
     * </code>
     *
     * @param     string $gate The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GateKeeperQuery The current query, for fluid interface
     */
    public function filterByGate($gate = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gate)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $gate)) {
                $gate = str_replace('*', '%', $gate);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(GateKeeperPeer::GATE, $gate, $comparison);
    }

    /**
     * Filter the query on the access column
     *
     * Example usage:
     * <code>
     * $query->filterByAccess('fooValue');   // WHERE access = 'fooValue'
     * $query->filterByAccess('%fooValue%'); // WHERE access LIKE '%fooValue%'
     * </code>
     *
     * @param     string $access The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GateKeeperQuery The current query, for fluid interface
     */
    public function filterByAccess($access = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($access)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $access)) {
                $access = str_replace('*', '%', $access);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(GateKeeperPeer::ACCESS, $access, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GateKeeperQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(GateKeeperPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(GateKeeperPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GateKeeperPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return GateKeeperQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(GateKeeperPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(GateKeeperPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GateKeeperPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   GateKeeper $gateKeeper Object to remove from the list of results
     *
     * @return GateKeeperQuery The current query, for fluid interface
     */
    public function prune($gateKeeper = null)
    {
        if ($gateKeeper) {
            $this->addUsingAlias(GateKeeperPeer::ID, $gateKeeper->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     GateKeeperQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(GateKeeperPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     GateKeeperQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(GateKeeperPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     GateKeeperQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(GateKeeperPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     GateKeeperQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(GateKeeperPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     GateKeeperQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(GateKeeperPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     GateKeeperQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(GateKeeperPeer::CREATED_AT);
    }
}
