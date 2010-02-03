<?php
class zone_ZoneScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return zone_persistentdocument_zone
     */
    protected function initPersistentDocument()
    {
    	return zone_ZoneService::getInstance()->getNewDocumentInstance();
    }
}