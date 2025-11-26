<?php
$conn = \config\Database::getInstance()->getConnection();

$stmt = $conn ->prepare("SELECT * FROM aulas");
$stmt -> execute([1]);

while ($row = $stmt ->fetch_assoc()){
    echo "{$row['AU_NOME']}";
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
        <tr>
            <th></th>
            <th>Segunda</th>
            <th>Terça</th>
            <th>Quarta</th>
            <th>Quinta</th>
            <th>Sexta</th>
            <th>Sábado</th>
            <th>Domingo</th>
        </tr>
        </thead>
        <tr>
            <th>6:00</th>
        </tr>
        <tr>
            <th>7:00</th>
        </tr>
        <tr>
            <th>8:00</th>
        </tr>
        <tr>
            <th>9:00</th>
        </tr>
        <tr>
            <th>10:00</th>
        </tr>
        <tr>
            <th>11:00</th>
        </tr>
        <tr>
            <th>12:00</th>
        </tr>
        <tr>
            <th>13:00</th>
        </tr>
        <tr>
            <th>14:00</th>
        </tr>
        <tr>
            <th>15:00</th>
        </tr>
        <tr>
            <th>16:00</th>
        </tr>
        <tr>
            <th>17:00</th>
        </tr>
        <tr>
            <th>18:00</th>
        </tr>
        <tr>
            <th>19:00</th>
        </tr>
        <tr>
            <th>20:00</th>
        </tr>
    </table>    
</body>
</html>