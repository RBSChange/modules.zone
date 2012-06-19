<?php
/**
 * @method zone_CountryService getInstance()
 */
class zone_CountryService extends zone_ZoneService
{
	/**
	 * @return zone_persistentdocument_country
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_zone/country');
	}

	/**
	 * Create a query based on 'modules_zone/country' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_zone/country');
	}
	
	/**
	 * Create a query based on 'modules_zone/country' model.
	 * Only documents that are strictly instance of modules_zone/country
	 * (not children) will be retrieved
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createStrictQuery()
	{
		return $this->getPersistentProvider()->createQuery('modules_zone/country', false);
	}

	/**
	 * @param string $code
	 * @return zone_persistentdocument_country
	 */
	public function getByCode($code)
	{
		return $this->createStrictQuery()->add(Restrictions::eq('code', $code))->findUnique();
	}
	
	/**
	 * @param integer $countryId
	 * @param string $zipCode
	 * @return boolean
	 */
	public function isZipCodeValid($countryId, $zipCode)
	{
	    $isValid = true;
		$country = ($countryId > 0) ? DocumentHelper::getDocumentInstance($countryId) : null;
	    if ($country instanceof zone_persistentdocument_zone && $country->getSubzoneCount())
	    {
	        $isValid = $country->getDocumentService()->isValidCode($country, $zipCode);
	    }
	    return $isValid;
	}
	
	/**
	 * @param zone_persistentdocument_zone $zone
	 * @param boolean $publishedOnly
	 * @return zone_persistentdocument_country[]
	 */
	public function getCountries($zone, $publishedOnly = true)
	{
		$result = array();
		if ($zone instanceof zone_persistentdocument_country) 
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

				foreach ($this->getCountries($subzone, $publishedOnly) as $country)
				{
					$result[] = $country;
				}
			}
		}
		return $result;
	}
}