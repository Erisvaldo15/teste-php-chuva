<?php

namespace Chuva\Php\WebScrapping\Library;

use Exception;
use Chuva\Php\WebScrapping\Classes\Paper;
use OpenSpout\Writer\Common\Creator\Style\StyleBuilder;
use OpenSpout\Writer\Common\Creator\WriterEntityFactory;

class SpoutLibrary
{

    private static array $headerCells = [
        "id", "title", "type",
    ];

    public static function createSpeadSheet(array $data)
    {

        if($data) {

            for ($quantity = 1; $quantity <= Paper::$largestAuthorsQuantity; $quantity++) {
                array_push(self::$headerCells, "author {$quantity}", "author {$quantity} instituition");
            }
    
            $writer = WriterEntityFactory::createXLSXWriter();
    
            $writer->openToFile(assets_path . "/index.xlsx");
    
            $header = WriterEntityFactory::createRow(array_map(function ($cell) {
                return WriterEntityFactory::createCell(ucwords($cell));
            }, self::$headerCells), (new StyleBuilder())->setFontName('Arial')->setFontBold()->setFontSize(11)->build());
    
            $writer->addRow($header);
    
            foreach ($data as $rowWithValue) {
    
                $cells = [];
    
                for ($i = 0; $i < count($rowWithValue); $i++) {
                    $cells[] = WriterEntityFactory::createCell($rowWithValue[$i]);
                }
    
                $row = WriterEntityFactory::createRow($cells, (new StyleBuilder())->setFontName('Arial')->setFontSize(11)->build());
                $writer->addRow($row);
            }
    
            $writer->close();

            return;
        }

        throw new Exception("Data Variable Empty", 1);
    }
}
