<?php
class zone_CountryService extends f_persistentdocument_DocumentService
{
	/**
	 * Singleton
	 * @var zone_CountryService
	 */
	private static $instance = null;

	/**
	 * @return zone_CountryService
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
		return $this->pp->createQuery('modules_zone/country');
	}

	/**
	 * @param String $code
	 * @return zone_persistentdocument_country
	 */
	public function getByCode($code)
	{
		return $this->createQuery()->add(Restrictions::eq('code', $code))->findUnique();
	}
	
	/**
	 * @param Integer $countryId
	 * @param String $zipCode
	 * @return Boolean
	 */
	public function isZipCodeValid($countryId, $zipCode)
	{
	    $isValid = true;
	    
		$country = ($countryId > 0) ? DocumentHelper::getDocumentInstance($countryId) : null;
	    if (!is_null($country))
	    {
	        $validatorClassName = $country->getValidatorClassName();
	        if (!is_null($validatorClassName))
	        {
                $validator = f_util_ClassUtils::callMethod($validatorClassName, 'getInstance');
                $isValid = $validator->isValid($zipCode);
	        }
	    }

	    return $isValid;
	}
	
}