<?php

namespace App\Game\Loader;

interface LoaderInterface
{
    /**
     * Loads a words list data source.
     *
     * @param string $dictionary The absolute path to a dictionary file
     *
     * @return array The list of loaded words
     */
    public function load(string $dictionary): array;

    /**
     * Returns the supported type by loader.
     *
     * @return string
     */
    public function getType(): string;
}
