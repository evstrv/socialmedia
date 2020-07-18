<?php
    $link = mysqli_connect(
        'localhost',
        'root',
        '',
        'socialmedia'
    );

    if($link !== false) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            foreach($data as &$item) {
                $item = htmlspecialchars($item);
            }

            $query = "insert into notification(type, userId, otherId) values('{$data['type']}', {$data['userId']}, {$data['otherId']})";
            $res = mysqli_query($link, $query);
            $id = $res ? mysqli_insert_id($link) : -1;
            mysqli_close($link);
            die(json_encode(['res' => $res, 'id' => $id]));
        } else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $query = "delete from notification where id=" . htmlspecialchars($_GET['id']) . " limit 1";
            $res = mysqli_query($link, $query);
            mysqli_close($link);
            die(json_encode(['res' => $res]));
        } else if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $query = "select * from notification where otherId=".htmlspecialchars($_GET['id']);
            $resDb = mysqli_query($link, $query);  
            $res = [];

            while($item = mysqli_fetch_assoc($resDb)) {
                $res[] = $item;
            }

            mysqli_close($link);
            die(json_encode(['res' => true, 'notifications' => $res]));
        }
    }

    die(json_encode(['res' => false]));