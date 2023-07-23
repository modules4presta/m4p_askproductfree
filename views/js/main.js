$("document").ready(function () {
  $("#send_askproduct").fancybox({
    hideOnContentClick: false,
  });
  $("#send_ask_about_product").click(function () {
    sendEmailAboutProduct();
  });
});

function sendEmailAboutProduct() {
  const email = $("#askproduct_email").val();

  if (email && !isNaN($("#askproduct_id_product").val())) {
    $.ajax({
      url:
        m4p_askproductfree_frontcontroller +
        "&" +
        $("#add-to-cart-or-refresh").serialize(),
      type: "POST",
      headers: { "cache-control": "no-cache" },
      data: {
        action: "askAboutProd",
        company: $("#askproduct_company").val(),
        phone: $("#askproduct_phone").val(),
        ask: $("#askproduct_question").val(),
        email: $("#askproduct_email").val(),
        id_product: $("#askproduct_id_product").val(),
      },
      dataType: "json",
      success: function (result) {
        alert(
          result ? m4p_askproductfree_confirmation : m4p_askproductfree_problem
        );
      },
    });
  } else {
    alert("Error");
  }
}
