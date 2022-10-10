<?php

namespace Sentencer\sentences;

use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use Doctrine\Inflector\Language;
use Sentencer\articles\ArticlesInterface;

/**
 * Generates random sentence.
 */
class Sentencer implements SentencerInterface {

  /**
   * Allowed actions that can be called dynamically. This is not to call any
   * other function when used in {{ method }} format.
   */
  public const ALLOWED_ACTIONS = [
    'noun', 'a_noun', 'nouns', 'adjective', 'an_adjective',
  ];

  /**
   * JSON mapping file, adjusted for PHP.
   */
  public const WORD_INPUT_FILE = __DIR__ . "/../config/words.json";

  /**
   * List of all loaded adjectives.
   *
   * @var array|mixed
   */
  protected array $adjectives;

  /**
   * List of all loaded nouns.
   *
   * @var array|mixed
   */
  protected array $nouns;

  /**
   * External class that pluralize noun.
   *
   * @var \Doctrine\Inflector\Inflector
   */
  protected Inflector $inflector;

  /**
   * A or AN logic.
   *
   * @var \Sentencer\articles\ArticlesInterface
   */
  protected ArticlesInterface $articles;

  /**
   * Word parser.
   *
   * Parses input json file and converts it to associative array.
   *
   * @return array
   *    Parsed array.
   *
   * @throws \JsonException
   */
  private function wordParser(): array {
    if (file_exists(self::WORD_INPUT_FILE) && $file = file_get_contents(self::WORD_INPUT_FILE)) {
      $words = json_decode($file, TRUE, 512, JSON_THROW_ON_ERROR);
    }

    return $words ?? [];
  }

  /**
   * Default constructor.
   *
   * @throws \JsonException
   */
  public function __construct(ArticlesInterface $articles) {
    $words = $this->wordParser();
    $this->adjectives = $words['adjectives'] ?? [];
    $this->nouns = $words['nouns'] ?? [];
    $this->inflector = InflectorFactory::createForLanguage(Language::ENGLISH)->build();
    $this->articles = $articles;
  }

  /**
   * {@inheritDoc}
   */
  public function noun(): string {
    return $this->nouns[array_rand($this->nouns)];
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
    return $this->adjectives[array_rand($this->adjectives)];
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
