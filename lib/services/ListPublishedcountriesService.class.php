<?php
/**
 * @package modules.zone
 * @method zone_ListPublishedcountriesService getInstance()
 */
class zone_ListPublishedcountriesService extends change_BaseService implements list_ListItemsService
{
	/**
	 * @var list_Item[]
	 */
	private $items = null;

	/**
	 * @return list_Item[]
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
	 * @return string
	 */
	public final function getDefaultId()
	{
		$items = $this->getItems();
		return f_util_ArrayUtils::firstElement($items)->getValue();
	}
}