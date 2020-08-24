<?php

return [

    /**
     * You may want this to be something other than a colon
     */
    'namespaceSeparator' => '_',

    /**
     * To distinguish between attributes and nodes with the same name
     */
    'attributePrefix' => '',

    /**
     * Array of xml tag names which should always become arrays
     */
    'alwaysArray' => [],

    /**
     * Only create arrays for tags which appear more than once
     */
    'autoArray' => true,        

    /**
     * Key used for the text content of elements
     */
    'textContent' => '$',

    /**
     * Skip textContent key if node has no attributes or child nodes
     */
    'autoText' => true,

    /**
     * Optional search and replace on tag and attribute names
     */
    'keySearch' => false,

    /**
     * Replace values for above search values (as passed to str_replace())
     */
    'keyReplace' => false,       
    
    /**
     * Add prefix namespace in attribute
     */
    'addPrefix' => false,

    /**
     * Namespaces
     */
    'namespaces' => [
        ''          => null,
    ],
];