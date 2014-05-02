<?php
/**
 * Author: Łukasz Barulski
 * Date: 02.05.14 12:46
 */

namespace lbarulski\GateKeeperPropelBundle\Repository;

use GateKeeper\Model\ModelInterface;
use GateKeeper\Repository\RepositoryInterface;
use lbarulski\GateKeeperPropelBundle\Model\GateKeeper;
use lbarulski\GateKeeperPropelBundle\Model\GateKeeperQuery;

class Propel implements RepositoryInterface
{
	/**
	 * @param GateKeeper|ModelInterface $gateKeeperModel
	 *
	 * @return bool
	 */
	public function save(ModelInterface $gateKeeperModel)
	{
		return (bool)$gateKeeperModel->save();
	}

	/**
	 * @param GateKeeper|ModelInterface $gateKeeperModel
	 *
	 * @return bool
	 */
	public function update(ModelInterface $gateKeeperModel)
	{
		return $this->save($gateKeeperModel);
	}

	/**
	 * @param GateKeeper|ModelInterface $gateKeeperModel
	 *
	 * @return bool
	 */
	public function delete(ModelInterface $gateKeeperModel)
	{
		try
		{
			$gateKeeperModel->delete();
		}
		catch(\Exception $e)
		{
			return false;
		}

		return true;
	}

	/**
	 * @param string $name
	 *
	 * @return ModelInterface|null
	 */
	public function get($name)
	{
		return (new GateKeeperQuery)
			->filterByGate($name)
			->findOne();
	}
}