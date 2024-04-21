<?php

namespace App\Services;

class GenerateColors{

    public function getVisualization($data)
{
   $colorArrays = [
    ['#FF0000', '#00FF00', '#0000FF', '#FFA500', '#800080', '#FF00FF', '#8A2BE2', '#483D8B'],
    ['#CD5C5C', '#3CB371', '#4682B4', '#9932CC', '#8A2BE2', '#00CED1', '#FF8C00', '#9370DB'],
    ['#FF6347', '#2E8B57', '#1E90FF', '#FF7F50', '#8A2BE2', '#9370DB', '#20B2AA', '#FFA500'],
    ['#DC143C', '#20B2AA', '#6495ED', '#FF6347', '#9370DB', '#FF8C00', '#6A5ACD', '#5F9EA0'],
    ['#FF4500', '#32CD32', '#87CEEB', '#483D8B', '#6A5ACD', '#FF7F50', '#483D8B', '#008B8B'],
    ['#8B0000', '#008080', '#00BFFF', '#FF6347', '#4B0082', '#008080', '#8A2BE2', '#483D8B'],
    ['#800000', '#00FF00', '#4169E1', '#FF4500', '#8A2BE2', '#FF6347', '#FF69B4', '#4B0082'],
    ['#B22222', '#7FFF00', '#000080', '#FF0000', '#9370DB', '#FF6347', '#FF1493', '#9370DB'],
    ['#FF1493', '#BA55D3', '#800080', '#808000', '#008080', '#008000', '#00FF00', '#0000FF'],
    ['#FF00FF', '#FF6347', '#FF4500', '#FF0000', '#00FFFF', '#00FF00', '#00BFFF', '#0000FF'],
    ['#FFD700', '#FFA500', '#FF6347', '#FF4500', '#FF0000', '#FF1493', '#FF00FF', '#FF00FF'],
    ['#8A2BE2', '#9370DB', '#6A5ACD', '#483D8B', '#4B0082', '#8A2BE2', '#9370DB', '#6A5ACD'],
    ['#008080', '#008080', '#008B8B', '#00CED1', '#20B2AA', '#5F9EA0', '#4682B4', '#6495ED'],
    ['#E6E6FA', '#D8BFD8', '#DDA0DD', '#EE82EE', '#DA70D6', '#FF00FF', '#FF00FF', '#8A2BE2'],
    ['#800000', '#8B0000', '#800000', '#8B0000', '#800000', '#8B0000', '#800000', '#8B0000'],
    ['#FFD700', '#FFD700', '#FFD700', '#FFD700', '#FFD700', '#FFD700', '#FFD700', '#FFD700'],
    ['#C0C0C0', '#C0C0C0', '#C0C0C0', '#C0C0C0', '#C0C0C0', '#C0C0C0', '#C0C0C0', '#C0C0C0'],
    ['#40E0D0', '#00CED1', '#20B2AA', '#5F9EA0', '#008B8B', '#008080', '#00FFFF', '#00FFFF'],
    ['#4B0082', '#8A2BE2', '#9370DB', '#6A5ACD', '#483D8B', '#4B0082', '#8A2BE2', '#9370DB'],
];

    $selectedColors = [];

    foreach ($data as $index => $colorName) {
        $colorArray = $colorArrays[$index] ?? [];

        // Shuffle the color array to get a random order
        shuffle($colorArray);

        // Pop the last color from the shuffled array
        $randomColor = array_pop($colorArray);

        // Add the random color to the selected colors array
        $selectedColors[] = $randomColor;
       
    }
    return $selectedColors;
}
}