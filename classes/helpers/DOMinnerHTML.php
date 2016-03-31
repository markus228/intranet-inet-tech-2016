<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 19.03.16
 * Time: 19:58
 */

namespace helpers;

use DOMNode;


class DOMHelper {

    /**
     * Gibt den inneren HTML-Code eines HTML-Nodes aus
     * @param DOMNode $element
     * @return string
     */
    public static function DOMinnerHTML(DOMNode $element)
    {
        $innerHTML = "";
        $children  = $element->childNodes;


        if (!$children instanceof \Traversable) return $innerHTML;
        foreach ($children as $child)
        {
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }

        return $innerHTML;
    }

}

