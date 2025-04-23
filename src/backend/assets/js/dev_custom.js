function toggleSwitchStatus(el, table) {
  var column_id = el.value;
  var column_name = el.name;
  var column_val = 0;
  if (el.checked) {
    var column_val = 1;
  }

  var full_url = getBaseUrl() + '/admin/toggle/switch/status'

  $.post(full_url, {
    _token: getCsrfToken(),
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

function getBaseUrl() {
  var protocol = window.location.protocol; // "http:" or "https:"
  var host = window.location.host; // "example.com" or "localhost:8000"
  return protocol + "//" + host;
}

function getCsrfToken() {
  return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

function SwalNotification(title, text, icon) {
  Swal.fire({
    title: title,
    text: text,
    icon: icon,  // 'warning', 'error', 'success', 'info', 'question'
    confirmButtonText: 'OK'
  });
}


function SwalFlash(result, title, text, icon = 'success') {
  Swal.fire({
    toast: result,
    position: 'top-right',
    icon: icon, /// 'warning', 'error', 'success', 'info', 'question'
    title: title,
    text: text,
    showConfirmButton: false, // Hide the confirmation button
    timer: 3000 // Auto-close after 3 seconds
  });
}