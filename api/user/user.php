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
            
            $query = "SELECT users.id, name, avatar, type, dateOpen, 
                        (select status from statuses 
                            where statuses.userId=users.id 
                            order by statuses.id desc limit 1) as status 
                        FROM users 
                        JOIN friends on friends.user=users.id or friends.friend=users.id
                        WHERE id={$data['id']} limit 1";
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
        } else if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $query = "select login from users where id=".htmlspecialchars($_POST['userId'])." limit 1";
            $resDb = mysqli_query($link, $query);

            if($resDb && $user = mysqli_fetch_assoc($resDb)) {
                $name = $user['login'].'avatar.jpg';
                move_uploaded_file($_FILES['file']['tmp_name'], "/xampp/htdocs/socialmedia/uploads/$name");
                $query = "update users set avatar='//localhost/socialmedia/uploads/$name' where id=".htmlspecialchars($_POST['userId']);

                if(mysqli_query($link, $query)) {
                    die(json_encode(['res' => true, 'src' => "//localhost/socialmedia/uploads/$name"]));
                }
            }

            die(json_encode(['res' => false]));
        }
    }

    die(json_encode(['res' => false]));