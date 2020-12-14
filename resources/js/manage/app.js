import "bootstrap";
import "bootstrap-input-spinner";
import "select2";

require("./ajax");

const feather = require("feather-icons");

$(function() {
  // featherIcons
  feather.replace({
    width: 18
  });

  // resize
  $(window).on("load resize", function() {
    let nav_h = $("#navbar").outerHeight();
    let window_w = $(window).width();
    // padding調整
    $("body").css("padding-top", nav_h + "px");
    if (window_w > 991.98) {
      $("#sidebarMenu").css("top", nav_h + "px");
    }
  });

  // SP Menu
  $(".navbar-toggle-btn, .orverray").on("click", function() {
    $("body").toggleClass("open");
    $("#sidebarMenu").toggleClass("open");
    $(this).toggleClass("active");
  });

  // --- Category ------
  // delete
  $('.js-delete-form button[type="submit"]').on("click", function() {
    if (window.confirm("同時に商品も削除されますがよろしいでしょうか？")) {
      return true;
    } else {
      return false;
    }
  });
  // edit
  $('[data-target="#editCategory"]').on("click", function() {
    $('#edit-category-form input[name="category_name"]').val(
      $(this).attr("data-name")
    );
    $('#edit-category-form input[name="category_id"]').val(
      $(this).attr("data-id")
    );
    $('#edit-category-form input[name="notice_email"]').val(
      $(this).attr("data-email")
    );
    $('#edit-category-form input[name="notice_tel"]').val(
      $(this).attr("data-tel")
    );
    $('#edit-category-form input[name="notice_fax"]').val(
      $(this).attr("data-fax")
    );
  });

  // --- Option ------
  // add
  $('[data-target="#addOption"]').on("click", function() {
    $('#add-option-form input[name="category_id"]').val(
      $(this).attr("data-id")
    );
  });
  // delete
  $('.js-delete-option button[type="submit"]').on("click", function() {
    if (window.confirm("削除します")) {
      return true;
    } else {
      return false;
    }
  });
  // edit
  $('[data-target="#editOption"]').on("click", function() {
    $('#edit-option-form input[name="option_name"]').val(
      $(this).attr("data-name")
    );
    $('#edit-option-form input[name="option_price"]').val(
      $(this).attr("data-price")
    );
    $('#edit-option-form input[name="option_id"]').val($(this).attr("data-id"));
  });

  // --- Post slide ------
  $(".form-img-change").on("change", function(e) {
    let file = e.target.files[0];
    let reader = new FileReader();
    let preview = $(this)
      .parent("label")
      .next(".form-img-preview");

    reader.onload = (function(file) {
      return function(e) {
        preview.empty();
        preview.append(
          $("<img>").attr({
            src: e.target.result,
            width: "200",
            title: file.name
          })
        );
      };
    })(file);
    reader.readAsDataURL(file);
  });

  $(".form-img-preview").on("click", function() {
    $(this)
      .prev(".form-img-label")
      .children('input[type="file"]')
      .val("");
    $(this)
      .children("img")
      .remove();
    $(this)
      .children('input[type="hidden"]')
      .remove();
  });

  // --- Item index ------
  $("#product_search_btn").on("click", function() {
    var re = new RegExp($("#product_search").val());
    $(".js-sort-table-menu tr").each(function() {
      console.log(txt);
      var txt = $(this)
        .find(".name")
        .html();
      if (txt.match(re) != null) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });

  // --- Add item ------
  // 予約公開設定
  if ($("#postPublic").prop("checked")) {
    $("#postPublic-date").css("display", "block");
  } else {
    $("#postPublic-date").css("display", "none");
    $("#postPublic-date")
      .find("input")
      .each(function() {
        $("#postPublic").val("");
      });
  }
  $("#postPublic").on("change", function() {
    if ($(this).prop("checked")) {
      $("#postPublic-date").css("display", "block");
    } else {
      $("#postPublic-date").css("display", "none");
      $("#postPublic-date")
        .find("input")
        .each(function() {
          $(this).val("");
        });
    }
  });
  // 店舗設定
  $('input[name="saleshop-flag"]').on("change", function() {
    if ($(this).val() != 0) {
      $("#saleshop").addClass("select2-multiple");
      $("#saleshop").css("display", "block");
      $(".select2-multiple").select2({
        theme: "bootstrap4",
        placeholder: "キーワードで検索",
        language: "ja"
      });
    } else {
      $("#saleshop").removeClass("select2-multiple");
      $("#saleshop").select2("destroy");
      $("#saleshop").css("display", "none");
    }
  });
});
