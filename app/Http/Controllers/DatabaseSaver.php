<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use SplFileObject;

class DatabaseSaver extends Controller
{
    private array $tables = [
        'categories',
        'subcategories',
        'products',
        'images',
//        'deliveries',
        'roles',
        'users',
        'orders',
        'product_user',
        'languages',
        'language_product',
        'category_language',
        'language_subcategory',
        'storages'];
    public function saveDatabase()
    {
        $filepath = 'records/records.txt';
        file_put_contents($filepath,'');
        $tables = $this->tables;
        foreach ($tables as $table){
            $this->saveRecords($table,$filepath);
        }
    }
    public function saveRecords(string $table,$filepath)
    {
        $records = DB::table($table)->get()->toArray();
        $log = [$table=>$records];
        $json = json_encode($log);
        $this->log($json,$filepath);
    }
    protected function log(string $text = 'oops, something went wrong', string $path = 'log.txt'): bool|int
    {
        return file_put_contents($path,$text.PHP_EOL,FILE_APPEND);
    }
    public function uploadRecordsFromFile()
    {
        $path = 'records/records.txt';
        $file = new SplFileObject($path);
        foreach ($file as $row){
            if ($row){
                $rowsArray = json_decode($row,true);
                foreach ($rowsArray as $table => $records){
                    foreach ($records as $record){
                        DB::table($table)->insert($record);
                    }
                }
            }
        }
    }
}
