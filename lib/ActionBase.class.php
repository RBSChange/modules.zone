<?php
class zone_ActionBase extends f_action_BaseAction
{
		
	/**
	 * Returns the zone_ZoneService to handle documents of type "modules_zone/zone".
	 *
	 * @return zone_ZoneService
	 */
	public function getZoneService()
	{
		return zone_ZoneService::getInstance();
	}
		
	/**
	 * Returns the zone_CountryService to handle documents of type "modules_zone/country".
	 *
	 * @return zone_CountryService
	 */
	public function getCountryService()
	{
		return zone_CountryService::getInstance();
	}
		
}