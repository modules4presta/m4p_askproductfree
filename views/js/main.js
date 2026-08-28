$(document).ready(function () {
  $("#send_askproduct").fancybox({
    hideOnContentClick: false,
  });
  $(document).on("click", "#send_ask_about_product", function (e) {
    e.preventDefault();
    sendEmailAboutProduct();
  });
});

function sendEmailAboutProduct() {
  var email = $.trim($("#askproduct_email").val() || "");
  var idProduct = parseInt($("#askproduct_id_product").val(), 10);
  var question = $.trim($("#askproduct_question").val() || "");

  if (!email || !idProduct || !question) {
    alert(m4p_askproductfree_problem);
    return;
  }

  var $button = $("#send_ask_about_product");
  $button.addClass("disabled").attr("aria-disabled", "true");

  $.ajax({
    url: m4p_askproductfree_frontcontroller,
    type: "POST",
    headers: { "cache-control": "no-cache" },
    data: {
      action: "askAboutProd",
      company: $("#askproduct_company").val() || "",
      phone: $("#askproduct_phone").val() || "",
      ask: question,
      email: email,
      id_product: idProduct,
    },
    dataType: "json",
    success: function (result) {
      if (result && result.success) {
        alert(result.message || m4p_askproductfree_confirmation);
        if ($.fancybox && $.fancybox.close) {
          $.fancybox.close();
        }
        $("#askproduct_question").val("");
      } else {
        alert((result && result.message) || m4p_askproductfree_problem);
      }
    },
    error: function () {
      alert(m4p_askproductfree_problem);
    },
    complete: function () {
      $button.removeClass("disabled").removeAttr("aria-disabled");
    },
  });
}
