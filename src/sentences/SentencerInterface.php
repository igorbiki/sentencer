<?php

namespace Sentencer\sentences;

interface SentencerInterface {

  /**
   * Returns number of sentences, words, adjectives.
   *
   * @return array
   *   How many options there are to generate stuff.
   */
  public function configOverview(): array;

  /**
   * Return random noun.
   *
   * @return string
   *    Random noun.
   */
  public function noun(): string;

  /**
   * Returns noun with article.
   *
   * @param string|null $input
   *   Word to determine article for. If not sent, random one will be used.
   *
   * @return string
   *    Noun with article.
   */
  public function a_noun(string $input = NULL): string;

  /**
   * Plural form of noun.
   *
   * @param string|null $input
   *   Word to pluralize, if not sent, random will be used.
   *
   * @return string
   *    Pluralized noun.
   */
  public function nouns(string $input = NULL): string;

  /**
   * Returns adjective.
   *
   * @return string
   *    Random adjective.
   */
  public function adjective(): string;

  /**
   * Adjective with article.
   *
   * @param string|null $input
   *   Adjective to determine article for. If not sent, random will be used.
   *
   * @return string
   *   Adjective with article.
   */
  public function an_adjective(string $input = NULL): string;

}
