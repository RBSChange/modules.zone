<?php
/**
 * zone_DepartmentScriptDocumentElement
 * @package modules.zone.persistentdocument.import
 */
class zone_DepartmentScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return zone_persistentdocument_department
     */
    protected function initPersistentDocument()
    {
    	$department = zone_DepartmentService::getInstance()->getByCode($this->attributes['code']);
		if($department !== null)
		{
			return $department;
		}
    	return zone_DepartmentService::getInstance()->getNewDocumentInstance();
    }
    
    /**
	 * @return f_persistentdocument_PersistentDocumentModel
	 */
	protected function getDocumentModel()
	{
		return f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName('modules_zone/department');
	}

}