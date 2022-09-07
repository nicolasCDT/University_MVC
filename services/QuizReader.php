<?php

namespace App\Service;

require_once("../core/AbstractService.php");

use App\Models\entities\AbstractService;
use SimpleXMLElement;

class QuizReader extends AbstractService
{
    private string $path;
    private array $content;

    public function __construct() {
        $this->path = "";
        $this->content = [];
    }

    public function setPath(string $path): QuizReader {
        $this->path = "assets/mqc/".$path;
        return $this;
    }

    public function getContent(): array {
        return $this->content;
    }

    public function load(): void {
        if(!file_exists($this->path))
            throw new \Exception("XML not found: ".$this->path);
        $this->content = $this->xmlToArray(
            simplexml_load_file($this->path)
        );
    }

    /**
     * Parse an XML element into an array
     * @param SimpleXMLElement $xml XML element (load with simplexml_load_file for example)
     * @return array[] xml parsed
     *
     * @author CameronXie : https://www.php.net/manual/fr/class.simplexmlelement.php#122006
     */
    private function xmlToArray(SimpleXMLElement $xml): array
    {
        $parser = function (SimpleXMLElement $xml, array $collection = []) use (&$parser) {
            $nodes = $xml->children();
            $attributes = $xml->attributes();

            if (0 !== count($attributes)) {
                foreach ($attributes as $attrName => $attrValue) {
                    $collection['attributes'][$attrName] = strval($attrValue);
                }
            }

            if (0 === $nodes->count()) {
                $collection['value'] = strval($xml);
                return $collection;
            }

            foreach ($nodes as $nodeName => $nodeValue) {
                if (count($nodeValue->xpath('../' . $nodeName)) < 2) {
                    $collection[$nodeName] = $parser($nodeValue);
                    continue;
                }

                $collection[$nodeName][] = $parser($nodeValue);
            }

            return $collection;
        };

        return [
            $xml->getName() => $parser($xml)
        ];
    }

}