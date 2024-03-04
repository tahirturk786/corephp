<?php

include('includes/header.php');
include('../middleware/adminMiddleware.php');
?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Product</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Product Name</label>
                                <input type="text" name="name" required placeholder="Enter Product Name" class="form-control mb-2">
                            </div>
                            <div class="col-md-6">
                                <label for="">slug</label>
                                <input type="text" name="slug" required placeholder="Enter Slug" class="form-control mb-2">
                            </div>
                            <div class="col-md-12 mt-4">
                                <select name="category_id" class="form-select form-control mb-2" required aria-label="">
                                    <option selected>Select Category</option>
                                    <?php
                                    $categories = getAll('categories');
                                    if (mysqli_num_rows($categories) > 0) {
                                        foreach ($categories as $item) {
                                    ?>
                                            <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
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
                                <textarea name="small_description" required rows="3" cols="50" class="form-control mb-2"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="">Description</label>
                                <textarea name="description" required rows="3" cols="50" class="form-control mb-2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="">Orignal Price</label>
                                <input type="text" name="orignal_price" required placeholder="Enter Orignal" class="form-control mb-2">
                            </div>
                            <div class="col-md-6">
                                <label for="">Selling Price</label>
                                <input type="text" name="selling_price" required placeholder="Enter Selling Price" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label for="">Upload Image</label>
                                <input type="file" required name="image" class="form-control mb-2">
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Quantity</label>
                                    <input type="number" name="qty" required placeholder="Enter Quantity" class="form-control mb-2">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Status</label> <br>
                                    <input type="checkbox" required name="status">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Trending</label> <br>
                                    <input type="checkbox" name="trending">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="">Meta Title</label>
                                <input type="text" name="meta_title" placeholder="Enter Meta Title" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label for="">Meta description</label>
                                <textarea name="meta_description" rows="3" cols="50" class="form-control mb-2" required></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="">Meta Keywords</label>
                                <input type="text" name="meta_keywords" placeholder="Enter Meta Keywords" class="form-control mb-2" required>
                            </div>

                            <div class="col-md-12 mt-5">
                                <button type="submit" class="btn btn-primary" name="add_product_button">Add Product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include('includes/footer.php') ?>