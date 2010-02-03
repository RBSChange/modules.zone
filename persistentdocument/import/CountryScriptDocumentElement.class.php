<?php
class zone_CountryScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return zone_persistentdocument_country
     */
    protected function initPersistentDocument()
    {
			$country = zone_CountryService::getInstance()->getByCode($this->attributes['code']);
			if($country !== null)
			{
				return $country;
			}
    	return zone_CountryService::getInstance()->getNewDocumentInstance();
    }
}