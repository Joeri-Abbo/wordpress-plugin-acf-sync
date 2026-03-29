<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * Basic sanity tests for the ACF Sync plugin.
 *
 * These tests verify the plugin file is valid PHP and contains
 * the expected class/command definition, without requiring a
 * full WordPress environment.
 */
class AcfSyncPluginTest extends TestCase
{
    private string $pluginFile;

    protected function setUp(): void
    {
        $this->pluginFile = dirname(__DIR__) . '/acf-sync.php';
    }

    public function testPluginFileExists(): void
    {
        $this->assertFileExists($this->pluginFile);
    }

    public function testPluginFileIsValidPhp(): void
    {
        $output = [];
        $code   = 0;
        exec('php -l ' . escapeshellarg($this->pluginFile) . ' 2>&1', $output, $code);
        $this->assertSame(0, $code, implode("\n", $output));
    }

    public function testPluginFileContainsExpectedClass(): void
    {
        $contents = file_get_contents($this->pluginFile);
        $this->assertStringContainsString('class ACF_Commands', $contents);
    }

    public function testPluginFileContainsSyncMethod(): void
    {
        $contents = file_get_contents($this->pluginFile);
        $this->assertStringContainsString('function sync(', $contents);
    }

    public function testPluginFileHasAbspathGuard(): void
    {
        $contents = file_get_contents($this->pluginFile);
        $this->assertStringContainsString("defined('ABSPATH')", $contents);
    }
}
