<?php

namespace App\View\Components;

use App\Models\Language;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $lang = App::getLocale();
        $url = URL::current();
        $routes = [];
        $languages = Language::query()->where('name','!=',$lang)->get();
        $routes[$lang]= $url;
        foreach ($languages as $language){
            $routes[$language->name]=$this->replaceRoute( $url, $language->name);
        }
        return view('components.header', compact(['routes']));
    }
    private function replaceRoute(string $route,string $prefix)
    {
        $lang = App::getLocale();
        $root = \route('root');
        return preg_replace('#'.$root.'/'.$lang.'/*'.'#',$root.'/'.$prefix.'/', $route);
    }
}
