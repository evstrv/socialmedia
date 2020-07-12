<?php
    $link = mysqli_connect(
        'localhost',
        'root',
        '',
        'socialmedia'
    );

    if($link !== false) {
        $query = "select id, avatar, name, type from users limit 15";
        $resDb = mysqli_query($link, $query);
        $res = [];

        while($item = mysqli_fetch_assoc($resDb)) {
            $res[] = $item;
        }

        $query = "select * from notification where userId in (".implode(',', array_column($res, 'id')).") and type='ADD_FRIEND'";
        $resDb = mysqli_query($link, $query);

        $requests = [];
        while($item = mysqli_fetch_assoc($resDb)) {
            $requests[strval($item['otherId'])] = $item['id'];
        }
        
        mysqli_close($link);
        die(json_encode(['res' => true, 'users' => $res, 'requests' => $requests]));
    }

    die();