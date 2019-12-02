<?php

namespace App\Game;

use App\Game\Exception\RuntimeException;
use App\Game\Loader\LoaderInterface;

class WordList
{
    private $words = [];
    private $loaders = [];
    private $loaded = false;
    private $dictionaries;

    public function __construct(array $dictionaries)
    {
        $this->dictionaries = $dictionaries;
    }

    public function addLoader(LoaderInterface $loader): void
    {
        $this->loaders[strtolower($loader->getType())] = $loader;
        $this->loaded = false;
    }

    /**
     * Returns a word picked randomly from the loaded dictionaries.
     */
    public function getRandomWord(): string
    {
        $this->loadDictionaries();

        return $this->words[array_rand($this->words)];
    }

    /**
     * Adds a new word to the list.
     */
    public function addWord(string $word): void
    {
        if (!in_array($word, $this->words, true)) {
            $this->words[] = $word;
        }
    }

    private function loadDictionaries(): void
    {
        if ($this->loaded) {
            return;
        }

        foreach ($this->dictionaries as $dictionary) {
            $this->loadDictionary($dictionary);
        }

        $this->loaded = true;
    }

    private function findLoader(string $type): LoaderInterface
    {
        $key = strtolower($type);
        if (!isset($this->loaders[$key])) {
            throw new RuntimeException(sprintf('There is no loader able to load a %s dictionary.', $type));
        }

        return $this->loaders[$key];
    }

    private function loadDictionary(string $path): void
    {
        $loader = $this->findLoader(pathinfo($path, PATHINFO_EXTENSION));

        $words = $loader->load($path);
        foreach ($words as $word) {
            $this->addWord($word);
        }
    }
}
