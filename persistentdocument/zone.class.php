<?php
class zone_persistentdocument_zone extends zone_persistentdocument_zonebase 
{		
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
	
	/**
	 * @param string $code
	 * @param boolean $recursive
	 * @return boolean
	 */
	public final function isValidCode($code, $recursive = true)
	{
		return $this->getDocumentService()->isValidCode($this, $code, $recursive);
	}
}