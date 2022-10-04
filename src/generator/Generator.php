<?php

namespace Sentencer\generator;

use JsonException;
use Sentencer\sentences\SentencerInterface;

class Generator implements GeneratorInterface {

  private const MAX_SENTENCES = 20;

  public const TEMPLATE_INPUT_FILE = __DIR__ . "/../config/sentences.json";

  protected array $templates;

  protected array $phrases;

  protected array $titles;

  protected array $labels;

  protected SentencerInterface $sentencer;

  public function __construct(SentencerInterface $sentencer) {
    $templates = $this->templateParser();

    $this->templates = $templates['sentences'] ?? [];
    $this->phrases = $templates['phrases'] ?? [];
    $this->titles = $templates['titles'] ?? [];
    $this->labels = $templates['labels'] ?? [];

    $this->sentencer = $sentencer;
  }

  /**
   * Template parser.
   *
   * Parses input json file and converts it to associative array.
   *
   * @return array
   *    Parsed array.
   *
   * @throws \JsonException
   */
  private function templateParser(): array {
    if (file_exists(self::TEMPLATE_INPUT_FILE) && $file = file_get_contents(self::TEMPLATE_INPUT_FILE)) {
      $templates = json_decode($file, TRUE, 512, JSON_THROW_ON_ERROR);
    }

    return $templates ?? [];
  }


  /**
   * Return random sentence template.
   *
   * @return string
   *   Random template from the list of sentence templates or empty string.
   */
  public function randomTemplate(): string {
    return $this->templates[array_rand($this->templates)] ?? '';
  }

  /**
   *
   * @param string|NULL $input_template
   *
   * @return string
   */
  public function parseTemplate(string $input_template = NULL): string {
    $template = $input_template ?? $this->randomTemplate();
    $tags = [];

    $occurrences = preg_match_all('/{{(.+?)}}/', $template, $tags);

    if ($occurrences > 0) {
      $replacements = $tags[0];
      $actions = array_map('trim', $tags[1]);

      foreach ($actions as $key => $action) {
        if ($action && in_array($action, $this->sentencer::ALLOWED_ACTIONS, TRUE)) {
          $word = $this->sentencer->$action();

            $template = preg_replace('/' . $replacements[$key] . '/', $word, $template, 1);
        }
      }
    }

    return $template;
  }

  /**
   * {@inheritDoc}
   */
  public function generateSentence(int $number = 1): string {
    $output = '';

    if ($number > self::MAX_SENTENCES) {
      $number = self::MAX_SENTENCES;
    }

    for ($i = 1; $i <= $number; $i++) {
      $output .= ' ' . ucfirst($this->randomPhrase() . $this->parseTemplate()) . '.';
    }

    return $output;
  }

  /**
   * Randomly selects phrase, in 33% of cases.
   *
   * @throws \Exception
   */
  private function randomPhrase(): string {
    $phrase = '';

    if (random_int(1, 100) > 66) {
      $phrase = $this->phrases[array_rand($this->phrases)];
    }

    return $phrase;
  }

  /**
   * {@inheritDoc}
   */
  public function generateTitle(): string {
    $title_template = $this->titles[array_rand($this->titles)];

    return ucfirst($this->parseTemplate($title_template));
  }

  /**
   * {@inheritDoc}
   */
  public function generateShortLabel(): string {
    $label_template = $this->labels[array_rand($this->labels)];

    return ucfirst($this->parseTemplate($label_template));
  }

}