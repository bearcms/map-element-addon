<?php

/*
 * Map element addon for Bear CMS
 * https://github.com/bearcms/map-element-addon
 * Copyright (c) Amplilabs Ltd.
 * Free to use under the MIT license.
 */

/**
 * @runTestsInSeparateProcesses
 */
class MapElementTest extends BearCMS\AddonTests\PHPUnitTestCase
{
    /**
     * 
     */
    public function testOutput()
    {
        $app = $this->getApp();

        $html = '<bearcms-map-element code="test-code"/>';
        $result = $app->components->process($html);

        $this->assertTrue(strpos($result, '<div class="bearcms-map-element"') !== false);
        $this->assertTrue(strpos($result, 'https://maps.google.com/maps?') !== false);
    }
}
