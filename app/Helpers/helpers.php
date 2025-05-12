<?php

if (!function_exists('getYouTubeId')) {
    function getYouTubeId($url)
    {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
        return $matches[1] ?? null;
    }
}

if (!function_exists('educationLevelTranslated')) {
    function educationLevelTranslated($level)
    {
        $translations = [
            'secondary' => 'Среднее',
            'bachelor' => 'Бакалавр',
            'master' => 'Магистр',
            'phd' => 'Кандидат наук',
            'doctor' => 'Доктор наук',
        ];
        
        return $translations[$level] ?? $level;
    }
}