<?php
class zone_TestFactory extends zone_TestFactoryBase
{
	/**
	 * @var zone_TestFactory
	 */
	private static $instance;

	/**
	 * @return zone_TestFactory
	 * @throws Exception
	 */
	public static function getInstance()
	{
		if (PROFILE != 'test')
		{
			throw new Exception('This method is only usable in test mode.');
		}
		if (self::$instance === null)
		{
			self::$instance = new zone_TestFactory;
			// register the testFactory in order to be cleared after each test case.
			tests_AbstractBaseTest::registerTestFactory(self::$instance);
		}
		return self::$instance;
	}

	/**
	 * Clear the TestFactory instance.
	 * 
	 * @return void
	 * @throws Exception
	 */
	public static function clearInstance()
	{
		if (PROFILE != 'test')
		{
			throw new Exception('This method is only usable in test mode.');
		}
		self::$instance = null;
	}
	
	/**
	 * Initialize documents default properties
	 * @return void
	 */
	public function init()
	{
		$this->setCountryDefaultProperty('label', 'country test');
		$this->setZoneDefaultProperty('label', 'zone test');
		
		$this->test_zone = $this->getZone('FR');
	}
	
	/**
	 * Get a country by its code, create one if it doesn't exist
	 *
	 * @param String $code
	 * @return zone_persistentdocument_country
	 */
	public function getCountry($code)
	{
		$country = zone_CountryService::getInstance()->getByCode($code);
		if(is_null($country))
		{
			$properties = array('label' => $code, 'code' => $code);
			$country = $this->getNewCountry(null, $properties);
		}
		return $country;
	}
	
	/**
	 * Get an existing zone by code or create new one
	 *
	 * @param String $code
	 * @return zone_persistentdocument_zone
	 */
	public function getZone($code)
	{
		$zone = zone_ZoneService::getInstance()->getByCode($code);
		if (is_null($zone))
		{
			$properties = array('label' => $code, 'code' => $code);
			$zone = $this->getNewZone(null, $properties);
		}
		return $zone;
	}
	
	/**
	 * @var zone_persistentdocument_zone
	 */
	private $test_zone;
	
	/**
	 * @return zone_persistentdocument_zone
	 */
	public function getTestZone()
	{
		return $this->test_zone;
	}
}