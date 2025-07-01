<?php

session_start(); 

// include necessary models/controllers
require_once __DIR__ . '/Controllers/usercontroller.php';
require_once __DIR__ . '/Controllers/ArticalController.php';
require_once __DIR__ . '/Controllers/CommentController.php'; 
require_once __DIR__ . '/Models/config.php'; 

$action = $_GET['action'] ?? 'login';

$controller = new Usercontroller($conn);           // login/logout
$articleController = new ArticalController($conn); 
$commentController = new CommentController($conn); 


switch ($action) {
    case 'login':
        $controller->login();
        break;
    case 'logout':
        $controller->logout();
        break;
    case 'articles':
        $articles = $articleController->handleRequest($_SESSION['user_id'] ?? null);
        require_once __DIR__ . '/Views/articles.php'; // load articles view
        break;

    case 'create':
        // article creation
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $articleController->handleRequest($_SESSION['user_id'] ?? null);
        }
        break;
    case 'delete':
        // article deletion
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $articleController->handleRequest($_SESSION['user_id'] ?? null);
        } else {
            header('Location: index.php?action=articles');
        }
        break;
    case 'deleteComment': // comment deletion
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commentController->delete($_POST['comment_id']); // delete by id
        }
        break;
    case 'createComment': // comment creation
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commentController->create($_POST); 
        }
        break;

    default:
        // error
        echo "404 Not Found";
}
