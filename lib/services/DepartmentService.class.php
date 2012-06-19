<?php
/**
 * @package modules.zone
 * @method zone_DepartmentService getInstance()
 */
class zone_DepartmentService extends zone_ZoneService
{
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
		return $this->getPersistentProvider()->createQuery('modules_zone/department');
	}
	
	/**
	 * Create a query based on 'modules_zone/department' model.
	 * Only documents that are strictly instance of modules_zone/department
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_zone/department', false);
	}
	
	/**
	 * @param string $code
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