<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Sentencer\sentences\Sentencer;

final class TestSentencer extends TestCase {

  protected Sentencer $sentencer;

  /**
   * {@inheritDoc}
   */
  public function __construct() {
    parent::__construct();
  }

  protected function setUp(): void {
    parent::setUp();

    $this->sentencer = new Sentencer();
  }

  public function testConfig(): void {
    $overview = $this->sentencer->configOverview();

    $this->assertGreaterThan(0, $overview['nouns'], 'There are no nouns loaded.');
    $this->assertGreaterThan(0, $overview['adjectives'], 'There are no adjectives loaded.');
  }


}