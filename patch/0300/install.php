<?php
/**
 * zone_patch_0300
 * @package modules.zone
 */
class zone_patch_0300 extends patch_BasePatch
{
//  by default, isCodePatch() returns false.
//  decomment the following if your patch modify code instead of the database structure or content.
    /**
     * Returns true if the patch modify code that is versionned.
     * If your patch modify code that is versionned AND database structure or content,
     * you must split it into two different patches.
     * @return Boolean true if the patch modify code that is versionned.
     */
//	public function isCodePatch()
//	{
//		return true;
//	}
 
	/**
	 * Entry point of the patch execution.
	 */
	public function execute()
	{
		try 
		{				
			$newPath = f_util_FileUtils::buildWebeditPath('modules/zone/persistentdocument/zone.xml');
			$newModel = generator_PersistentModel::loadModelFromString(f_util_FileUtils::read($newPath), 'zone', 'zone');
			$newProp = $newModel->getPropertyByName('subzone');
			f_persistentdocument_PersistentProvider::getInstance()->addProperty('zone', 'zone', $newProp);
		
			$sql = "select * from f_relationname where property_name = 'subzone'";
			$stmt = $this->executeSQLSelect($sql);
			$result = $stmt->fetchAll();
			if (count($result) == 1)
			{
				$newrelId = $result[0]['relation_id'];
				
				$sql = "UPDATE f_relation SET relation_id =$newrelId, relation_name='subzone' where relation_name='country' AND document_model_id1='modules_zone/zone'";
				$this->executeSQLQuery($sql);
				
				$sql = "update m_zone_doc_zone set subzone = (select count(*) from f_relation where relation_id1 = m_zone_doc_zone.document_id  and relation_id = $newrelId)";
				$this->executeSQLQuery($sql);
			
				$sql = "ALTER TABLE `m_zone_doc_zone` DROP `country`";
				$this->executeSQLQuery($sql);
				
				$sql = "update m_zone_doc_zone set code = 'FR-ALL' WHERE code='FR' AND document_model='modules_zone/zone'"; 
				$this->executeSQLQuery($sql);
				
				$sql="insert into m_zone_doc_zone (document_id, document_model, document_author, document_authorid, document_creationdate, document_modificationdate, document_publicationstatus, document_lang, document_modelversion,document_version,document_startpublicationdate, document_endpublicationdate,document_metas,document_label,code,description) SELECT document_id, document_model, document_author, document_authorid, document_creationdate, document_modificationdate, document_publicationstatus, document_lang, document_modelversion,document_version,document_startpublicationdate, document_endpublicationdate,document_metas,document_label,code,null FROM m_zone_doc_country";
				$this->executeSQLQuery($sql);
				
				$sql="DROP TABLE m_zone_doc_country";
				$this->executeSQLQuery($sql);
				
				$sql="DROP TABLE m_zone_doc_country_i18n";
				$this->executeSQLQuery($sql);
			}
			else
			{
				throw new Exception('Please compile-documents and compile-db-schema before this patch');
			}
			
			$this->executeModuleScript('init.xml', 'zone');
			
			$this->execChangeCommand('compile-locales', array('zone'));
			
			$this->execChangeCommand('compile-editors-config');
			
		}
		catch (Exception $e)
		{
			$this->logWarning($e->getMessage());
		}
	}

	/**
	 * @return String
	 */
	protected final function getModuleName()
	{
		return 'zone';
	}

	/**
	 * @return String
	 */
	protected final function getNumber()
	{
		return '0300';
	}
}