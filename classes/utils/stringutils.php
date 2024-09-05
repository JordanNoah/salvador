<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * String utils
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta\utils;

/**
 * This class is used to operate with strings
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class StringUtils {
    /**
     * Truncate a string to a given length
     *
     * @param string $string
     * @param int $maxLength
     */
    public static function truncateHtmlText($htmlContent, $maxLength = 300) {
        $truncated = '';
        $length = 0;
        $openTags = [];
        
        // Dividir el contenido en partes de etiquetas y texto
        $parts = preg_split('/(<[^>]*>)/', $htmlContent, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    
        foreach ($parts as $part) {
            if ($part[0] == '<') {
                // Manejar inicio/final de etiquetas
                if ($part[1] != '/' && substr($part, -2) != '/>') {
                    // Etiqueta de inicio
                    preg_match('/<(\w+)/', $part, $matches);
                    $openTags[] = $matches[1];
                } elseif (strpos($part, '</') === 0) {
                    // Etiqueta de cierre
                    array_pop($openTags);
                }
                $truncated .= $part;
            } else {
                $neededLength = $maxLength - $length;
                $partLength = mb_strlen($part);
    
                if ($length + $partLength > $maxLength) {
                    // Si la parte excede la longitud máxima, encontrar el último espacio
                    $endPosition = mb_strrpos(mb_substr($part, 0, $neededLength), ' ');
                    if ($endPosition !== false) {
                        $truncated .= mb_substr($part, 0, $endPosition) . '...';
                    } else {
                        // Si no hay espacio, añadir puntos suspensivos directamente
                        $truncated .= mb_substr($part, 0, $neededLength) . '...';
                    }
                    break;
                } else {
                    $truncated .= $part;
                    $length += $partLength;
                }
            }
        }
    
        // Cerrar cualquier etiqueta HTML abierta
        while (!empty($openTags)) {
            $truncated .= '</' . array_pop($openTags) . '>';
        }

        // Eliminar cualquier parrafo vacío
        $truncated = preg_replace('/<p[^>]*><\\/p[^>]*>/', '', $truncated); //! Consultar
    
        return $truncated;
    }
}
