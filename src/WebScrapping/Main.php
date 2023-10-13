<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Classes\Paper;
use Chuva\Php\WebScrapping\Classes\PregReplace;
use Exception;
use Throwable;
use DOMDocument;;

use Chuva\Php\WebScrapping\Library\SpoutLibrary;

/**
 * Runner for the Webscrapping exercice.
 */
class Main
{

    private static string $version = '1.0';
    private static string $encoding = 'utf-8';
    /**
     * Main runner, instantiates a Scrapper and runs.
     */
    public static function run(): void
    {

        try {

            $domInstance = new DOMDocument(self::$version, self::$encoding);

            if (!file_exists(assets_path . "/origin.html")) {
                throw new Exception("This file doesn't exist.", 1);
            }

            $domInstance->loadHTMLFile(assets_path . "/origin.html");
            $xpath = new \DOMXPath($domInstance);

            $paperCards = $xpath->query("//*[contains(@class, 'paper-card')]");

            if ($paperCards->length > 0) {

                $largestAuthorsQuantity = [];

                foreach ($paperCards as $key => $paperCard) {

                    $indexValidForGetInstituion = 1;

                    $id = PregReplace::onlyNumbers($paperCard->lastChild->textContent);
                    $title = PregReplace::removeSpace($paperCard->firstChild->textContent);
                    $type = PregReplace::removeSpace(PregReplace::onlyWords($paperCard->lastChild->textContent));
                    $divAuthors = $paperCard->childNodes->item(2);
                    $authors = explode(";", $divAuthors->textContent);

                    array_pop($authors);

                    array_push($largestAuthorsQuantity, count($authors));

                    $data[$key] = [
                        $id, $title, $type
                    ];

                    for ($index = 0 ; $index < count($authors) ; $index ++ ) { 
                        
                        array_push($data[$key], PregReplace::removeSpace($authors[$index]), $divAuthors->childNodes->item($indexValidForGetInstituion)->getAttribute('title'));

                        $indexValidForGetInstituion += 2;
                    }
                }

                Paper::$largestAuthorsQuantity = max($largestAuthorsQuantity);
            }

            SpoutLibrary::createSpeadSheet($data); 

        } catch (Throwable $th) {
            throw new Exception("{$th->getMessage()} in line: {$th->getLine()}", 1);
        }
    }
}
