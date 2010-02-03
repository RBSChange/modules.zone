<?php
class zone_CorseValidator implements zone_ICodeValidator
{
	/**
	 * @var zone_CorseValidator
	 */
	private static $instance;

	/**
	 * Constructor of zone_CorseValidator
	 */
	private function __construct()
	{
	}

	/**
	 * @return zone_CorseValidator
	 */
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new zone_CorseValidator();
		}
		return self::$instance;
	}

	/**
	 * @return String
	 */
	public function getLabel()
	{
		return f_Locale::translate('&modules.zone.bo.validator.Corse;');
	}
    
	/**
	 * @param String $postalCode
	 * @return Boolean
	 */
    public function isValid($postalCode)
    {
        $exp = "/20[0-9]{3}$/";
        return preg_match($exp, $postalCode) ? true : false; 
    }
}
