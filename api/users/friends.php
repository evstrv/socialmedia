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

        $query = "select * from friends where user={$data['userId']} and friend={$data['friendId']} limit 1";
        $res = false;
        
        if($resDb = mysqli_query($link, $query)) {
            if($res = mysqli_fetch_assoc($resDb)) {
                $query = "delete from friends where id={$res['id']} limit 1";
                $res = mysqli_query($link, $query);
            } else {
                $query = "insert into friends(user, friend) values({$data['userId']}, {$data['friendId']})";
                $res = mysqli_query($link, $query);
            }
        }

        mysqli_close($link);
        die(json_encode(['res' => $res]));
    }

    die();