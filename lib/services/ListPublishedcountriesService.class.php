<?php
class zone_ListPublishedcountriesService extends BaseService
{
	/**
	 * @var customer_ListTitleService
	 */
	private static $instance;
	private $items = null;
	
	/**
	 * @return customer_ListTitleService
	 */
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}
	
	/**
	 * @return array<list_Item>
	 */
	public function getItems()
	{
		if ($this->items === null)
		{
			$query = zone_CountryService::getInstance()->createQuery();
			$query->add(Restrictions::published());
			$countries = $query->find();
			
			$ok = array();
			foreach ($countries as $country)
			{
				$ok[$country->getLabel()] = $country->getId();
			}
			
			ksort($ok, SORT_LOCALE_STRING);
			$results = array();
			foreach ($ok as $name => $id)
			{
				$results[$id] = new list_Item($name, $id);
			}
			$this->items = $results;
		}
		return $this->items;
	}
	
	/**
	 * @return String
	 */
	public function getDefaultId()
	{
		$items = $this->getItems();
		return f_util_ArrayUtils::firstElement($items)->getValue();
	}
}