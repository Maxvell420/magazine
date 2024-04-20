<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Services\PageService;
use App\Services\TechnoparkParserService;

class ParserController
{
    public function __construct(private PageService $pageService)
    {
    }

    public function parse()
    {
        $root = 'https://spb.technopark.ru/';
        $parser = new TechnoparkParserService($this->pageService,$root);
        $model = new Link();
        $parser->getContent($model);
    }
}
