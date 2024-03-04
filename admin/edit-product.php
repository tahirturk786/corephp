<?php
include('includes/header.php');
include('../middleware/adminMiddleware.php');

?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $product = mysqli_query($con, "SELECT products.*, categories.id AS category_id, categories.name AS category_name
                FROM products
                JOIN categories ON products.category_id = categories.id");
                if (mysqli_num_rows($product) > 0) {

                    $data = mysqli_fetch_array($product);
            ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Product</h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                    <input type="hidden" name="product_id" value="<?= $data['id'] ?>">
                                        <label for="">Product Name</label>
                                        <input type="text" value="<?= $data['name'] ?>" name="name" required placeholder="Enter Product Name" class="form-control mb-2">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">slug</label>
                                        <input type="text" value="<?= $data['slug'] ?>" name="slug" required placeholder="Enter Slug" class="form-control mb-2">
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <select name="category_id" class="form-select form-control mb-2" required aria-label="">
                                            <option> Select Category</option>
                                            <?php
                                            $categories = getAll('categories');
                                            if (mysqli_num_rows($categories) > 0) {
                                                foreach ($categories as $item) {
                                                    $selected = ($item['id'] == $data['category_id']) ? 'selected' : '';
                                            ?>
                                                    <option value="<?= $item['id']; ?>" <?= $selected; ?>><?= $item['name']; ?></option>
                                            <?php
                                                }
                                            } else {
                                                echo "No categories Available";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Small Description</label>
                                        <textarea name="small_description"  required rows="3" cols="50" class="form-control mb-2"><?= $data['small_description'] ?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Description</label>
                                        <textarea name="description" required rows="3" cols="50" class="form-control mb-2"><?= $data['description'] ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Orignal Price</label>
                                        <input type="text" name="orignal_price" value="<?= $data['orignal_price'] ?>" required placeholder="Enter Orignal" class="form-control mb-2">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Selling Price</label>
                                        <input type="text" name="selling_price" value="<?= $data['selling_price'] ?>" required placeholder="Enter Selling Price" class="form-control mb-2">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Upload Image</label>
                                        <input type="file" name="image" class="form-control mb-2">
                                        <label for="">Current Image :</label>
                                        <input type="hidden" name="old_image" value="<?= $data['image'] ?>">
                                        <img src="../uploads/<?= $data['image'] ?>" height="50px" height="50px" alt="">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">Quantity</label>
                                            <input type="number" name="qty" value="<?= $data['qty'] ?>" required placeholder="Enter Quantity" class="form-control mb-2">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Status</label> <br>
                                            <input type="checkbox"  name="status" <?= $data['status'] ? "checked" : "" ?>>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Trending</label> <br>
                                            <input type="checkbox" name="trending" <?= $data['trending'] ? "checked" : "" ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Meta Title</label>
                                        <input type="text" name="meta_title" value="<?= $data['meta_title'] ?>" placeholder="Enter Meta Title" class="form-control mb-2">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Meta description</label>
                                        <textarea name="meta_description" rows="3" cols="50" class="form-control mb-2" required><?= $data['meta_description'] ?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Meta Keywords</label>
                                        <input type="text" name="meta_keywords" value="<?= $data['meta_keywords'] ?>" placeholder="Enter Meta Keywords" class="form-control mb-2" required>
                                    </div>

                                    <div class="col-md-12 mt-5">
                                        <button type="submit" class="btn btn-primary" name="update_product_button">Update Product</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            <?php
                } else {
                    echo "Category Not found";
                }
            } else {
                echo "id Missing";
            }
            ?>

        </div>
    </div>
</div>
</div>
<?php include('includes/footer.php') ?>