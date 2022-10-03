<?php

namespace Sentencer\sentences;

use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use Doctrine\Inflector\Language;
use Sentencer\articles\Articles;

/**
 * Generates random sentence.
 */
class Sentencer implements SentencerInterface {

  /**
   * JSON mapping file, adjusted for PHP.
   */
  public const INPUT_FILE = __DIR__ . "/../config/words.json";

  protected array $adjectives;

  protected array $nouns;

  protected Inflector $inflector;

  protected Articles $articles;

  /**
   * Word parser.
   *
   * Parses input json file and converts it to associative array.
   *
   * @return array
   *    Parsed array.
   */
  private function parser(): array {
    if (file_exists(self::INPUT_FILE) && $file = file_get_contents(self::INPUT_FILE)) {
      try {
        $words = json_decode($file, TRUE, 512, JSON_THROW_ON_ERROR);
      }
      catch (\JsonException $e) {
        $words = [];
      }
    }

    return $words ?? [];
  }

  /**
   * Default constructor.
   */
  public function __construct() {
    $words = $this->parser();
    $this->adjectives = $words['adjectives'] ?? [];
    $this->nouns = $words['nouns'] ?? [];
    $this->inflector = InflectorFactory::createForLanguage(Language::ENGLISH)->build();
    $this->articles = new Articles();
  }

  /**
   * {@inheritDoc}
   */
  public function noun(): string {
    return $this->nouns[array_rand($this->nouns, 1)];
  }

  /**
   * {@inheritDoc}
   */
  public function a_noun(string $input = NULL): string {
    return $this->articles->articlize($input ?? $this->noun());
  }

  /**
   * {@inheritDoc}
   */
  public function nouns(string $input = NULL): string {
    return $this->inflector->pluralize($input ?? $this->noun());
  }

  /**
   * {@inheritDoc}
   */
  public function adjective(): string {
    return $this->adjectives[array_rand($this->adjectives, 1)];
  }

  /**
   * {@inheritDoc}
   */
  public function an_adjective(string $input = NULL): string {
    return $this->articles->articlize($input ?? $this->adjective());
  }

  /**
   * {@inheritDoc}
   */
  public function configOverview(): array {
    return [
      'nouns' => count($this->nouns),
      'adjectives' => count($this->adjectives),
    ];
  }

}
