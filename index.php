<?php

/**
 * Created by PhpStorm.
 * Filename: index.php
 * Project Name: synonyms-dictionary-uz
 * Author: Акбарали
 * Date: 26/08/2022
 * Time: 3:54 PM
 * Github: https://github.com/akbarali1
 * Telegram: @akbar_aka
 * E-mail: me@akbarali.uz
 */
class Core
{
    private const TXT_NAME        = 'uz_code.txt';
    private const JSON_NAME       = 'object.json';
    private const COMMA_JSON_NAME = 'comma_object.json';

    public function run(): void
    {
        $txtToArray = $this->readTxtToArray(self::TXT_NAME);
        $this->arraySaveJson($txtToArray, self::JSON_NAME);
        $comma = $this->arrayComma($txtToArray);
        $this->arraySaveJson($comma, self::COMMA_JSON_NAME);
        $this->printFile(self::JSON_NAME, self::COMMA_JSON_NAME);
    }

    public function printFile(...$inputs)
    {
        foreach ($inputs as $input) {
            echo __DIR__.$input.PHP_EOL;
            //            echo $input.' file: <a href="uz/'.$input.'" target="_blank">View</a><br>';
        }
    }

    private function readTxtToArray(string $file_name): array
    {
        $str = file_get_contents($file_name);

        return preg_split('/[\r\n]+/', $str, null, PREG_SPLIT_NO_EMPTY);
    }

    private function arraySaveJson(array $arr, string $json_name)
    {
        $dir = __DIR__."/uz/"; // Full Path
        if (!file_exists($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
            die('Failed to create directories...');
        }
        $arr         = array_filter($arr);
        $json_encode = json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        //Array filter
        file_put_contents($dir.$json_name, $json_encode);
    }

    private function arrayComma(array $arrays)
    {
        $data = [];
        foreach ($arrays as $array) {
            $data[] = array_map('trim', explode(',', $array));
        }

        return $data;
    }

    function dd($arr = [])
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
        exit();
    }

    function ddJson($arr = [])
    {
        echo '<pre>';
        echo json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        echo '</pre>';
        exit();
    }

}

(new Core())->run();