<?php
    $link = mysqli_connect(
        'localhost',
        'root',
        '',
        'socialmedia'
    );
    
    if($link !== false) {
        $data = json_decode(file_get_contents('php://input'), true);

        foreach($data as &$item) {
            $item = htmlspecialchars($item);
        }

        $query = "SELECT id, login FROM users WHERE login=\"{$data['login']}\" and password=\"{$data['password']}\" limit 1";
        $resDb = mysqli_query($link, $query);

        // var_dump(mysqli_error($link));

        if($user = mysqli_fetch_assoc($resDb)) {
            mysqli_close($link);
            die(json_encode(['res' => true, 'userId' => $user['id']]));
        }

        mysqli_close($link);
        die(json_encode(['res' => false]));
    } 



    die();