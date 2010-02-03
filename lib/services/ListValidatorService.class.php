<?php
/**
 * zone_ListValidatorService
 * @package modules.zone.lib.services
 */
class zone_ListValidatorService extends BaseService implements list_ListItemsService
{
	/**
	 * Singleton
	 * @var zone_ListValidatorService
	 */
	private static $instance = null;

	/**
	 * @var array<string>
	 */
	private $availableValidatorArray = null;
	
	/**
	 * @return zone_ListValidatorService
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
	 * @return Array<list_Item>
	 */
	public function getItems()
	{
		$itemArray = array();
	    foreach ($this->getAvailableValidators() as $serviceClassName)
	    {
	    	$serviceInstance = f_util_ClassUtils::callMethod($serviceClassName, 'getInstance');
	    	if ($serviceInstance instanceof zone_ICodeValidator)
	    	{
		    	$itemArray[] = new list_Item($serviceInstance->getLabel(), $serviceClassName);
	    	}
   			else
   			{
   				Framework::warn(__METHOD__.": \"$serviceClassName\" is not a valid \"zone_ICodeValidator\". Please check project's global configuration file.");
   			}
	    }
		return $itemArray;
	}

	/**
	 * @return Array<String>
	 */
	private function getAvailableValidators()
	{
		if ( is_null($this->availableValidatorArray) )
		{
			$this->findValidators();
			$this->findProjectValidators();
		}
		return $this->availableValidatorArray;
	}

	/**
	 * retrieve validators located in this module (lib/postalcodevalidator).
	 */
	private function findValidators()
	{
		$dir = dir(FileResolver::getInstance()->setPackageName('modules_zone')->getPath('lib/zipcodevalidator'));
		$validatorSuffix = 'Validator.class.php';
		while ($entry = $dir->read())
		{
			if (f_util_StringUtils::endsWith($entry, $validatorSuffix))
			{
				$this->availableValidatorArray[] = 'zone_' . substr($entry, 0, -strlen($validatorSuffix)) . 'Validator';
			}
		}
		$dir->close();
	}

	/**
	 * Finds project's validators.
	 * This method looks for declared validators in the project's global
	 * configuration file.
	 *
	 * @example
	 * <modules>
	 *   <zone>
	 *     <code-validator>
	 *       <entry name="1">project_CanadaValidator</entry>
	 *       <entry name="2">project_BelgiqueValidator</entry>
	 *     </code-validator>
	 *   </zone>
	 * </modules>
	 */
	private function findProjectValidators()
	{
		try
		{
			$this->availableValidatorArray = array_merge(
				$this->availableValidatorArray,
				array_values(Framework::getConfiguration(('modules/zone/code-validator')))
				);
		}
		catch (ConfigurationException $e)
		{
			Framework::warn(__METHOD__.": no validator found in project's global configuration file.");
		}
	}	
}