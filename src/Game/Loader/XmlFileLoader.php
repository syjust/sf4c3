<?php

namespace App\Game\Loader;

class XmlFileLoader implements LoaderInterface
{
    /**
     * @inheritdoc
     */
    public function load(string $dictionary): array
    {
        $words = [];
        $xml = new \SimpleXmlElement(file_get_contents($dictionary));
        foreach ($xml->word as $word) {
            $words[] = (string) $word;
        }

        return $words;
    }

    public function getType(): string
    {
        return 'xml';
    }
}
