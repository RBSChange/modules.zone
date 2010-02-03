<?php
class zone_DomtomValidator implements zone_ICodeValidator
{
	/**
	 * @var zone_DomtomValidator
	 */
	private static $instance;

	/**
	 * Constructor of zone_DomtomValidator
	 */
	private function __construct()
	{
	}

	/**
	 * @return zone_DomtomValidator
	 */
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new zone_DomtomValidator();
		}
		return self::$instance;
	}

	/**
	 * @return String
	 */
	public function getLabel()
	{
		return f_Locale::translate('&modules.zone.bo.validator.Domtom;');
	}
    
	/**
	 * @param String $postalCode
	 * @return Boolean
	 */
    public function isValid($postalCode)
    {
        $exp = "/97[0-9]{3}$/";
        return preg_match($exp, $postalCode) ? true : false; 
    }
}
