<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Проверка номера</title>
</head>

<body>
    <form method="POST">
        <input type="text" name="phone" placeholder="Введите номер телефона" required>
        <input type="submit" name="check" value="Проверить">
    </form>

    <?php

    if (isset($_POST['check']))
    {

        $phone=$_POST['phone'];
        
        $fd1 = fopen("blacklist.txt", 'r') or die("Не удалось открыть файл"); // файл открывается только для чтения
        while(!feof($fd1))
        {
            $phones = htmlentities(fgets($fd1));
            if($phones == $phone)
            {
                echo $phones;
                echo " - номер в черном списке";
                goto blackl; //переход на метку blackl при совпадении
                
            }
            else
            {
                $whitephone = $phone;
            }
        }

        $fd2 = fopen("whitelist.txt", 'a+') or die("Не удалось открыть файл"); // файл открывается для чтения и записи
        fwrite($fd2, $whitephone."\r\n"); //запись в файл с новой строки
        echo $whitephone;
        echo " - номера нет в черном списке, он успешно записан в файл";
        fclose($fd2);

        $whitephone = "";

        blackl: //метка для пропуска лишнего сравнения, если номер уже совпал с номером в черном списке

        fclose($fd1);
    }

    ?>

</body>

</html>