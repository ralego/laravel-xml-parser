<?php

namespace Ralego\Parser\Traits;

trait XmlParser
{
    public function xmlToJson($contents)
    {
        $xmlNode = @simplexml_load_string($contents);
        $arrayData = $this->xmlToArray($xmlNode);
        return json_encode($arrayData);
    }

    public function xmlToObject($contents)
    {
        $json = $this->xmlToJson($contents);
        return json_decode($json);
    }

    public function xmlToArray($xml, $options = array())
    {
        if (is_string($xml)) $xml = @simplexml_load_string($xml);
        $options = array_merge(config('xmlparser'), $options);
        $namespaces = $xml->getDocNamespaces();
        $namespaces = array_merge(config('xmlparser.namespaces'), $namespaces);
        //get attributes from all namespaces
        $attributesArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
                //replace characters in attribute name
                if ($options['keySearch'])
                    $attributeName = str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
                $attributeKey = $options['attributePrefix'] . ($prefix ? $prefix . $options['namespaceSeparator'] : '') . $attributeName;
                $attributesArray[$attributeKey] = (string)$attribute;
            }
        }
        //get child nodes from all namespaces
        $tagsArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->children($namespace) as $childXml) {
                //recurse into child nodes
                $childArray = $this->xmlToArray($childXml, $options);
                list($childTagName, $childProperties) = @each($childArray);

                //replace characters in tag name
                if ($options['keySearch']) $childTagName =
                    str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
                //add namespace prefix, if any
                if ($options['addPrefix'])
                    if ($prefix) $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;
                    else
                    if ($prefix) $childTagName = $options['namespaceSeparator'] . $childTagName;

                if (!isset($tagsArray[$childTagName])) {
                    //only entry with this key
                    //test if tags of this type should always be arrays, no matter the element count
                    $tagsArray[$childTagName] =
                        in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
                        ? array($childProperties) : $childProperties;
                } elseif (
                    is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
                    === range(0, count($tagsArray[$childTagName]) - 1)
                ) {
                    //key already exists and is integer indexed array
                    $tagsArray[$childTagName][] = $childProperties;
                } else {
                    //key exists so convert to integer indexed array with previous value in position 0
                    $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
                }
            }
        }
        //get text content of node
        $textContentArray = array();
        $plainText = trim((string)$xml);
        if ($plainText !== '') $textContentArray[$options['textContent']] = $plainText;
        //stick it all together
        $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
            ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;
        //return node as array
        return array(
            $xml->getName() => $propertiesArray
        );
    }
}
