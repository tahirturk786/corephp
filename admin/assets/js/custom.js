$(document).ready(function () {
  // This part ensures that the script runs when the document (HTML) is fully loaded.

  $(document).on("click", ".delete_product", function (e) {
    e.preventDefault();
    var id = $(this).val();
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          method: "POST",
          url: "code.php",
          data: {
            product_id: id,
            delete_product_btn: true,
          },
          success: function (response) {
            if (response == 200) {
              swal("Success!", "Product deleted Successfully", "success");
              $("#products_table").load(location.href + " #products_table");
            } else if (response == 500) {
              swal("Error!", "Something Went Wrong!", "error");
            }
          },
        });
      }
    });
  });

  //category Delete

  $(document).on("click", ".delete_category", function (e) {
    e.preventDefault();
    var id = $(this).val();
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          method: "POST",
          url: "code.php",
          data: {
            category_id: id,
            delete_category_btn: true,
          },
          success: function (response) {
            if (response == 200) {
              swal("Success!", "Category deleted Successfully", "success");
              $("#category_table").load(location.href + " #category_table");
            } else if (response == 500) {
              swal("Error!", "Something Went Wrong!", "error");
            }
          },
        });
      }
    });
  });
});
