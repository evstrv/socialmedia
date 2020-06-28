<?php
    $link = mysqli_connect(
        'localhost',
        'root',
        '',
        'socialmedia'
    );
    
    if($link !== false) {
        // $data = json_decode(file_get_contents('php://input'), true);
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = [];
            foreach($_GET as $key=>&$item) {
                $data[$key] = htmlspecialchars($item);
            }
    
            $query = "SELECT * FROM users WHERE id={$data['id']} limit 1";
            $res = mysqli_fetch_assoc(mysqli_query($link, $query));
            mysqli_close($link);
    
            if($res !== false && !empty($res)) {
                die(json_encode([
                    'res' => true,
                    'user' => $res
                ]));
            } else {
                die(json_encode([
                    'res' => false
                ]));
            }
        } else if($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $data = json_decode(file_get_contents('php://input'), true);
            foreach($data as $key=>&$item) {
                $item = $key . '="' . htmlspecialchars($item) . '"';
            }
            $query = "UPDATE users SET " . implode(',', $data) . "WHERE id=" . htmlspecialchars($_GET['id']);
            $res = mysqli_query($link, $query);
            mysqli_close($link);
            die(json_encode(['res' => $res]));
        }
    }

    die();