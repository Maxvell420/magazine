<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Services\NewParserService;
use App\Services\NodeService;
use App\Services\PageService;
use App\Services\TechnoparkParserService;

class ParserController
{
    public function __construct(private PageService $pageService)
    {
    }

    public function parse()
    {
//        $test = new NewParserService();
//        $test->testGetPageContent();

        $root = 'https://www.techport.ru/';
        $parser = new TechnoparkParserService($this->pageService,$root);
        $model = new Link();
        $parser->getContent($model);
    }
}
