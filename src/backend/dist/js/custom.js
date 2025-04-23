$(function () {
    "use strict";

    // Feather Icon Init Js
    feather.replace();

    $(".preloader").fadeOut();

    // this is for close icon when navigation open in mobile view
    $(".nav-toggler").on('click', function () {
        $("#main-wrapper").toggleClass("show-sidebar");
        $(".nav-toggler i").toggleClass("ti-menu");
    });

    // ==============================================================
    // Right sidebar options
    // ==============================================================
    $(function () {
        $(".service-panel-toggle").on('click', function () {
            $(".customizer").toggleClass('show-service-panel');

        });
        $('.page-wrapper').on('click', function () {
            $(".customizer").removeClass('show-service-panel');
        });
    });

    // ==============================================================
    //tooltip
    // ==============================================================
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    // ==============================================================
    //Popover
    // ==============================================================
    $(function () {
        $('[data-toggle="popover"]').popover()
    })

    // ==============================================================
    // Perfact scrollbar
    // ==============================================================
    $('.message-center, .customizer-body, .scrollable, .scroll-sidebar').perfectScrollbar({
        wheelPropagation: !0
    });

    // ==============================================================
    // Resize all elements
    // ==============================================================
    $("body, .page-wrapper").trigger("resize");
    $(".page-wrapper").delay(20).show();
    // ==============================================================
    // To do list
    // ==============================================================
    $(".list-task li label").click(function () {
        $(this).toggleClass("task-done");
    });

    // ==============================================================
    // This is for the innerleft sidebar
    // ==============================================================
    $(".show-left-part").on('click', function () {
        $('.left-part').toggleClass('show-panel');
        $('.show-left-part').toggleClass('ti-menu');
    });

    // For Custom File Input
    $('.custom-file-input').on('change', function () {
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    })
});

function toggleSwitchStatus(el, table) {
    var column_id = el.value;
    var column_name = el.name;
    var column_val = 0;
    if (el.checked) {
      var column_val = 1;
    }
  
    var full_url = getBaseUrl() + '/admin/toggle/switch/status'
  
    $.post(full_url, {
      table: table,
      column: column_name,
      id: column_id,
      value: column_val
    }, function (data) {
      if (data == 1) {
        SwalFlash(true, "Success", "Updated!!", "success");
      } else {
        SwalFlash(false, "Erorr", "Failed!!", "error");
      }
    });
  }