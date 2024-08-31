<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affinity</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="st.css">
</head>
<body>
    <?php 
    session_start();
    
    require_once __DIR__ .'/backend/database.php';
    require_once __DIR__ .'/backend/users.php';
    require_once __DIR__ .'/backend/products.php';
    require_once __DIR__ .'/backend/orders.php';


    
    $database = new Database();
    $connection = $database->getConnection();
    $user = new User($connection);
    $products = new Product($connection);
    $order = new Order($connection);


    $path = @$_GET['path'];


    if (isset($_SESSION['userId'], $_SESSION['userName'], $_SESSION['userEmail'], $_SESSION['userLocation'], $_SESSION['loginString'])) {
        $is_logged_in = true;
    }else{
        $is_logged_in = false;

    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['register'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $location = $_POST['location'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password === $confirm_password) {
                
                $result = $user->create($name, $email, "1", $password, "1", "1", $location);

                if ($result['error'] === false) {
                    echo "<script type='text/javascript'>alert('Account created successfully')</script>";
                } else {
                    echo "<script type='text/javascript'>alert('". $result['info'] ."')</script>";
                }
            } else {
                echo "<script type='text/javascript'>alert('Passwords do not match')</script>";
            }
        } else if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $result = $user->login($email, $password);

            if ($result['error'] === false) {
                // Start session and store user data
                $_SESSION['userId'] = $result['data']['id'];
                $_SESSION['userName'] = $result['data']['name'];
                $_SESSION['userEmail'] = $result['data']['email'];
                $_SESSION['userLocation'] = $result['data']['location'];
                $_SESSION['loginString'] = hash('sha512', $result['data']['password'] . $_SERVER['HTTP_USER_AGENT']);
                $is_logged_in = true;
            } else {
                echo "<p>Error: " . $result['info'] . "</p>";
            }
        }
    }
    ?>
    
    <?php 
        $items = $products->read();

    if ($is_logged_in) {
        // Load the logged in user bar
        // checkthe user teype
        $email = $_SESSION['userEmail'];
        if($email == "admin@gmail.com"){
            require_once __DIR__ . "/pages/admin_header.php";

        }else{
             require_once __DIR__ . "/pages/logged_in_header.php";
        }


    } else {
        require_once __DIR__ . "/pages/loged_out_header.php";
    }

    if ($path == "home" || empty($path)) {
        require_once __DIR__ . "/pages/home.php";
    }elseif ($path == "contact") {
        require_once __DIR__ . "/pages/contact.php";
    }elseif ($path == "about") {
        require_once __DIR__ . "/pages/about.php";
    }elseif ($path == "signup") {
        require_once __DIR__ . "/forms/register.php";
    }elseif ($path == "login") {
        if (isset($_SESSION['userId'], $_SESSION['userName'], $_SESSION['userEmail'], $_SESSION['userLocation'], $_SESSION['loginString'])) {
            require_once __DIR__ . "/pages/home.php";
        }else{
            require_once __DIR__ . "/forms/login.php";
        }
    }elseif ($path == "logout") {
        $_SESSION = array();
        session_destroy();
        $is_logged_in = false;
        echo "<script type='text/javascript'>alert('Logout successful');</script>";
        // require_once __DIR__ . "/pages/home.php";
        echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
    
    }elseif ($path == "cart"){
        require_once __DIR__ . "/pages/cart.php";

    }elseif ($path == "users"){
        require_once __DIR__ . "/pages/users.php";
    }elseif ($path == "products"){
        require_once __DIR__ . "/pages/products.php";
    }elseif ($path == "orders"){
        require_once __DIR__ . "/pages/orders.php";

    }elseif ($path == "addproduct"){
        require_once __DIR__ . "/forms/product.php";

    }


    require_once __DIR__ . "/pages/footer.php";
    ?>
    <script src="ss.js"></script>
</body>
</html>
