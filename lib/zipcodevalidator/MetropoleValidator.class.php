<?php
class zone_MetropoleValidator implements zone_ICodeValidator
{
	/**
	 * @var zone_MetropoleValidator
	 */
	private static $instance;

	/**
	 * Constructor of zone_MetropoleValidator
	 */
	private function __construct()
	{
	}

	/**
	 * @return zone_MetropoleValidator
	 */
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new zone_MetropoleValidator();
		}
		return self::$instance;
	}

	/**
	 * @return String
	 */
	public function getLabel()
	{
		return f_Locale::translate('&modules.zone.bo.validator.Metropole;');
	}
    
	/**
	 * @param String $postalCode
	 * @return Boolean
	 */
    public function isValid($postalCode)
    {
        $exp = "/((0[1-9])|([1-8][0-9])|(9[0-5]))[0-9]{3}$/";
        return preg_match($exp, $postalCode) ? true : false; 
    }
}
