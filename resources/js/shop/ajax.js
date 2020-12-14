const csrf = $('meta[name="csrf-token"]').attr("content");
const weeks_str = ["日", "月", "火", "水", "木", "金", "土"];

$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": csrf
  }
});

// カート追加
$(".addcart").on("click", function(event) {
  event.preventDefault();
  $form = $(this)
    .parents()
    .parents()
    .parents("form");
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": csrf
    },
    url: "/addcart",
    type: "POST",
    data: $form.serialize(),
    success: function(result) {
      alert("カートに追加されました");
      $(".cart-count, .cartstatus .count").text(result["total"]);
      $(".cartstatus .price").text(result["amount"].toLocaleString());
      $('input[name="options[]"]').prop("checked", false);
      $('input[name="quantity"]').val(1);
    },
    error: function(result) {
      alert("カート追加に失敗しました。再度お試しください。");
    }
  });
});

$(".js-cart-quantity").on("change", function() {
  let quantity = $(this).val();
  let index = $(this).attr("data-index");
  let price = $(this).attr("data-price");
  let old_quantity = $(this).attr("data-quantity");
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": csrf
    },
    url: "/change-quantity",
    type: "POST",
    data: {
      index: index,
      old_quantity: old_quantity,
      quantity: quantity,
      price: price
    },
    success: function(result) {
      location.reload();
    },
    error: function(result) {
      console.log(result);
    }
  });
});

// サービス選択
$("#step1 .btn-select").on("click", function() {
  setSelectService($(this).attr("name"));
});
$("#changeReceive").on("change", function() {
  setSelectService($(this).val());
});

// 店舗選択
$("#deliveryShop, #changeDeliveryShop").on("change", function() {
  if ($(this).val() != "" && $(this).val() != null) {
    setSelectShop($(this).val());
  }
});
$('#step2 button[name="next"]').on("click", function() {
  getBusinessTime($("#deliveryDate").val());
  getService();
});
$("#FirstSelect").on("show.bs.modal", function(e) {
  getBusinessTime($("#deliveryDate").val());
  getService();
});

// 受け取り時間選択
$("#deliveryDate, #changedeliveryDate").on("change", function() {
  getBusinessTime($(this).val());
});

$("#nextstep3").on("click", function() {
  setSelectTime($("#deliveryDate").val(), $("#delivery_time").val());
});

$(".js-vali").on("change", function() {
  cartVali();
});

$(".btn-step-back").on("click", function() {
  resetSession();
});

// リセット
function resetSession() {
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": csrf
    },
    url: "/reset-session",
    type: "POST",
    success: function() {
      location.reload();
    }
  });
}

// お受け取り方法設定
function setSelectService(val) {
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": csrf
    },
    url: "/set-service",
    type: "POST",
    data: { service: val },
    success: function(service) {
      $("#deliveryShop").val("");
      if (service != "takeout") {
        let date =
          new Date().getFullYear() +
          "-" +
          (new Date().getMonth() + 1) +
          "-" +
          new Date().getDate();
        $("#step2").removeClass("show active");
        $("#step3").addClass("show active");
        getBusinessTime(date);
      }
    },
    error: function(e) {
      console.log(e);
    }
  });
}

// お受け取り店舗のセッション保存
function setSelectShop(id) {
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": csrf
    },
    url: "/set-select-shop",
    type: "POST",
    data: {
      delivery_shop: id
    },
    success: function(r) {
      $('#step2 button[name="next"]').attr("disabled", false);
    },
    error: function(e) {
      console.log(e);
    }
  });
}

// お受け取り店舗のセッション保存
function getService() {
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": csrf
    },
    url: "/get-service",
    type: "POST",
    success: function(r) {
      if (r == "takeout") {
        $("#deliveryDate option").remove();
        var start = new Date("12/18/2020");
        var end = new Date("12/24/2020");
        var loop = new Date(start);
        var temp_num = 0;
        while (loop <= end) {
          var newDate = loop.setDate(loop.getDate() + 1);
          loop = new Date(newDate);
          $("#deliveryDate").append(
            '<option value="' +
              formatDate(loop) +
              '">' +
              formatDateJp(loop) +
              "</option>"
          );
          if (temp_num == 0) {
            getBusinessTime(formatDate(loop));
          }
          ++temp_num;
        }
      } else {
        $("#deliveryDate option").remove();
        var start = new Date();
        for (let index = 0; index < 14; index++) {
          var newDate = start.setDate(start.getDate() + index);
          loop = new Date(newDate);
          $("#deliveryDate").append(
            '<option value="' +
              formatDate(loop) +
              '">' +
              formatDateJp(loop) +
              "</option>"
          );
          if (temp_num == 0) {
            getBusinessTime(formatDate(loop));
          }
        }
      }
    },
    error: function(e) {
      console.log(e);
    }
  });
}

// 営業時間取得
function getBusinessTime(date) {
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": csrf
    },
    url: "/get-business-time",
    type: "POST",
    data: {
      date: date
    },
    success: function(result) {
      if (result["service_flag"]) {
        $("#deliveryDate>option, #changedeliveryDate>option").prop(
          "disabled",
          false
        );
        $("#delivery_time, #changedeliveryTime")
          .children("option")
          .remove();
        $("#delivery_time, #changedeliveryTime").append(result["time"]);
        if (
          result["time"] == '<option value="">ご注文受け付け時間外です</option>'
        ) {
          $("#nextstep3, #changeReceiptBtn").attr("disabled", true);
        } else {
          $("#nextstep3, #changeReceiptBtn").attr("disabled", false);
        }
      } else {
        let min_days = result["min_days"];
        $("#nextstep3, #changeReceiptBtn").attr("disabled", false);
        $("#delivery_time, #changedeliveryTime")
          .children("option")
          .remove();
        $("#delivery_time, #changedeliveryTime").append(result["time"]);
        $("#deliveryDate>option, #changedeliveryDate>option").each(function(
          index,
          el
        ) {
          if (result["taget_date"] == $(this).val()) {
            $(this).prop("selected", true);
            return false;
          }
          // if (index < min_days) {
          //   $(this).prop("disabled", true);
          // } else {
          //   if (result["taget_date"] == $(this).val()) {
          //     $(this).prop("selected", true);
          //     return false;
          //   }
          // }
        });
      }
    },
    error: function(e) {
      console.log(e);
    }
  });
}

// 営業時間の表示
function setBusinessTime(el, business_day) {
  for (let i = 0; i < 7; i++) {
    let days = new Date();
    days.setDate(days.getDate() + i);
    let week = days.getDay();
    if (business_day[week] != null) {
      el.append(
        '<option value="' +
          getfterNdays(i) +
          '">' +
          getfterNdaysJp(i) +
          (i == 0 ? "（本日）" : "（" + weeks_str[week] + "）") +
          "</option>"
      );
    }
  }
}

// 受け取り時間のセッション保存
function setSelectTime(date, time) {
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": csrf
    },
    url: "/set-select-time",
    type: "POST",
    data: {
      date: date,
      time: time
    },
    success: function(r) {
      location.reload();
    },
    error: function(e) {
      console.log(e);
    }
  });
}

// カート商品購入可能精査
function cartVali() {
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": csrf
    },
    url: "/set-select-time",
    type: "GET",
    success: function(r) {
      location.reload();
    },
    error: function(e) {
      location.reload();
    }
  });
}

// 日付をYYYY-MM-DDの書式で返す関数
function formatDate(dt) {
  var y = dt.getFullYear();
  var m = ("00" + (dt.getMonth() + 1)).slice(-2);
  var d = ("00" + dt.getDate()).slice(-2);
  return y + "-" + m + "-" + d;
}

function formatDateJp(dt) {
  var y = dt.getFullYear();
  var m = ("00" + (dt.getMonth() + 1)).slice(-2);
  var d = ("00" + dt.getDate()).slice(-2);
  return y + "年" + m + "月" + d + "日";
}

function getfterNdays(n) {
  var dt = new Date();
  dt.setDate(dt.getDate() + n);
  return formatDate(dt);
}

function getfterNdaysJp(n) {
  var dt = new Date();
  dt.setDate(dt.getDate() + n);
  return formatDateJp(dt);
}
