<?php
/**
 * @package modules.zone
 * @method zone_ZoneService getInstance()
 */
class zone_ZoneService extends f_persistentdocument_DocumentService
{
	/**
	 * @return zone_persistentdocument_zone
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_zone/zone');
	}

	/**
	 * Create a query based on 'modules_zone/zone' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_zone/zone');
	}

	/**
	 * Create a query based on 'modules_zone/zone' model.
	 * Only documents that are strictly instance of modules_zone/zone
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_zone/zone', false);
	}

	/**
	 * @see f_persistentdocument_DocumentService::preSave()
	 *
	 * @param zone_persistentdocument_zone $document
	 * @param integer $parentNodeId
	 */
	protected function preSave($document, $parentNodeId)
	{
		if ($document->isPropertyModified('subzone') && $document->getSubzoneCount())
		{
			$path = array($document->getId());
			foreach ($document->getSubzoneArray() as $subdoc)
			{
				if ($this->isInPath($subdoc, $path))
				{
					if (Framework::isInfoEnabled())
					{
						Framework::info('Recusivity on ' .$document->__toString() .' for '.  $subdoc->__toString());
					}
					$document->removeSubzone($subdoc);
				}
			}
		}
	}

	/**
	 * @param zone_persistentdocument_zone $document
	 * @param array $path
	 * @return boolean
	 */
	private function isInPath($document, $path)
	{
		if (in_array($document->getId(), $path))
		{
			return true;
		}
		if ($document->getSubzoneCount())
		{
			$path[] = $document->getId();
			foreach ($document->getSubzoneArray() as $subdoc)
			{
				if ($this->isInPath($subdoc, $path))
				{
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * @deprecated
	 * @var zone_persistentdocument_zone
	 */
	private $defaultZone;

	/**
	 * @deprecated
	 * @return zone_persistentdocument_zone
	 */
	public function getDefaultZone()
	{
		if ($this->defaultZone === null)
		{
			try
			{
				$this->defaultZone = TagService::getInstance()->getDocumentByExclusiveTag('default_zone');
			}
			catch (Exception $e)
			{
				Framework::warn(__METHOD__ . ' tag default_zone not set, ' . $e->getMessage());
				$result = $this->createQuery()->setMaxResults(1)->find();
				if (count($result) == 1)
				{
					return $result[0];
				}
				return null;
			}
		}
		return $this->defaultZone;
	}

	/**
	 * @deprecated
	 * @return integer zoneId
	 */
	public function getDefaultZoneId()
	{
		$dz = $this->getDefaultZone();
		return $dz === null ? 0 : $dz->getId();
	}

	/**
	 * @param string $code
	 * @return zone_persistentdocument_zone[]
	 */
	public function getZonesByCode($code)
	{
		return $this->createQuery()->add(Restrictions::eq("code", $code))->find();
	}

	/**
	 * @param zone_persistentdocument_country $country
	 * @param zone_persistentdocument_zone $zone
	 * @return boolean
	 */
	public function isCountryInZone($country, $zone)
	{
		$query = $this->createQuery()
			->add(Restrictions::eq('subzone.code', $country->getCode()))
			->setProjection(Projections::rowCount('countryCount'));
		$result = $query->findUnique();
		return $result['countryCount'] > 0;
	}

	/**
	 * @param zone_persistentdocument_zone $zone
	 * @param string $code
	 * @param boolean $recursive
	 * @return boolean
	 */
	public final function isValidCode($zone, $code, $recursive = true)
	{
		if ($zone->getDocumentService() !== $this)
		{
			return $zone->getDocumentService()->hasMatchingCode($zone, $code, $recursive);
		}
		return $this->hasMatchingCode($zone, $code, $recursive);
	}

	/**
	 * @param zone_persistentdocument_zone $zone
	 * @param string $code
	 * @param boolean $recursive
	 * @return boolean
	 */
	protected function hasMatchingCode($zone, $code, $recursive)
	{
		$match = $this->checkCode($zone, $code);
		if ($match)
		{
			return true;
		}
		if ($recursive && $zone->getSubzoneCount())
		{
			foreach ($zone->getSubzoneArray() as $subzone)
			{
				if ($subzone->getDocumentService()->hasMatchingCode($subzone, $code, $recursive))
				{
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * @param zone_persistentdocument_zone $zone
	 * @param string $code
	 * @return boolean
	 */
	protected function checkCode($zone, $code)
	{
		return strpos(strtolower($code), strtolower($zone->getCode())) === 0;
	}
}