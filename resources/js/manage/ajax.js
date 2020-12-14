import { Calendar } from "@fullcalendar/core";
import jaLocale from "@fullcalendar/core/locales/ja";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import bootstrapPlugin from "@fullcalendar/bootstrap";

require("jquery-ui/ui/widgets/sortable");
// require("jquery-ui-touch-punch");

const csrf = $('meta[name="csrf-token"]').attr("content");

$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": csrf
  }
});

// sort-table
$(".js-sort-table-menu").sortable({
  forceHelperSize: true,

  update: function(e, ui) {
    let sort_ids = $(this).sortable("toArray", { attribute: "data-id" });
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": csrf
      },
      url: "/manage/product/sort",
      type: "POST",
      data: { sort_ids: sort_ids },
      success: function(r) {
        alert("並び替えが更新されました");
      },
      error: function(e) {
        console.log(e);
      }
    });
  }
});
$(".js-sort-table-cat").sortable({
  forceHelperSize: true,

  update: function(e, ui) {
    let sort_ids = $(this).sortable("toArray", { attribute: "data-id" });
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": csrf
      },
      url: "/manage/product/category/sort",
      type: "POST",
      data: { sort_ids: sort_ids },
      success: function(r) {
        alert("並び替えが更新されました");
      },
      error: function(e) {
        console.log(e);
      }
    });
  }
});

// 在庫設定
let calendar;
$("#stock-btn").on("click", function() {
  let id = $(this).attr("data-id");
  setTimeout(function() {
    let calendarEl = document.getElementById("calendar");
    if (calendarEl != null) {
      calendar = new Calendar(calendarEl, {
        plugins: [interactionPlugin, dayGridPlugin, bootstrapPlugin],
        locale: jaLocale,
        initialView: "dayGridMonth",
        selectable: true,
        editable: true,
        selectLongPressDelay: 0,
        eventDurationEditable: false,
        events: "/manage/product/item/get-stock?id=" + id,

        // 変更処理
        eventClick: function(info) {
          let stock = prompt("在庫を半角数字で入力してください", info.title);
          if (stock != "" && stock != null) {
            let date = info.event.startStr;
            let product_id = id;
            editStock(stock, date, product_id);
          }
        }
      });
      calendar.render();
    }
  }, 500);
});

function editStock(stock, date, id) {
  $.ajax({
    url: "/manage/product/item/set-stock",
    type: "POST",
    data: {
      stock: stock,
      date: date,
      id: id
    },
    success: function() {
      alert("在庫が更新されました");
      calendar.refetchEvents();
    }
  });
}
