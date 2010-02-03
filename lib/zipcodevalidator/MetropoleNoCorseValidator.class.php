<?php
class zone_MetropoleNoCorseValidator implements zone_ICodeValidator
{
	/**
	 * @var zone_MetropoleNoCorseValidator
	 */
	private static $instance;

	/**
	 * Constructor of zone_MetropoleNoCorseValidator
	 */
	private function __construct()
	{
	}

	/**
	 * @return zone_MetropoleNoCorseValidator
	 */
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new zone_MetropoleNoCorseValidator();
		}
		return self::$instance;
	}

	/**
	 * @return String
	 */
	public function getLabel()
	{
		return f_Locale::translate('&modules.zone.bo.validator.Metropole-no-corse;');
	}
    
	/**
	 * @param String $postalCode
	 * @return Boolean
	 */
    public function isValid($postalCode)
    {        
        $exp = "/((0[1-9])|(1[0-9])|([2-8][1-9])|(9[0-5]))[0-9]{3}$/";
        return preg_match($exp, $postalCode) ? true : false; 
    }
}
