<?php
/**
 * Created by PhpStorm.
 * User: markus
 * Date: 21.08.15
 * Time: 13:59
 */

namespace helpers;

/**
 * Rein-statische Klasse als Helper beim Parsen/Evaluieren des Views
 */
abstract class HTMLHelper {

    /**
     * Wandelt eine gegebenes assoziatives Array in eine Tabelle um
     */
    public static function assocArrayToTable(array $assocArray, array $fields_to_show = array(), array $captions_header = array(), array $attributes_exempt_htmlspecialchars = array(), $table_id = "table", $table_class = "table") {
        if(count($assocArray) == 0 || count($assocArray[0]) == 0) return;

        $output_buffer = "";

        $attributes = array_keys($assocArray[0]);

        $output_buffer.= '<table id="'.$table_id.'" class="'.$table_class.'">'."\n";

        //Table Head
        $output_buffer.= "\t".'<thead> <tr> ';
        foreach ($attributes as $attribute_el) {
            if(!in_array($attribute_el, $fields_to_show) && !empty($fields_to_show)) continue;
            if(!empty($captions_header))  $attribute_el = @$captions_header[$attribute_el];
            $output_buffer.= '<th>'.$attribute_el.'</th>';
        }
        $output_buffer.=' </tr> </thead> <tbody>'."\n";

        //Table Body
        foreach ($assocArray as $row) {
            $output_buffer.="\t".'<tr> ';
            foreach ($row as $descriptor => $field) {
                if(!in_array($descriptor, $fields_to_show) && !empty($fields_to_show)) continue;
                $output_buffer.='<td key="'.$descriptor.'">'.(in_array($descriptor, $attributes_exempt_htmlspecialchars)?$field:htmlspecialchars($field)).'</td>';
            }
            $output_buffer.=' </tr>'."\n";
        }

        $output_buffer.="    </tbody></table>\n";
        return $output_buffer;

    }


    public static function linkCss($path) {
        $output_buffer = "";
        $output_buffer.= '<link href="'.$path.'" rel="stylesheet">';
        return $output_buffer;

    }

    public static function scriptJS($path) {
        $output_buffer = '<script src="'.$path.'"></script>';

        return $output_buffer;

    }

    public static function link($href, $title, array $attributes = array())
    {
        $attributes_html = " ";

        if (!empty($attributes)) {
            foreach ($attributes as $key => $val) {
                $attributes_html .= $key . '=' . '"' . $val . '" ';
            }
        }

        return '<a href="' . $href . '"' . $attributes_html . '>' . $title . '</a>';
    }

    public static function li($content, array $attributes = array()) {

        $attributes_html = " ";
        if (!empty($attributes)) {
            foreach ($attributes as $key => $val) {
                $attributes_html .= $key . '=' . '"' . $val . '" ';
            }
        }


        return "<li".$attributes_html.">".$content."</li>";
    }

    public static function ul($content, array $attributes = array()) {
        $attributes_html = " ";
        if (!empty($attributes)) {
            foreach ($attributes as $key => $val) {
                $attributes_html .= $key . '=' . '"' . $val . '" ';
            }
        }

        return "<ul".$attributes_html.">".$content."</ul>";
    }


    public static function select(array $content, $name= "select", $class = "form-control", $value_selected = null) {
        $output = '<select class="'.$class.'" name="'.$name.'">'."\n\t\t\t\t";
        foreach($content as $el) {
            $output.= "\t".'<option'.($el["value"] == $value_selected?" selected":"").' value="'.$el["value"].'">'.htmlspecialchars($el["content"]).'</option>'."\n\t\t\t\t";
        }
        $output.='</select>'."\n";

        return $output;

    }


    public static function div($content, array $attributes = array()) {
        $attributes_html = " ";
        if (!empty($attributes)) {
            foreach ($attributes as $key => $val) {
                $attributes_html .= $key . '=' . '"' . $val . '" ';
            }
        }

        return "<div".$attributes_html.">".$content."</div>";
    }
}