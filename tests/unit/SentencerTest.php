<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Sentencer\articles\Articles;
use Sentencer\generator\SentenceGenerator;
use Sentencer\generator\SentenceGeneratorInterface;
use Sentencer\sentences\Sentencer;
use Sentencer\sentences\SentencerInterface;

final class SentencerTest extends TestCase {

  protected SentencerInterface $sentencer;

  protected SentenceGeneratorInterface $generator;

  /**
   * {@inheritDoc}
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Prepare environment for testing.
   *
   * @throws \JsonException
   */
  protected function setUp(): void {
    parent::setUp();

    $this->sentencer = new Sentencer(new Articles());
    $this->generator = new SentenceGenerator($this->sentencer);
  }

  public function testConfig(): void {
    $overview = $this->sentencer->configOverview();

    $this->assertGreaterThan(0, $overview['nouns'], 'There are no nouns loaded.');
    $this->assertGreaterThan(0, $overview['adjectives'], 'There are no adjectives loaded.');
  }


  public function testSentences(): void {
    $this->assertEquals('a car', $this->sentencer->a_noun('car'), 'Incorrect adjective detected.');
  }

  public function testGenerator(): void {
    $this->assertEquals('test sentence', $this->generator->parseTemplate('test sentence'));
    $this->assertNotEmpty($this->generator->generateSentence());
    $this->assertNotEmpty($this->generator->generateSentence(2));
  }
}