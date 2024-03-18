<?php session_start();
include('../config/dbcon.php');
include('../functions/myfunctions.php');

if (isset($_POST['add_category_button'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $slug = mysqli_real_escape_string($con, $_POST['slug']);
    $meta_title = mysqli_real_escape_string($con, $_POST['meta_title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $meta_description = mysqli_real_escape_string($con, $_POST['meta_description']);
    $meta_keywords = mysqli_real_escape_string($con, $_POST['meta_keywords']);
    $status = isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';

    $image = $_FILES['image']['name'];
    $temp_image = $_FILES['image']['tmp_name'];
    $path = "../uploads";

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    $cate_query = "INSERT INTO categories (name, slug, description, status, popular, image, meta_title, meta_description, meta_keywords) 
    VALUES ('$name','$slug','$description','$status','$popular','$filename','$meta_title','$meta_description','$meta_keywords')";

    $cate_query_run = mysqli_query($con, $cate_query);

    if ($cate_query_run) {
        move_uploaded_file($temp_image, $path . '/' . $filename);
        redirect("add-category.php", "Category Added Successfully");
    } else {
        redirect("add-category.php", "Something Went Wrong");
    }
} else if (isset($_POST['update_category_button'])) {
    $category_id = $_POST['category_id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $slug = mysqli_real_escape_string($con, $_POST['slug']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $meta_title = mysqli_real_escape_string($con, $_POST['meta_title']);
    $meta_description = mysqli_real_escape_string($con, $_POST['meta_description']);
    $meta_keywords = mysqli_real_escape_string($con, $_POST['meta_keywords']);
    $status = isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';

    $new_image = $_FILES['image']['name'];
    $temp_image = $_FILES['image']['tmp_name'];
    $old_image = $_POST['old_image'];
    $path = "../uploads";

    // If a new image is uploaded, update the filename
    if ($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $filename = time() . '.' . $image_ext;
        move_uploaded_file($temp_image, $path . '/' . $filename);

        // Remove old image if exists
        if (file_exists("../uploads/" . $old_image)) {
            unlink("../uploads/" . $old_image);
        }
    } else {
        // If no new image, retain the old image filename
        $filename = $old_image;
    }

    $update_query = "UPDATE categories SET name='$name', slug='$slug', description='$description', meta_title='$meta_title',
    meta_description='$meta_description', meta_keywords='$meta_keywords', status='$status', popular='$popular', image='$filename' 
    WHERE id='$category_id'";

    $update_query_run = mysqli_query($con, $update_query);

    if ($update_query_run) {
        redirect("edit-category.php?id=$category_id", "Category Updated Successfully");
    } else {
        redirect("edit-category.php?id=$category_id", "Failed to update category");
    }
} else if (isset($_POST['delete_category_btn'])) {
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $category_query = "SELECT * FROM categories WHERE id='$category_id' ";
    $category_query_run = mysqli_query($con, $category_query);
    $category_data = mysqli_fetch_array($category_query_run);
    $image = $category_data['image'];
    $delete_query = "DELETE FROM categories WHERE id='$category_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        if (file_exists("../uploads/" . $image)) {
            unlink("../uploads/" . $image);
        }
        redirect("category.php", "Category Deleted Successfully");
    } else {
        redirect("category.php", "Something Went Wrong");
    }
} else if (isset($_POST['add_product_button'])) {
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $slug = mysqli_real_escape_string($con, $_POST['slug']);
    $small_description = mysqli_real_escape_string($con, $_POST['small_description']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $orignal_price = mysqli_real_escape_string($con, $_POST['orignal_price']);
    $selling_price = mysqli_real_escape_string($con, $_POST['selling_price']);
    $quantity = mysqli_real_escape_string($con, $_POST['qty']);
    $meta_title = mysqli_real_escape_string($con, $_POST['meta_title']);
    $meta_description = mysqli_real_escape_string($con, $_POST['meta_description']);
    $meta_keywords = mysqli_real_escape_string($con, $_POST['meta_keywords']);
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';

    $image = $_FILES['image']['name'];
    $temp_image = $_FILES['image']['tmp_name'];
    $path = "../uploads/";

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    // Check for allowed file types and sizes
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    $max_size = 5 * 1024 * 1024; // 5MB

    if (in_array(strtolower($image_ext), $allowed_types) && $_FILES['image']['size'] <= $max_size) {
        if (move_uploaded_file($temp_image, $path . $filename)) {
            $product_query = "INSERT INTO products (category_id, name, slug, small_description, description, orignal_price, selling_price,
                qty, meta_title, meta_description, meta_keywords, status, trending, image) VALUES ('$category_id', '$name', '$slug',
                '$small_description', '$description', '$orignal_price', '$selling_price', '$quantity', '$meta_title', '$meta_description',
                '$meta_keywords', '$status', '$trending', '$filename')";

            $product_query_run = mysqli_query($con, $product_query);

            if ($product_query_run) {
                redirect("add-products.php", "Product Added Successfully");
            } else {
                redirect("add-products.php", "Something Went Wrong");
            }
        } else {
            redirect("add-products.php", "Failed to upload image");
        }
    } else {
        redirect("add-products.php", "Invalid file type or size. Allowed types: jpg, jpeg, png, gif. Max size: 5MB");
    }
} else if (isset($_POST['update_product_button'])) {
    $product_id = $_POST['product_id'];
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $slug = mysqli_real_escape_string($con, $_POST['slug']);
    $small_description = mysqli_real_escape_string($con, $_POST['small_description']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $orignal_price = mysqli_real_escape_string($con, $_POST['orignal_price']);
    $selling_price = mysqli_real_escape_string($con, $_POST['selling_price']);
    $quantity = mysqli_real_escape_string($con, $_POST['qty']);
    $meta_title = mysqli_real_escape_string($con, $_POST['meta_title']);
    $meta_description = mysqli_real_escape_string($con, $_POST['meta_description']);
    $meta_keywords = mysqli_real_escape_string($con, $_POST['meta_keywords']);
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';

    $new_image = $_FILES['image']['name'];
    $temp_image = $_FILES['image']['tmp_name'];
    $old_image = $_POST['old_image'];
    $path = "../uploads";

    if ($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $filename = time() . '.' . $image_ext;
        move_uploaded_file($temp_image, $path . '/' . $filename);

        // Remove old image if exists
        if (file_exists("../uploads/" . $old_image)) {
            unlink("../uploads/" . $old_image);
        }
    } else {
        // If no new image, retain the old image filename
        $filename = $old_image;
    }

    // Constructing SQL query using prepared statement
    $update_query = "UPDATE products SET category_id=?, name=?, slug=?, small_description=?, description=?, orignal_price=?, selling_price=?, qty=?, meta_title=?, meta_description=?, meta_keywords=?, status=?, trending=?, image=? WHERE id=?";

    $stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param($stmt, "isssssssssssssi", $category_id, $name, $slug, $small_description, $description, $orignal_price, $selling_price, $quantity, $meta_title, $meta_description, $meta_keywords, $status, $trending, $filename, $product_id);
    mysqli_stmt_execute($stmt);

    // Handling redirection based on query result
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        redirect("products.php", "Product Updated Successfully");
    } else {
        redirect("edit-product.php?id=$product_id", "Failed to update product");
    }
} else if (isset($_POST['delete_product_btn'])) {
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);
    $product_query = "SELECT * FROM products WHERE id='$product_id' ";
    $product_query_run = mysqli_query($con, $product_query);
    $product_data = mysqli_fetch_array($product_query_run);
    $image = $product_data['image'];
    $delete_query = "DELETE FROM products WHERE id='$product_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        if (file_exists("../uploads/" . $image)) {
            unlink("../uploads/" . $image);
        }
        //redirect("products.php", "Product Deleted Successfully");
        echo 200;
    } else {
       // redirect("products.php", "Something Went Wrong");
       echo 500;
    }
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $get_product = ("SELECT * FROM products Where id ='$id'");
    $get_product_run = mysqli_query($con, $get_product);


    if ($get_product_run->num_rows > 0) {
        $row = $get_product_run->fetch_assoc();
        // Prepare data for the new product (excluding ID)
        $category_id = $row['category_id'];
        $name = $row['name'] . " (Copy)";
        $slug = $row['slug'];
        $small_description = $row['small_description'];
        $description = $row['description'];
        $orignal_price = $row['orignal_price'];
        $selling_price = $row['selling_price'];
        $quantity = $row['qty'];
        $meta_title = $row['meta_title'];
        $meta_description = $row['meta_description'];
        $meta_keywords = $row['meta_keywords'];
        $status = $row['status'];
        $trending = $row['trending'];
        $image = $row['image'];


        $dup_product_query = "INSERT INTO products (category_id, name, slug, small_description, description, orignal_price, selling_price,
                qty, meta_title, meta_description, meta_keywords, status, trending, image) VALUES ('$category_id', '$name', '$slug',
                '$small_description', '$description', '$orignal_price', '$selling_price', '$quantity', '$meta_title', '$meta_description',
                '$meta_keywords', '$status', '$trending', '$image')";

        $dup_product_query_run = mysqli_query($con, $dup_product_query);

        if ($dup_product_query_run) {
            redirect("products.php", "Product Duplicate Successfully");
        } else {
            redirect("products.php", "Something Went Wrong");
        }
    }
}
