<?php
declare(strict_types=1);

use League\Container\Container;
use Sentencer\articles\Articles;
use Sentencer\generator\SentenceGenerator;
use Sentencer\sentences\Sentencer;

require_once __DIR__ . '/vendor/autoload.php';

$container = new Container();

$container->add(SentenceGenerator::class)->addArgument(Sentencer::class)->addArgument(Articles::class);
$container->add(Sentencer::class)->addArgument(Articles::class);
$container->add(Articles::class);

/** @var \Sentencer\generator\SentenceGeneratorInterface $g */
$g = $container->get(SentenceGenerator::class);

print("Random sentence: " . PHP_EOL);
print($g->generateSentence());
print(PHP_EOL);
print("Random title: " . PHP_EOL);
print($g->generateTitle());
print(PHP_EOL);
print("Random short label: " . PHP_EOL);
print($g->generateShortLabel());
print(PHP_EOL);