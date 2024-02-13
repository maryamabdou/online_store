<?php
require "Config.php";
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer as PHPMailer;
use PHPMailer\PHPMailer\Exception as Exception;
use PHPMailer\PHPMailer\SMTP as SMTP;

session_start();
class Users
{
    use Config;

    public function get_userID()
    {
        $login = $_SESSION["userLogin"];
        $sql = "SELECT id FROM users WHERE email='$login' or phone='$login'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $user_id = $row['id'];
        }

        return $user_id;
    }

    public function get_userEmail()
    {
        $login = $_SESSION["userLogin"];
        $sql = "SELECT email FROM users WHERE email='$login' or phone='$login'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $user_email = $row['email'];
        }

        return $user_email;
    }


    public function login($login, $password, $type, $remember)
    {
        $sql = "SELECT email, password, role FROM users 
        WHERE (email='$login' or phone='$login') and password='$password' and role='$type';";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() != 0) {
            $_SESSION["userLogin"] = $login;
            $_SESSION["userPassword"] = $password;
            $_SESSION["type"] = $type;

            if ($remember === true) {
                $sql = "SELECT token FROM users WHERE email='$login' or phone='$login'";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    $token = $row['token'];
                }
                $cookie_name = "token";
                $cookie_value = $token;
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
            }

            if ($type == "Admin") {
            } else if ($type == "user") {
                header("Location: ../user/user_page.php");
                exit();
            } else if ($type == "vendor") {
                header("Location: ../vendor/vendor_page.php");
                exit();
            } else {
            }
        } else {
            header("Location:login_page.php?error=Wrong email or password");
            exit();
        }
    }

    public function signUp($name, $email, $password, $phone, $type, $id, $storeName, $tax, $token)
    {
        // To check that the email and phone are unique
        $sql = "SELECT email, phone, token FROM users WHERE email = '$email' or phone = '$phone' or token = '$token'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            // Insert data into users table
            $sql = "INSERT INTO users(name, email, password, phone, role, token) VALUES('$name', '$email', '$password', '$phone', '$type', '$token')";
            $this->connect()->exec($sql);
            if ($type === 'vendor') {
                // Check if tax no is used before
                $sql = "SELECT taxNo FROM vendors WHERE taxNo = '$tax';";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() === 0) {
                    // Insert data into vendors table
                    $sql2 = "INSERT INTO vendors(vendor_id, national_id, storeName, taxNo) VALUES((SELECT id FROM users WHERE email='$email'), '$id', '$storeName', '$tax')";
                    $this->connect()->exec($sql2);
                } else {
                    header("Location:../signup/signup_page.php?error=The tax no is used before");
                    exit();
                }
            }
            header("Location:../login/login_page.php?success=Signed up successfuly");
            exit();
        } else {
            header("Location:../signup/signup_page.php?error=The email or phone is used before");
            exit();
        }
    }

    public function add_product($name, $category, $price, $quantity, $img_name)
    {
        $sql = "SELECT id FROM categories WHERE name='$category';";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $category_id = $row['id'];
        }
        echo $category_id;

        $userLogin = $_SESSION['userLogin'];
        $sql = "SELECT vendors.id FROM vendors join users on vendors.vendor_id = users.id WHERE email='$userLogin' or phone='$userLogin'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $vendor_id = $row['id'];
        }
        echo $vendor_id;

        $img_src = "../uploads/$img_name";
        $sql = "INSERT INTO product(name, price, quantity, category_id, vendor_id, img_src) 
            VALUES ('$name', '$price', '$quantity', '$category_id', '$vendor_id', '$img_src');";
        $this->connect()->exec($sql);
        header("Location:../vendor/vendor_page.php?success=Product added successfuly");
        exit();
    }

    public function change($password)
    {
        $email = $this->get_userEmail();
        $sql = "UPDATE users SET password = '$password' WHERE email='$email';";
        if ($this->connect()->exec($sql)) {
            header("Location:login_page.php?success=Password is changed successfuly");
            exit();
        } else {
            header("Location:change_pass_page.php?error=Email not found");
            exit();
        }
    }

    public function reset($password)
    {
        $email = $_SESSION['reset_email'];
        $sql = "UPDATE users SET password = '$password' WHERE email='$email';";
        $this->connect()->exec($sql);
        header("Location:login_page.php?success=Password is changed successfuly");
        exit();
    }

    public function send_mail($email, $message, $subject)
    {
        $sql = "SELECT email FROM users WHERE email='$email';";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            try {
                // Create a new PHPMailer instance
                $mail = new PHPMailer(true);
                // Configure the PHPMailer instance
                $mail->isSMTP();
                $mail->Host = 'sandbox.smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                $mail->Username = 'b2aef9011c947d';
                $mail->Password = '7e267dca1aee8c';
                $mail->Port = 465;

                // Set the sender, recipient, subject, and body of the message
                $mail->setFrom('support@gmail.com');
                $mail->addAddress($email);
                $mail->Subject = $subject;
                $mail->isHTML(true);
                $mail->Body = $message;

                // Send the message
                $mail->send();
            } catch (Exception $e) {
                echo "$e";
            }
            header("Location:../login/login_page.php?success=Check your email");
            exit();
        } else {
            header("Location:forget_page.php?error=Email not found");
            exit();
        }
    }

    public function get_email($token)
    {
        $token = $_COOKIE["token"];
        $sql = "SELECT email, password FROM users WHERE token = '$token';";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $email = $row['email'];
                $password = $row['password'];
            }
            $_SESSION["userEmail"] = $email;
            $_SESSION["userPassword"] = $password;
        }
    }

    public function display_product()
    {
        $sql = "SELECT product.id, product.enable_prod, categories.name as category_name, product.name, product.price, product.quantity, users.name as vendor_name, vendors.storeName, product.img_src FROM product 
        join categories on product.category_id = categories.id
        join vendors on product.vendor_id = vendors.id
        join users on vendors.vendor_id = users.id;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function get_product_info($id)
    {
        $sql = "SELECT name, price, quantity, img_src FROM product
        WHERE id = $id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function display_categories()
    {
        $sql = "SELECT id, name FROM categories WHERE referenced_id is NULL";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function display_sub_categories($name)
    {
        $sql = "SELECT id, name FROM categories WHERE referenced_id = (SELECT id FROM categories WHERE name = '$name');";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function get_subcategories()
    {
        $sql = "SELECT id, name FROM categories WHERE referenced_id is not NULL";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function dispaly_product_categ($categ_id)
    {
        $sql = "SELECT product.id, product.enable_prod, categories.name as category_name, product.name, product.price, product.quantity, users.name as vendor_name, vendors.storeName, product.img_src FROM product 
        join categories on product.category_id = categories.id
        join vendors on product.vendor_id = vendors.id
        join users on vendors.vendor_id = users.id
        WHERE categories.id = $categ_id or categories.referenced_id = $categ_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function dispaly_product_search($search)
    {
        $search = "%" . $search . "%";
        $sql = "SELECT product.id, product.enable_prod , categories.name as category_name, product.name, product.price, product.quantity, users.name as vendor_name, vendors.storeName, product.img_src FROM product 
        join categories on product.category_id = categories.id
        join vendors on product.vendor_id = vendors.id
        join users on vendors.vendor_id = users.id
        WHERE product.name LIKE '$search'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function buy_product($total_price)
    {
        $user_id = $this->get_userID();
        $user_email = $this->get_userEmail();

        $sql = "INSERT INTO orders(user_id, price) VALUES ($user_id, $total_price);";
        $this->connect()->exec($sql);

        // $last_id = $this->connect()->lastInsertId();
        // echo $last_id;
        $sql = "SELECT id FROM orders ORDER BY id DESC LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $last_id = $row['id'];
        }

        foreach ($_SESSION['cart'] as $product_id => $data) {
            $qty = $data['qty'];
            $sql = "INSERT INTO order_details(product_id, quantity, order_id) 
                VALUES ($product_id, $qty, $last_id);";
            $this->connect()->exec($sql);

            $sql = "SELECT quantity FROM product WHERE id=$product_id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $quantity = $row['quantity'];
            }

            $sql = "UPDATE product SET quantity = ($quantity - $qty) WHERE id=$product_id";
            $this->connect()->exec($sql);

            $name = $data['name'];
            $price = $data['price'];
            $message = "<b>Your order is placed successfully! This is your order details<br>
            Name: $name, Quantity: $qty, Price: $price</b>";
            $subject = 'Order Details';
            // $this->send_mail($user_email, $message, $subject);
        }
        $_SESSION['cart'] = [];
        header("Location:user_page.php?success=Your order is placed successfully");
        exit();
    }

    function get_user_orders()
    {
        $user_id = $this->get_userID();

        $sql = "SELECT id, status FROM orders WHERE user_id = $user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function get_user_orderDetails($orders_id)
    {
        $sql = "SELECT product.name, order_details.quantity, orders.price FROM order_details
        join orders on order_details.order_id = orders.id
        join product on order_details.product_id = product.id
        WHERE orders.id = $orders_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function get_vendorID()
    {
        $login = $_SESSION["userLogin"];
        $sql = "SELECT vendors.id FROM vendors
        join users on vendors.vendor_id = users.id
        WHERE users.email='$login' or users.phone='$login'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $user_id = $row['id'];
        }

        return $user_id;
    }

    function get_vendor_orders()
    {
        $vendor_id = $this->get_vendorID();

        $sql = "SELECT DISTINCT(orders.id), orders.status FROM orders 
        join order_details on order_details.order_id = orders.id 
        join product on order_details.product_id = product.id
        WHERE product.vendor_id = $vendor_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function get_vendor_orderDetails($orders_id)
    {
        $vendor_id = $this->get_vendorID();

        $sql = "SELECT users.name as userName, product.name as productName, order_details.quantity, product.price FROM order_details
        join orders on order_details.order_id = orders.id
        join product on order_details.product_id = product.id
        join users on orders.user_id = users.id
        WHERE orders.id = $orders_id and product.vendor_id = $vendor_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function display_vendor_products()
    {
        $vendor_id = $this->get_vendorID();

        $sql = "SELECT product.id, product.enable_prod, categories.name as category_name, product.name, product.price, product.quantity, product.img_src FROM product 
        join categories on product.category_id = categories.id
        join vendors on product.vendor_id = vendors.id
        WHERE product.vendor_id = $vendor_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function enable_prod($product_id, $no)
    {
        $sql = "UPDATE product SET enable_prod=$no WHERE id=$product_id";
        $this->connect()->exec($sql);
        header("Location:../vendor/display_added.php");
        exit();
    }

}

?>