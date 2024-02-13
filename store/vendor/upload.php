<?php
class upload
{
    function upload_image($type)
    {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
// if (isset($_POST["submit"])) {
        if (isset($_POST['fileToUpload'])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                // echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
                if ($type == "add") {
                    header("Location:add_product_page.php?error=File is not an image");
                } else {
                    header("Location:edit_page.php?error=File is not an image");
                }

                exit();
            }
            // header("Location:add_product_page.php");
            // exit();
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
            if ($type == "add") {
                header("Location:add_product_page.php?error=Sorry, file already exists");
            } else {
                header("Location:edit_page.php?error=Sorry, file already exists");
            }
            exit();
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $uploadOk = 0;
            if ($type == "add") {
                header("Location:add_product_page.php?error=Sorry, your file is too large");
            } else {
                header("Location:edit_page.php?error=Sorry, your file is too large");
            }
            exit();
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $uploadOk = 0;
            if ($type == "add") {
                header("Location:add_product_page.php?error=Sorry, only JPG, JPEG, PNG & GIF files are allowed");
            } else {
                header("Location:edit_page.php?error=Sorry, only JPG, JPEG, PNG & GIF files are allowed");
            }
            exit();
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            if ($type == "add") {
                header("Location:add_product_page.php?error=Sorry, your file was not uploaded");
            } else {
                header("Location:edit_page.php?error=Sorry, your file was not uploaded");
            }
            exit();
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
                $file_name = $_FILES["fileToUpload"]["name"];
                return $file_name;
                // header("Location:add_product_page.php");
                // exit();
            } else {
                if ($type == "add") {
                    header("Location:add_product_page.php?error=Sorry, there was an error uploading your file");
                } else {
                    header("Location:edit_page.php?error=Sorry, there was an error uploading your file");
                }
                exit();
            }
        }
    }
}

?>