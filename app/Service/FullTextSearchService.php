<?php

namespace App\Service;

use Transliterator;

class FullTextSearchService
{
    private $transliterator;

    public function __construct()
    {
        $this->transliterator = Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC;');
    }

    public function prepareSearchingWords($search)
    {
        $searchingWords = array_map(function ($word) {
            return $this->fullTextExpression($word);
        }, preg_split("/\s|,/", $search));
        $searchingWords = array_filter($searchingWords);

        return implode(' ', $searchingWords);
    }

    private function fullTextExpression(string $word): ?string
    {
        $word = addslashes(mb_strtolower($this->transliterator->transliterate($word)));
        if (false === empty($word)) {
            if (1 === preg_match('/[+\-~*]/', $word)) {
                return '+"' . $word . '" ';
            } else if (strpos($word, "'")) {
                return '+(' . $word . '*) ';
            } else {
                return '+' . $word . '* ';
            }
        }

        return null;
    }
}
