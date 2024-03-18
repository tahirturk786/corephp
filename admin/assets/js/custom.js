$(document).ready(function () {
  // This part ensures that the script runs when the document (HTML) is fully loaded.

  $(".delete_product").click(function (e) {
    // This targets an element with the ID 'delete_product' and attaches a click event listener to it.

    e.preventDefault();
    // This prevents the default action of the click event, which is usually following a link or submitting a form.
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
});
