<?php
interface zone_ICodeValidator
{
	/**
	 * @return zone_ICodeValidator
	 */
	static function getInstance();

	/**
	 * @return String
	 */
	public function getLabel();

	/**
	 * @param String $zipCode
	 * @return Boolean
	 */
	public function isValid($zipCode);
}