<?php

namespace Sentencer\generator;

use JsonException;
use Sentencer\sentences\Sentencer;

class Generator {

  private const MAX_SENTENCES = 10;

  public const TEMPLATE_INPUT_FILE = __DIR__ . "/../config/sentences.json";

  protected array $templates;

  protected array $phrases;

  protected Sentencer $sentencer;

  public function __construct() {
    $templates = $this->templateParser();

    $this->templates = $templates['sentences'] ?? [];
    $this->phrases = $templates['phrases'] ?? [];

    $this->sentencer = new Sentencer();
  }

  /**
   * Template parser.
   *
   * Parses input json file and converts it to associative array.
   *
   * @return array
   *    Parsed array.
   */
  private function templateParser(): array {
    if (file_exists(self::TEMPLATE_INPUT_FILE) && $file = file_get_contents(self::TEMPLATE_INPUT_FILE)) {
      try {
        $templates = json_decode($file, TRUE, 512, JSON_THROW_ON_ERROR);
      }
      catch (JsonException $e) {
        $templates = [];
      }
    }

    return $templates ?? [];
  }


  public function randomTemplate(): string {
    return $this->templates[array_rand($this->templates)] ?? '';
  }

  public function generateSentences(int $number = 1): string {
    $output = '';

    if ($number > self::MAX_SENTENCES) {
      $number = self::MAX_SENTENCES;
    }

    for ($i = 0; $i <= $number; $i++) {

      $output .= ' ' . $this->randomPhrase() . ucfirst($this->randomTemplate()) . '.';
    }

    return $output;
  }

  private function randomPhrase(): string {
    $phrase = '';

    if (random_int(1, 100) > 75) {
      $phrase = $this->phrases[array_rand($this->phrases)];
    }

    return $phrase;
  }

}