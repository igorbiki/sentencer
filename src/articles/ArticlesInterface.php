<?php

namespace Sentencer\articles;

/**
 * Interface to articilize input and return a|an prepended.
 */
interface ArticlesInterface {
  /**
   * Appends article before provided word(s).
   *
   * @param string $words
   *   Word(s) without article.
   *
   * @return string
   *   Word(s) with articles appended.
   */
  public function articlize(string $words): string;

}