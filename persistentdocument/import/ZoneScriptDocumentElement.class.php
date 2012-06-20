<?php
class zone_ZoneScriptDocumentElement extends import_ScriptDocumentElement
{
	/**
	 * @return zone_persistentdocument_zone
	 */
	protected function initPersistentDocument()
	{	
		$zone = zone_ZoneService::getInstance()->createStrictQuery()
			->add(Restrictions::eq('code', $this->attributes['code']))
			->findUnique();
		if($zone !== null)
		{
			return $zone;
		}
		return zone_ZoneService::getInstance()->getNewDocumentInstance();
	}
}