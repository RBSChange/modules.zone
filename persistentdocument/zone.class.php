<?php
class zone_persistentdocument_zone extends zone_persistentdocument_zonebase 
{
	public function hasZones($zonesIds)
	{
		$zs = zone_ZoneService::getInstance();
		
		return $zs->hasZones($this->getId(), $zonesIds);
	}
	
	public function hasCountries($zoneCountryIds)
	{
		$zs = zone_ZoneService::getInstance();
		
		$zs->hasCountries($this->getId(), $zoneCountryIds);
	}
	
	public function hasStates($zoneStateIds)
	{
		$zs = zone_ZoneService::getInstance();
		
		$zs->hasStates($this->getId(), $zoneStateIds);
	}
	
	public function hasZips($zoneZipIds)
	{
		$zs = zone_ZoneService::getInstance();
		
		$zs->hasZips($this->getId(), $zoneZipIds);
	}
	
	public function inZone($zoneContainerId)
	{
		$zs = zone_ZoneService::getInstance();
		
		$zs->inZone($this->getId(), $zoneContainerId);
	}
	
	/**
	 * @param string $moduleName
	 * @param string $treeType
	 * @param array<string, string> $nodeAttributes
	 */	
	protected function addTreeAttributes($moduleName, $treeType, &$nodeAttributes)
	{
		if(TagService::getInstance()->hasTag($this,'default_zone'))
	    {
  	        $nodeAttributes['tags'] = 'default_zone';
   	    }
	}
}