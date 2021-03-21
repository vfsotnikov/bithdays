<?php
function printBithday($day, $fio){
    $rowStyles = array('even','odd');
    static $styleIndex = 0;
    echo "<tr class=\"".$rowStyles[$styleIndex].'"><td>' . date("d.m", $day) . '</td><td>' . $fio . "</td></tr>";
    $styleIndex = 1 - $styleIndex;
}

$file = fopen("birthdays.csv", "a+t") or die("Ошибка открытия файла birthdays.csv");

$birthdays = array ();

while(!feof($file)){
    $readLine = fgetcsv($file, 1000, ";");
    $date = strtotime(substr($readLine[0],0,6)."1970");
    $birthdays += array($date => $readLine[1]);
}

fclose($file);

ksort($birthdays);

$nextYear = array();

$today1970 = strtotime(date("d.m.") . "1970");
?>
<?php
require_once "head.html"
?>
    <h3>Сегодня: <?php echo date("d.m.Y"); ?></h3>
    <h3>Дни рождения коллег</h3>
    <table>
    <tr>
        <th>День</th>
        <th>ФИО</th>
    </tr>
    <?php foreach($birthdays as $k => $v){
        if ($today1970 <= $k)
        {
            printBithday($k, $v);
        }
        else
            $nextYear += array($k => $v);
    }

    foreach ($nextYear as $k => $v){
        printBithday($k, $v);
    }
?>
    </table>
<?php
require_once "footer.html";