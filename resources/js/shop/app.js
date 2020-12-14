import "bootstrap";
import "bootstrap-input-spinner";
import "slick-carousel";
import "select2";
const feather = require("feather-icons");

require("./ajax");

const receipt_flag = $('meta[name="receipt"]').attr("content");

$(function() {
  let head_h = $("#header").outerHeight() + 16;
  let window_w = $(window).outerWidth();
  let telephone_no = '<meta name="format-detection" content="telephone=no">';

  // meta制御
  $("head meta:last").after(telephone_no);

  // featherIcons
  feather.replace({
    width: 18
  });

  // OnlyTOP
  if (receipt_flag == "on") {
    $("#FirstSelect").modal(
      {
        backdrop: "static"
      },
      "show"
    );
  }
  $("#changeDateBtn .link").on("click", function() {
    $("#FirstSelect").modal(
      {
        backdrop: "static"
      },
      "show"
    );
  });
  $("#salestop").modal("show");

  // STEP1
  $("#step1")
    .find(".btn")
    .on("click", function() {
      $("#set-service").val($(this).attr("name"));
      $("#step1").removeClass("show active");
      $("#step2").addClass("show active");
      $("#first-progress .steps").text("2/3");
      $("#first-progress .progress-bar").css("width", "33.33333%");
      $("#first-progress .progress-bar").attr("aria-valuenow", "33.33333");
    });
  // STEP2
  $("#step2")
    .find(".btn")
    .on("click", function() {
      $("#step2").removeClass("show active");
      $("#step3").addClass("show active");
      $("#first-progress .steps").text("3/3");
      $("#first-progress .progress-bar").css("width", "66.66666%");
      $("#first-progress .progress-bar").attr("aria-valuenow", "66.66666%");
    });
  // $("#step2")
  //   .find(".btn-step-back")
  //   .on("click", function() {
  //     $("#step2").removeClass("show active");
  //     $("#step1").addClass("show active");
  //     $("#first-progress .steps").text("1/3");
  //     $("#first-progress .progress-bar").css("width", "0");
  //     $("#first-progress .progress-bar").attr("aria-valuenow", "0");
  //   });
  // // STEP3
  // $("#step3")
  //   .find(".btn-step-back")
  //   .on("click", function() {
  //     $("#step3").removeClass("show active");
  //     $("#step2").addClass("show active");
  //     $("#first-progress .steps").text("2/3");
  //     $("#first-progress .progress-bar").css("width", "33.33333%");
  //     $("#first-progress .progress-bar").attr("aria-valuenow", "33.33333");
  //   });

  // スムーススクロール
  $(".smooth").on("click", function() {
    let speed = 500;
    let href = $(this).attr("href");
    let target = $(href == "#" || href == "" ? "html" : href);
    let position = target.offset().top - head_h;
    $("html, body").animate({ scrollTop: position }, speed, "swing");
    return false;
  });

  // SPメニュー
  $("#spopen, .overray, .spmenu-close").on("click", function() {
    $(this).toggleClass("active");
    $("#spmenu").toggleClass("active");
    $("body").toggleClass("spopen");
  });

  // bootstrap-input-spinner
  $(".num-spinner").inputSpinner();

  // slick
  $(".home-slide").slick({
    dots: true,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    centerMode: true,
    centerPadding: "10vw",
    autoplay: true,
    autoplaySpeed: 5000,
    arrows: false,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          centerMode: false,
          centerPadding: "0"
        }
      }
    ]
  });
  $(".modal-slide").slick({
    dots: true,
    infinite: true,
    speed: 300,
    autoplay: false,
    arrows: false
  });

  // carousel
  $(".carousel").carousel({
    interval: false
  });

  // --- home ------------------------------------ //
  if (window_w >= 990) {
    $("#catalog").addClass("container");
  }
  $(".addcart").on("click", function() {
    $(".modal").modal("hide");
  });
  $("#deliveryShop, #changeDeliveryShop").select2({
    theme: "bootstrap4",
    placeholder: "店舗を選択"
  });

  // STEP
  $("#deliveryTime").on("change", function() {
    if ($(this).children().length == $(this).prop("selectedIndex") + 1) {
      $("#deliverySeconds").val("00");
      $("#deliverySeconds").attr("disabled", true);
    } else {
      $("#deliverySeconds").attr("disabled", false);
    }
  });

  // --- cart ------------------------------------ //
  $(".okimochi-btns .btn").on("click", function() {
    $(".okimochi-btns .btn").removeClass("active");
    $(this).addClass("active");
    $("input#okimochi").val($(this).attr("data-price"));
  });
  $(".btn-cartdelete").on("click", function() {
    $('#cartdelete input[name="product_id"]').val($(this).attr("data-id"));
    $("#cartdelete").submit();
  });

  $("#width-login").on("click", function() {
    $("#cartform .seconds").append(
      '<input type="hidden" name="email" value="' +
        $("#login_email").val() +
        '" />'
    );
    $("#cartform .seconds").append(
      '<input type="hidden" name="password" value="' +
        $("#login_password").val() +
        '" />'
    );
    $("#cartform").submit();
  });

  // ジョイフルバトン
  $('input[name="joyful_flag"]').on("change", function() {
    let amount = Number($(".js-cart-amount").attr("data-amount"));
    if ($(this).val() == 0) {
      $("#joyful_no").collapse("hide");
      $(".js-cart-joyful").text(300);
      $(".js-cart-total").text((amount + 300).toLocaleString());
    } else {
      $("#joyful_no").collapse("show");
      $(".js-cart-joyful").text(0);
      $(".js-cart-total").text(amount.toLocaleString());
    }
  });

  // --- form ------------------------------------ //
  // 支払い方法
  if ($("select#pay").val() == 0 && $("select#pay").val() != "") {
    $("#payjp_checkout_box, #alert-cregit").css("display", "block");
  } else {
    $("#payjp_checkout_box, #alert-cregit").css("display", "none");
  }
  $("select#pay").on("change", function() {
    if ($(this).val() == 0 && $(this).val() != "") {
      $("#payjp_checkout_box, #alert-cregit").css("display", "block");
    } else {
      $("#payjp_checkout_box, #alert-cregit").css("display", "none");
    }
  });

  // 配送先
  $('input[name="delivery_place"]').on("change", function() {
    if ($(this).val() == 1) {
      $("#delivery_address").text("お届け先情報");
      $("#delivery-customer").css("display", "block");
    } else {
      $("#delivery_address").text("ご住所");
      $("#delivery-customer").css("display", "none");
    }
  });

  // クーポン
  $("#coupon").on("change", function() {
    if ($(this).val() != "") {
      $("#couponSuccess").css("display", "block");
    } else {
      $("#couponSuccess").css("display", "none");
    }
  });

  // 住所特定
  $(".js-address-kyoto").on("change", function() {
    let d_service = $("#js-delivery-address").attr("data-service");

    if (d_service == "ec") {
      let address_flag = $("#address1.js-address-kyoto")
        .val()
        .indexOf("京都市");
      if (address_flag == -1) {
        $("#alert-address").css("display", "block");
        $("#order-submit").attr("disabled", true);
      } else {
        $("#alert-address").css("display", "none");
        $("#order-submit").attr("disabled", false);
      }
    } else {
      $("#alert-address").css("display", "none");
      $("#order-submit").attr("disabled", false);
    }
  });

  // 購入画面
  $(".js-form-submit").on("submit", function() {
    $(this).find(".js-one-click").attr("disabled", true);
    $(this).find(".js-one-click").html(
      '<span class="d-inline-block mr-2">読込中</span><span class="spinner-border d-inline-block text-light spinner-border-sm" role="status"></span>'
    );
  });
});
