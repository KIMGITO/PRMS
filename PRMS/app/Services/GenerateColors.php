<?php

namespace App\Services;

class GenerateColors{

    public function getVisualization($data)
    {
        $colorNames = $data;

        $colorArrays = [
            ['#FF0000', '#CD5C5C', '#FF6347', '#DC143C', '#FF4500', '#8B0000', '#800000', '#B22222'],
            ['#0000FF', '#4682B4', '#1E90FF', '#6495ED', '#87CEEB', '#00BFFF', '#4169E1', '#000080'],
            ['#008000', '#3CB371', '#2E8B57', '#20B2AA', '#32CD32', '#008080', '#00FF00', '#7FFF00'],
            ['#FFFF00', '#FFD700', '#FFA500', '#FF8C00', '#FF7F50', '#FF6347', '#FF4500', '#FF0000'],
            ['#FFA500', '#FF8C00', '#FF7F50', '#FF6347', '#FF4500', '#FF0000', '#FF69B4', '#FF1493'],
            ['#800080', '#9932CC', '#8A2BE2', '#9370DB', '#6A5ACD', '#483D8B', '#4B0082', '#BA55D3'],
            ['#FFC0CB', '#FFB6C1', '#FF69B4', '#FF1493', '#DB7093', '#FFC0CB', '#FFB6C1', '#FF69B4'],
            ['#A52A2A', '#8B4513', '#CD853F', '#D2691E', '#DEB887', '#F4A460', '#D2B48C', '#BC8F8F'],
            ['#808080', '#A9A9A9', '#D3D3D3', '#696969', '#708090', '#778899', '#2F4F4F', '#000000'],
            ['#00FFFF', '#00FFFF', '#E0FFFF', '#AFEEEE', '#7FFFD4', '#B0E0E6', '#5F9EA0', '#4682B4'],
            ['#FF00FF', '#FF00FF', '#8A2BE2', '#9370DB', '#6A5ACD', '#483D8B', '#4B0082', '#BA55D3'],
            ['#008080', '#008080', '#008B8B', '#00CED1', '#20B2AA', '#5F9EA0', '#4682B4', '#6495ED'],
            ['#E6E6FA', '#D8BFD8', '#DDA0DD', '#EE82EE', '#DA70D6', '#FF00FF', '#FF00FF', '#8A2BE2'],
            ['#800000', '#8B0000', '#800000', '#8B0000', '#800000', '#8B0000', '#800000', '#8B0000'],
            ['#FFD700', '#FFD700', '#FFD700', '#FFD700', '#FFD700', '#FFD700', '#FFD700', '#FFD700'],
            ['#C0C0C0', '#C0C0C0', '#C0C0C0', '#C0C0C0', '#C0C0C0', '#C0C0C0', '#C0C0C0', '#C0C0C0'],
            ['#40E0D0', '#00CED1', '#20B2AA', '#5F9EA0', '#008B8B', '#008080', '#00FFFF', '#00FFFF'],
            ['#4B0082', '#8A2BE2', '#9370DB', '#6A5ACD', '#483D8B', '#4B0082', '#8A2BE2', '#9370DB'],

        ];

        $selectedColors = [];

        foreach ($colorNames as $index => $colorName) {
            $colorArray = $colorArrays[$index] ?? [];

            shuffle($colorArray);
            $randomColor = array_pop($colorArray);
            $selectedColors[] = $randomColor;
        }
        return $selectedColors;
    }
}