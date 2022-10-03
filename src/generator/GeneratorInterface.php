<?php

namespace Sentencer\generator;

interface GeneratorInterface {

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
}