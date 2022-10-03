<?php

namespace Sentencer\articles;

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