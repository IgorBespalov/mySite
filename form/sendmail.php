<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';

    $mail = new PHPMailer(true);
    $mail->CharSet = "UTF-8";
    $mail->setLanguage('ru', 'phpmailer/language/');
    $mail->IsHTML(true);

    // От кого письмо
    $mail -> setFrom('order@sbsc.ru', 'Заказ с сайта Smart Business Solutions');
    // Кому отправлять письмо
    $mail -> addAddress('consultant@sbsc.ru', 'sbsc_rus@mail.ru');
    // Тема письма
    $mail -> Subject = 'Это текст запроса';

    // Форма оплаты
    $payment = 'Частное лицо';
    if($_POST['payment'] == 'organisation') {
        $payment = 'Организация';
    };

    // $product_name = localStorage.getItem('order_text');

    // Тело письма

    $body = '<h1>Заявка с сайта:</h1>';

    // if (trim(!empty($_POST['product_name']))) {
    //     $body.='<p><strong>Заказанный продукт:</strong> '.$product_name.'</p>';
    // }

    if (trim(!empty($_POST['message']))) {
        $body.='<p><strong>Продукт/услуга:</strong> '.$_POST['message'].'</p>';
    }

    if (trim(!empty($_POST['name']))) {
        $body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
    }

    if (trim(!empty($_POST['email']))) {
        $body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
    }

    if (trim(!empty($_POST['payment']))) {
        $body.='<p><strong>Способ оплаты:</strong> '.$payment.'</p>';
    }

    if (trim(!empty($_POST['product_order']))) {
        $body.='<p><strong>Заказанный продукт:</strong> '.$_POST['product_order'].'</p>';
    }

    if (trim(!empty($_POST['message2']))) {
        $body.='<p><strong>Сообщение:</strong> '.$_POST['message2'].'</p>';
    }

    $mail->Body = $body;

    // Отправляем письмо
    if (!$mail->send()) {
        $message = 'Ошибка отправки...';
    } else {
        $message = 'Заявка успешно отправлена! В течение дня наш консультант свяжется с Вами для оформления заказа.';
    }

    $response = ['message' => $message];

    header('Content-type: application/json');
    echo json_encode($response);
    
?>
