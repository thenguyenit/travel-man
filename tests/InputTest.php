<?php

class InputTest extends PHPUnit_Framework_TestCase
{
    protected static $filePathBackup;

    public static function setUpBeforeClass()
    {
        self::$filePathBackup = \Helper\CityHelper::$filePath;
    }

    public function testFileInputIsExistsValid()
    {
        $this->assertTrue(is_file(\Helper\CityHelper::$filePath));
    }

    public function testThrowExceptionWhenFileEmpty()
    {
        \Helper\CityHelper::$filePath = __DIR__ . '\empty-city.txt';
        $this->expectException(Exception::class);
        \Helper\CityHelper::getCities();
    }

    public static function tearDownAfterClass()
    {
        Helper\CityHelper::$filePath = self::$filePathBackup;
    }
}
