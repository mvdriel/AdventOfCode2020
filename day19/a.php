<?php

$input = trim(file_get_contents('input'));

list($lines, $messages) = explode("\n\n", $input);

$lines = explode("\n", $lines);
$messages = explode("\n", $messages);

$rules = [];

foreach ($lines as $line) {
    $line = str_replace('"', '', $line);
    list($key, $rule) = explode(': ', $line);
    $rules[$key] = $rule;
}

function toRegex($key) {
    global $rules;

    if (!is_numeric($key)) {
        return $key;
    }

    $rule = $rules[$key];
    $regex  = '';
    $parts = explode(' ', $rule);
    foreach ($parts as $part) {
        $regex .= regex($part);        
    }
    
    return '(' . $regex . ')';
}

$regex = '/^' . toRegex(0) . '$/';

$count = array_sum(array_map(function($message) use ($regex) {
    return (int)preg_match($regex, $message);
}, $messages));

var_dump($count);