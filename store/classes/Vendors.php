<?php
require "Config.php";

session_start();
class Vendors
{
    use Config;

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

    public function change_price($price, $product_id)
    {
        $sql = "UPDATE product SET price = $price WHERE id=$product_id;";
        $this->connect()->exec($sql);
        header("Location:display_added.php?success=Price is changed successfuly");
        exit();
    }

    public function change_quantity($quantity, $product_id)
    {
        $sql = "UPDATE product SET quantity = $quantity WHERE id=$product_id;";
        $this->connect()->exec($sql);
        header("Location:display_added.php?success=Price is changed successfuly");
        exit();
    }

    public function change_photo($img_name, $product_id)
    {
        $img_src = "../uploads/$img_name";
        $sql = "UPDATE product SET img_src = $img_src WHERE id=$product_id;";
        $this->connect()->exec($sql);
        header("Location:display_added.php?success=Price is changed successfuly");
        exit();
    }

    public function deliver_order($order_id){
        $sql = "UPDATE orders SET status = 'delivered' WHERE id=$order_id;";
        $this->connect()->exec($sql);
        header("Location:taken_orders.php?success=Price is changed successfuly");
        exit();
    }
}
?>