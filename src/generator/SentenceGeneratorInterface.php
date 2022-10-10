<?php

namespace Sentencer\generator;

/**
 * Listing required function that actual generate must implement.
 */
interface SentenceGeneratorInterface {

  /**
   * Randomly generates sentence.
   *
   * @param int $number
   *   Number of sentences to generate, max 20, default 1.
   *
   * @return string
   *   Generated sentence(s).
   */
  public function generateSentence(int $number = 1): string;

  /**
   * Randomly generates title.
   *
   * @return string
   *   Generated title.
   */
  public function generateTitle(): string;

  /**
   * Creates short string that can be used for title or cta label.
   *
   * @return string
   *    Short string, such as label.
   */
  public function generateShortLabel(): string;

}
