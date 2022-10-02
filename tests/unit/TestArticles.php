<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Sentencer\articles\Articles;

final class TestArticles extends TestCase {

  protected Articles $articles;

  /**
   * {@inheritDoc}
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * {@inheritDoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->articles = new Articles();
  }

  /**
   * Test if mapping is loaded.
   */
  public function testArticleMap(): void {
    $this->assertNotEmpty($this->articles->getMap(), 'Input file mapping failed to load.');
  }

  /**
   * Testing small sample of words.
   *
   * Test some cases from predefined key/value array, there
   * key is input and value expected/output value.
   */
  public function testArticles(): void {
    $values = [
      'unanticipated result' => 'an unanticipated result',
      'unanimous vote' => 'a unanimous vote',
      'honest decision' => 'an honest decision',
      'honeysuckle shrub' => 'a honeysuckle shrub',
      '0800 number' => 'an 0800 number',
      '∞ of oregano' => 'an ∞ of oregano',
      'NASA scientist' => 'a NASA scientist',
      'NSA analyst' => 'an NSA analyst',
      'FIAT car' => 'a FIAT car',
      'FAA policy' => 'an FAA policy',
    ];

    foreach ($values as $input => $expected) {
      $this->assertEquals($expected, $this->articles->articlize($input), 'Failed on ' . $input);
    }
  }
}
