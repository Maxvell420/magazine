<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Collection;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class WordService
{
    private PhpWord $sample;
    private Order $order;
    private Collection $products;
    public function __construct(string $samplePath,Collection $products, Order $order)
    {
        $this->products=$products;
        $this->setSample($samplePath);
        $this->order=$order;
    }
    public function createWordDocument()
    {
        $order = $this->order;
        $currentDate = date("Y-m-d");
        $filePath = "orders/$currentDate/";

        $this->createDir($filePath);

        $order->update(['filepath'=>$filePath,'filename'=>$order->id.'.docx']);

        $elements = $this->getElements($this->sample);
        $this->setOrderName($elements[1],$this->order);
        $this->addRowsToTable($elements[2],$this->products,$order);
        $this->sample->save($filePath.'/'.$order->id.'.docx');
    }
    private function createDir(string $path)
    {
        $fileService = new FileService();
        $fileService->createDir($path);
    }
    private function setSample(string $path)
    {
        $this->sample=IOFactory::load($path);
    }
    private function setOrderName(TextRun $element,Order $order)
    {
        $element->addText($order->id);
    }
    private function addRowsToTable(Table $table, Collection $products, Order $order)
    {
        $totalQuantity = 0;
        // Создаем строки таблицы и добавляем данные
        foreach ($products as $product) {
            $row = $table->addRow();
            $row->addCell(5000,['borderSize' => 6])->addText($product->name);
            $row->addCell(2000)->addText($product->total_quantity);
            $row->addCell(2000)->addText($product->total_price);
            $totalQuantity += $product->total_quantity;
        }

        // Добавляем информацию о доставке, если есть
        if ($order->delivery_id > 0) {
            $deliveryRow = $table->addRow();
            $deliveryRow->addCell(5000)->addText('Доставка');
            $deliveryRow->addCell(2000)->addText(1);
            $deliveryRow->addCell(2000)->addText($order->delivery->price);
        }
        // Добавляем строку с итогами
        $totalRow = $table->addRow();
        $totalRow->addCell(5000)->addText("Итого:");
        $totalRow->addCell(2000)->addText($totalQuantity+1);
        $totalRow->addCell(2000)->addText($order->price);
        foreach ($table->getRows() as $row) {
            foreach ($row->getCells() as $cell) {
                $cell->getStyle()->setBorderLeftSize(6);
                $cell->getStyle()->setBorderRightSize(6);
                $cell->getStyle()->setBorderTopSize(6);
                $cell->getStyle()->setBorderBottomSize(6);
            }
        }
    }

    private function getElements(PhpWord $document): array
    {
        $sections = $this->sample->getSections();

        $documentElements = [];

        foreach ($sections as $section) {
            $documentElements = $section->getElements();
        }
        return $documentElements;
    }
}
