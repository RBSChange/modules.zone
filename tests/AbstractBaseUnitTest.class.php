<?php
abstract class zone_tests_AbstractBaseUnitTest extends zone_tests_AbstractBaseTest
{
	/**
	 * @return void
	 */
	public function prepareTestCase()
	{
		$this->loadSQLResource('unit-test.sql', true, false);
	}
}