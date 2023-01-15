<?php

namespace ActivityPhpTest;

use PHPUnit\Framework\TestCase;
use ActivityPhp\Version;

/**
 * Tests ActivityPhp\Version
 */
class VersionTest extends TestCase
{
    public function testGetVersion()
    {
        $this->assertMatchesRegularExpression(
            '/\d.\d.\d/',
            Version::getVersion()
        );
    }
}
