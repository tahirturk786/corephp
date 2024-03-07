<?php
include('includes/header.php');
include('../middleware/adminMiddleware.php')
?>
<div class="container-fluid">
    <div class="row">
        <div class="row">
            <div class="col-sm-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">All Products</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">category</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ID</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trending</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Operations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        $products = mysqli_query($con, "SELECT products.*, categories.id AS category_id, categories.name AS category_name
                                        FROM products
                                        JOIN categories ON products.category_id = categories.id");

                                        if ($products) {
                                            while ($item = mysqli_fetch_assoc($products)) {
                                        ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="../uploads/<?= $item['image'] ?>" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                </div>

                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?= $item['name']; ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?= $item['category_name']; ?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?= $item['id']; ?></p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm <?= $item['status'] == '0' ? "bg-gradient-danger" : "bg-gradient-success"; ?>">
                                                <?= $item['status'] == '0' ? "hidden" : "visible"; ?>
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm <?= $item['trending'] == '0' ? "bg-gradient-danger" : "bg-gradient-success"; ?>">
                                                <?= $item['status'] == '0' ? "Trending" : "Not Trending"; ?>
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold"><?= $item['created_at']; ?></span>
                                        </td>
                                        <td class="align-middle text-center d-flex justify-content-center">
                                            <span class=" mr-2">
                                                <a href="edit-product.php?id=<?= $item['id']; ?>" data-toggle="tooltip"><i class="fa-solid fa-pen-to-square"></i></a>
                                            </span>



                                            <span class="ms-2">
                                                <a href="code.php?id=<?= $item['id']; ?>" data-toggle="tooltip">
                                                    <i class="fa-solid fa-copy"></i>
                                                </a>
                                            </span>
                                            <form action="code.php" method="POST">
                                                <span class="ms-2">
                                                    <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                                                    <button type="submit" class="border-0" name="delete_product_btn">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </span>
                                            </form>
                                        </td>

                                    </tr>
                            <?php
                                            }
                                        } else {
                                            "No Record Found";
                                        }
                            ?>
                            </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php') ?>