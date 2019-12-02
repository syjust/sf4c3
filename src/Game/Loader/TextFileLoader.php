<?php

namespace App\Game\Loader;

class TextFileLoader implements LoaderInterface
{
    /**
     * @inheritdoc
     */
    public function load(string $dictionary): array
    {
        return array_map('trim', file($dictionary));
    }

    public function getType(): string
    {
        return 'txt';
    }
}
