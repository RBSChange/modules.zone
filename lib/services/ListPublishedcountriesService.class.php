<?php
class zone_ListPublishedcountriesService extends change_BaseService
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
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * @return array<list_Item>
	 */
	public final function getItems()
	{
		if($this->items === null)
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
	public final function getDefaultId()
	{
		$items = $this->getItems();
		return f_util_ArrayUtils::firstElement($items)->getValue();
	}
}