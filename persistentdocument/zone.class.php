<?php
class zone_persistentdocument_zone extends zone_persistentdocument_zonebase 
{		
	/**
	 * @param string $moduleName
	 * @param string $treeType
	 * @param array<string, string> $nodeAttributes
	 */	
	protected function addTreeAttributes($moduleName, $treeType, &$nodeAttributes)
	{
		if(TagService::getInstance()->hasTag($this,'default_zone'))
	    {
  	        $nodeAttributes['tags'] = 'default_zone';
   	    }
	}
	
	/**
	 * return string[]
	 */
	public function getCodes()
	{
		$result = array($this->getCode());
		if ($this->getSubzoneCount())
		{
			foreach ($this->getSubzoneArray() as $subzone) 
			{
				$result = array_merge($result, $subzone->getCodes());
			}
		}
		return $result;
	}
	
	public final function isValidCode($code, $recursive = true)
	{
		return $this->getDocumentService()->isValidCode($this, $code, $recursive);
	}
	
}