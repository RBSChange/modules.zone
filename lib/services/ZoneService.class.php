<?php
/**
 * @package modules.zone
 */
class zone_ZoneService extends f_persistentdocument_DocumentService
{
	/**
	 * Singleton
	 * @var zone_ZoneService
	 */
	private static $instance = null;

	/**
	 * @return zone_ZoneService
	 */
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}

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
		return $this->pp->createQuery('modules_zone/zone');
	}

	/**
	 * @todo use the 'default_zone' exclusive tag.
	 * @return zone_persistentdocument_zone
	 */
	public function getDefaultZone()
	{
		try
		{
			return TagService::getInstance()->getDocumentByExclusiveTag('default_zone');
		}
		catch (Exception $e)
		{
			Framework::exception($e);	
		}
		return $this->createQuery()->findUnique();
	}

	/**
	 * @todo use the 'default_zone' exclusive tag.
	 * @return integer zoneId
	 */
	public function getDefaultZoneId()
	{
		return $this->getDefaultZone()->getId();
	}

	/**
	 * @param string $code
	 * @return zone_persistentdocument_zone
	 */
	public function getByCode($code)
	{
		return $this->createQuery()->add(Restrictions::eq("code", $code))->findUnique();
	}

	/**
	 * @param zone_persistentdocument_country $country
	 * @param zone_persistentdocument_zone $zone
	 * @return Boolean
	 */
	public function isCountryInZone($country, $zone)
	{
		$query = zone_ZoneService::getInstance()->createQuery();
		$query->createCriteria("country")
			->add(Restrictions::eq('code', $country->getCode()));
		$query->setProjection(Projections::rowCount('countryCount'));
		$result = $query->findUnique();
		return $result['countryCount'] > 0;
	}
}