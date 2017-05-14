<?php
namespace common\helpers;

use Yii;
    
class CustomStringHelper extends \yii\base\Model
{
    /**
     * Генерация случайной строки
     *
     * @param int $length
     * @param bool $allowUppercase
     * @return string
     */
    public static function generateRandomString($length = 8, $allowUppercase = true)
    {
        $validCharacters = 'abcdefghijklmnopqrstuxyvwz1234567890';
        if ($allowUppercase) {
            $validCharacters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        $validCharNumber = strlen($validCharacters);
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $index = mt_rand(0, $validCharNumber - 1);
            $result .= $validCharacters[$index];
        }
        return $result;
    }
    
    public static function cyrillicToLatin($text, $maxLength, $toLowCase)
    {
        $dictionary = array(
            'й' => 'i', 
            'ц' => 'c', 
            'у' => 'u', 
            'к' => 'k', 
            'е' => 'e', 
            'н' => 'n',
            'г' => 'g', 
            'ш' => 'sh', 
            'щ' => 'shch', 
            'з' => 'z', 
            'х' => 'h', 
            'ъ' => '',
            'ф' => 'f', 
            'ы' => 'y', 
            'в' => 'v', 
            'а' => 'a',
            'п' => 'p', 
            'р' => 'r',
            'о' => 'o', 
            'л' => 'l', 
            'д' => 'd', 
            'ж' => 'zh', 
            'э' => 'e', 
            'ё' => 'e',
            'я' => 'ya', 
            'ч' => 'ch', 
            'с' => 's', 
            'м' => 'm', 
            'и' => 'i', 
            'т' => 't',
            'ь' => '', 
            'б' => 'b', 
            'ю' => 'yu',
 
            'Й' => 'I', 
            'Ц' => 'C', 
            'У' => 'U', 
            'К' => 'K', 
            'Е' => 'E', 
            'Н' => 'N',
            'Г' => 'G', 
            'Ш' => 'SH', 
            'Щ' => 'SHCH', 
            'З' => 'Z', 
            'Х' => 'X', 
            'Ъ' => '',
            'Ф' => 'F', 
            'Ы' => 'Y', 
            'В' => 'V', 
            'А' => 'A', 
            'П' => 'P', 
            'Р' => 'R',
            'О' => 'O', 
            'Л' => 'L',
            'Д' => 'D', 
            'Ж' => 'ZH', 
            'Э' => 'E', 
            'Ё' => 'E',
            'Я' => 'YA', 
            'Ч' => 'CH', 
            'С' => 'S', 
            'М' => 'M', 
            'И' => 'I', 
            'Т' => 'T',
            'Ь' => '', 
            'Б' => 'B', 
            'Ю' => 'YU',
 
            '\-' => '-',
            '\s' => '-',
 
            '[^a-zA-Z0-9\-]' => '',
 
            '[-]{2,}' => '-',
        );
 
        foreach ($dictionary as $from => $to)
        {
            $text = mb_ereg_replace($from, $to, $text);
        }
 
        $text = mb_substr($text, 0, $maxLength, Yii::$app->charset); 
        if ($toLowCase)
        {
            $text = mb_strtolower($text, Yii::$app->charset);
        }
 
        return trim($text, '-');
    }
}
?>