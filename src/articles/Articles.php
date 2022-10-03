<?php

namespace Sentencer\articles;

use JsonException;

/**
 * A or An
 *
 * The Article class determines whether "a" or "an" should precede a word in
 * English using the method described in this stackoverflow response
 * https://stackoverflow.com/questions/1288291/how-can-i-correctly-prefix-a-word-with-a-and-an/1288473#1288473
 * The wikipedia-article-text dump provided by Eamon Nerbonne:
 * http://home.nerbonne.org/A-vs-An/
 * was used as the basis for the dataset.
 */
class Articles implements ArticlesInterface {

  /**
   * JSON mapping file, adjusted for PHP.
   */
  public const INPUT_FILE = __DIR__ . "/../config/articles.json";

  /**
   * Internal map transformed to assoc array.
   */
  protected array $map;

  /**
   * Default constructor.
   */
  public function __construct() {
    $this->map = $this->parser() ?? [];
  }

  /**
   * Public getter.
   */
  public function getMap(): array {
    return $this->map;
  }

  /**
   * Parser that uses input of JSON file and stores parsed output to map.
   *
   * @return array
   *   Loaded mapping or empty array (if file is not found for example).
   */
  private function parser(): array {
    if (file_exists(self::INPUT_FILE) && $file = file_get_contents(self::INPUT_FILE)) {

      try {
        $map = json_decode($file, TRUE, 512, JSON_THROW_ON_ERROR);
      } catch (JsonException $e) {
        $map = [];
      }
    }

    return $map ?? [];
  }

  /**
   * Function that uses map and determines which article should be used.
   *
   * @param string $word
   *   Input word.
   * @param array|null $obj
   *   Applicable map or sub-map.
   * @param string $article
   *   Determined, so far, article, defaults to "a".
   *
   * @return string
   *   Final article.
   */
  private function find(string $word, ?array $obj = NULL, string $article = 'a'): string {
    if ($word === "") {
      return $article;
    }

    $obj ??= $this->getMap();

    // Take first character from provided word. Using multibyte string function
    // to allow characters such as "∞".
    $key = mb_substr($word, 0, 1);
    $obj = $obj[$key] ?? NULL;

    if ($obj !== NULL) {
      return $this->find(mb_substr($word, 1), $obj, $obj['_'] ?? $article);
    }

    return $article;
  }

  /**
   * {@inheritDoc}
   */
  public function articlize(string $words): string {
    if ($words === "") {
      return "";
    }

    // Break to words.
    $bw = explode(" ", $words);

    // Add article as first element of the array.
    array_unshift($bw, $this->find($bw[0]));

    // Merge array to string, making article come first.
    return implode(" ", $bw);
  }

}
