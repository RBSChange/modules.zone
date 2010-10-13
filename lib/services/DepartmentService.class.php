<?php
/**
 * zone_DepartmentService
 * @package modules.zone
 */
class zone_DepartmentService extends zone_ZoneService
{
	/**
	 * @var zone_DepartmentService
	 */
	private static $instance;

	/**
	 * @return zone_DepartmentService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}

	/**
	 * @return zone_persistentdocument_department
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_zone/department');
	}

	/**
	 * Create a query based on 'modules_zone/department' model.
	 * Return document that are instance of modules_zone/department,
	 * including potential children.
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_zone/department');
	}
	
	/**
	 * Create a query based on 'modules_zone/department' model.
	 * Only documents that are strictly instance of modules_zone/department
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->pp->createQuery('modules_zone/department', false);
	}
	
	/**
	 * @param String $code
	 * @return zone_persistentdocument_department
	 */
	public function getByCode($code)
	{
		return $this->createStrictQuery()->add(Restrictions::eq('code', $code))->findUnique();
	}
	
 	/**
	 * @param zone_persistentdocument_zone $zone
	 * @param boolean $publishedOnly
	 * @return zone_persistentdocument_department[]
	 */
	public function getDepartments($zone, $publishedOnly = true)
	{
		$result = array();
		if ($zone instanceof zone_persistentdocument_department) 
		{
			if (!$publishedOnly || ($publishedOnly && $zone->isPublished()))
			{
				$result[] = $zone;
			}
		}
		else if ($zone->getSubzoneCount() > 0)
		{
			foreach ($zone->getSubzoneArray() as $subzone) 
			{
				foreach ($this->getDepartments($subzone, $publishedOnly) as $department)
				{
					$result[] = $department;
				}
			}
		}
		return $result;
	}
}