<?php

namespace App\Game;

use App\Game\Exception\Exception;
use function strtolower;

class Game
{
    const MAX_ATTEMPTS = 11;

    private $word;
    private $attempts;
    private $triedLetters;
    private $foundLetters;

    private function __construct(string $word, int $attempts = 0, array $triedLetters = [], array $foundLetters = [])
    {
        $this->word         = strtolower($word);
        $this->attempts     = $attempts;
        $this->triedLetters = $triedLetters;
        $this->foundLetters = $foundLetters;
    }

    public function getRemainingAttempts(): int
    {
        return static::MAX_ATTEMPTS - $this->attempts;
    }

    public function isLetterFound(string $letter): bool
    {
        return in_array(strtolower($letter), $this->foundLetters, true);
    }

    public function isHanged(): bool
    {
        return static::MAX_ATTEMPTS === $this->attempts;
    }

    public function isOver(): bool
    {
        return $this->isWon() || $this->isHanged();
    }

    public function isWon(): bool
    {
        $diff = array_diff($this->getWordLetters(), $this->foundLetters);

        return 0 === count($diff);
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getWordLetters(): array
    {
        return str_split($this->word);
    }

    public function getAttempts(): int
    {
        return $this->attempts;
    }

    public function getTriedLetters(): array
    {
        return $this->triedLetters;
    }

    public function getFoundLetters(): array
    {
        return $this->foundLetters;
    }

    public function reset(): void
    {
        $this->attempts     = 0;
        $this->triedLetters = [];
        $this->foundLetters = [];
    }

    public function tryWord(string $word): bool
    {
        if (strtolower($word) === $this->word) {
            $this->foundLetters = array_unique($this->getWordLetters());

            return true;
        }

        $this->attempts = self::MAX_ATTEMPTS;

        return false;
    }

    public function tryLetter(string $letter): bool
    {
        $letter = strtolower($letter);

        if (0 === preg_match('/^[a-z]$/', $letter)) {
            throw new Exception(sprintf('The letter "%s" is not a valid ASCII character matching [a-z].', $letter));
        }

        if (in_array($letter, $this->triedLetters, true)) {
            ++$this->attempts;

            return false;
        }

        if (false !== strpos($this->word, $letter)) {
            $this->foundLetters[] = $letter;
            $this->triedLetters[] = $letter;

            return true;
        }

        $this->triedLetters[] = $letter;
        ++$this->attempts;

        return false;
    }

    public static function createByWord(string $word): self
    {
        return new static($word);
    }
}
