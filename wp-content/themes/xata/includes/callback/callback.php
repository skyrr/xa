<?php
require_once("../../../../../wp-load.php");

if ( empty($_POST) || ! wp_verify_nonce($_POST['_wpnonce'],'callback_email_send') ) {
    header('HTTP/1.1 400 Bad Request');
    echo 'not valid';
    exit;
} else {
    $options['email'] = get_field('callback_email', 'option');
    if ( strlen($options['email']) < 3 ) return FALSE;

    $data['email'] = trim( $_POST['email'] );
    $data['name'] = trim( $_POST['name'] );
    $data['telephone'] = trim( $_POST['telephone'] );
    $data['comment'] = trim( $_POST['comment'] );
    $data['realty_id'] = trim( $_POST['realty_id'] );

    if ( strlen($data['email']) < 5 && strlen($data['telephone']) < 5 ) return FALSE;

    if ( strlen($data['realty_id']) > 0 ) {
        $realty['title'] = __(get_post($data['realty_id'])->post_title);
        $subject = 'Заявка на просмотр: ' . $realty['title'];

        $message .= 'Обьект: ' . $realty['title'] . "\r\n";
        $message .= 'Ссылка: ' . get_permalink($data['realty_id']);

        $message .= "\r\n\r\n- - - - - - - - - -\r\n\r\n";

        $message .= 'Имя: ';
        $message .= ( strlen($data['name']) > 0 ) ? $data['name']."\r\n" : "Не указано\r\n";
        $message .= 'Телефон: ';
        $message .= ( strlen($data['telephone']) > 0 ) ? $data['telephone']."\r\n" : "Не указан\r\n";
        $message .= 'Email: ';
        $message .= ( strlen($data['email']) > 0 ) ? $data['email']."\r\n" : "Не указан\r\n";
        $message .= 'Комментарий: ';
        $message .= ( strlen($data['comment']) > 0 ) ? $data['comment']."\r\n" : "Не указан\r\n";
    } else {
        $subject = 'Обратная связь';
        if ( strlen($data['name']) > 0 ) $subject .= ' - '.$data['name'];
        $message = 'Имя: ';
        $message .= ( strlen($data['name']) > 0 ) ? $data['name']."\r\n" : "Не указано\r\n";
        $message .= 'Телефон: ';
        $message .= ( strlen($data['telephone']) > 0 ) ? $data['telephone']."\r\n" : "Не указан\r\n";
        $message .= 'Email: ';
        $message .= ( strlen($data['email']) > 0 ) ? $data['email']."\r\n" : "Не указан\r\n";
    }

    $headers = 'From: '.get_bloginfo('name').' <noreply@'.preg_replace('/^www\./','',$_SERVER['SERVER_NAME']).'>' . "\r\n";
    wp_mail($options['email'], $subject, $message, $headers);

    //echo 'Success';
}
?>