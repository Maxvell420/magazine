<?php

namespace App\Services;

use CurlHandle;
use DiDom\Document;
use Illuminate\Database\Eloquent\Model;

abstract class ParserService
{
    protected string $root;
    protected string $target;
    public function __construct(string $root)
    {
        if (str_ends_with($root,'/')){
            $root = preg_replace('#/$#','',$root);
        }
        $this->root=$root;
    }
    /*
     * Убрал опции Curl в отдельный метод
     */
    public function getPage(string $url, array $options):string
    {
        $this->target =$url;
        $curl = curl_init($url);
        foreach ($options as $option => $value){
            $this->setCurlOptions($curl,$option,$value);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Cookie: pageviewTimer=231.075; pageviewTimerFired15=true; pageviewTimerFired30=true; pageviewTimerFired60=true; qrator_jsr=1713603628.862.uWlq6PUdQKRRs590-efvojs601pa9ecnc3g5rvjtlav1fad84-00; _ga_RD4H4CBNJ3=GS1.1.1713603133.3.1.1713603628.60.0.0; _ga_010M8X07NE=GS1.1.1713603142.1.1.1713603628.60.0.0; qrator_jsid=1713603628.862.uWlq6PUdQKRRs590-one0rlkb7hbrnagn9rvlsl1qdsd8tb9t']);
        $page = curl_exec($curl);
//        file_put_contents('text.txt',$page);
//        die();
        $status = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        if ($status === 404 or $status==410){
            sleep(2);
            $this->setCurlOptions($curl,'ajax',['X-Requested-With: XMLHttpRequest']);
            $page = curl_exec($curl);
        }
        curl_close($curl);
        return $page;
    }
    protected function setCurlOptions(CurlHandle $curl, string $option, array|int $value):bool
    {
        $options =
            ['post'=>CURLOPT_POST,
                'postfields'=>CURLOPT_POSTFIELDS,
                'redirects'=>CURLOPT_FOLLOWLOCATION,
                'headers'=>CURLOPT_HEADER,
                'setHeaders'=>CURLOPT_HTTPHEADER,
                'variable'=>CURLOPT_RETURNTRANSFER,
                'ajax'=>CURLOPT_HTTPHEADER,
                'cookies'=>CURLOPT_HEADER];
        if (isset($options[$option])){
            return curl_setopt($curl,$options[$option],$value);
        } return false;
    }
    protected function convertToUTF8(string $from_encoding, string $page): bool|string
    {
        return iconv($from_encoding,'utf-8',$page);
    }
    protected function log(string $text = 'oops, something went wrong', string $path = 'log.txt'): bool|int
    {
        return file_put_contents($path,$text.PHP_EOL,FILE_APPEND);
    }
    /*
     * Метод помощник возвращает false если ссылка на другой сайт
     */
    protected function siteCheck(string $site, string $to_compare):bool
    {
        if (str_starts_with($site,$to_compare)){
            $pattern =  '~^'.$site.'~';
            if (preg_match(preg_quote($pattern,'/'),$to_compare)) {
                return true;
            } return false;
        }
        return true;
    }
    /*
     * Добавил этот метод т.к. некоторые ссылки на сайте были http вместо https
     */
    protected function href_ssl_check(string $href): array|string|null
    {
        $root = $this->root;
        if(str_starts_with($href,'http:') and str_starts_with($root,'https:')){
            $href = preg_replace('#http#','https',$href);
        }
        return $href;
    }
    protected function getCookie(string $path = 'cookies.txt'):array
    {
        $cookies = [];
        $file = fopen($_SERVER["DOCUMENT_ROOT"].'/'.$path,'r');
        while (($line = fgets($file)) !== false){
            $cookies[]='Cookie: '.trim($line);
        }
        fclose($file);
        return $cookies;
    }
    protected function normalize(string $path):string
    {
        $root = $this->root;
        $target = $this->target;
        $path=$this->href_ssl_check($path);
        if (str_starts_with($path,'https://') or  str_starts_with($path,'http://') ){
            return $path;
        }
        if (str_starts_with($path,'//')){
            $replacement = preg_replace('#https*://#','',$root);
            $url = preg_replace('#//'.$replacement.'#','',$path);
            return $root.$url;
        }
        if (str_starts_with($path,'/')){
            return $root.$path;
        }
//        не уверен насчет этой части с ?
        if (str_starts_with($path,'?')){
            $replacement=preg_replace('#(&.+|\?.+)$#','',$target);
            return $replacement.$path;
        }
        if(str_starts_with($path,'../')) {
            $pattern = "#\.\./#";
            preg_match_all($pattern, $path, $matches);
            $counter = count($matches[0]);
            $limit = strlen($root);
            $change = preg_replace('#(\.\./){'.$counter.'}#','',$path);
            $pattern = "#([^/]+/){".$counter."}$#";
            $newUrl = preg_replace($pattern,'',$target);
            if (strlen($newUrl)<=$limit){
                return $root.'/'.$change;
            }
            return $newUrl.$change;
        }
        if (str_starts_with($path,'./')){
            $path = mb_substr($path,2);
        }
        $pattern = '#.+$#';
        preg_match($pattern,$path,$matches);
        return $target.$matches[0];
    }
    protected function getLinks($elements):array
    {
        $links = [];
        foreach ($elements as $element){
            $href = $element->getAttribute('href');
            $links[]=$this->normalize($href);
        }
        return $links;
    }
    protected function getSrcs($elements)
    {
        $links = [];
        foreach ($elements as $element){
            $href = $element->getAttribute('src');
            $links[]=$this->normalize($href);
        }
        return $links;
    }
    protected function saveLinks(array $links, Model $model)
    {
        foreach ($links as $link){
            $model::query()->firstOrCreate(['url'=>$link],['url'=>$link]);
        }
    }
    protected function getImgName(string $src): string
    {
        $pattern = '#[^/]+$#';
        preg_match($pattern,$src,$matches);
        return $matches[0];
    }
    abstract function saveCookies(string $response);
    abstract public function getContent(Model $model);
}
