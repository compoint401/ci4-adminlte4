/**
 * =================================================================
 * Reusable Application-wide JavaScript
 * =================================================================
 */

if (typeof window.bootstrap !== "undefined" && window.bootstrap.Modal) {
  $(document).on('show.bs.modal', '.modal', function () {
    $(this).removeClass('fade');
    $(this).find('.modal-backdrop').removeClass('fade');
  });

  $(document).on('shown.bs.modal', '.modal', function () {
    $(this).removeClass('fade');
    $(this).find('.modal-backdrop').removeClass('fade');
  });

  if (typeof $.fn.modal !== "function") {
    $.fn.modal = function (command) {
      return this.each(function () {
        const modal = window.bootstrap.Modal.getOrCreateInstance(this);

        if (command === "show") {
          modal.show();
        } else if (command === "hide") {
          modal.hide();
        } else if (command === "toggle") {
          modal.toggle();
        }
      });
    };
  }
}

/**
 * Handles form submissions via AJAX.
 * @param {HTMLFormElement} form - The form element to be submitted.
 * @param {function} [successCallback] - Optional callback function to run on successful submission.
 *                                       Receives the server response data as an argument.
 *                                       If not provided, a default success behavior is executed.
 */
function handleFormSubmit(form, successCallback) {
  $.ajax({
    url: $(form).attr("action"),
    method: $(form).attr("method"),
    data: new FormData(form),
    processData: false,
    dataType: "json",
    contentType: false,
    beforeSend: function () {
      // Clear previous Bootstrap validation states
      $(form).find(".is-invalid").removeClass("is-invalid");
      $(form).find(".invalid-feedback").remove();
      $(form).find('button[type="submit"]').prop("disabled", true);
    },
    success: function (data) {
      if ($.isEmptyObject(data.errors)) {
        if (data.code == 1) {
          if (typeof successCallback === "function") {
            successCallback(data);
          } else {
            // Default success behavior
            const tableId = $(form).data("table");
            if (tableId) {
              $(tableId).DataTable().ajax.reload(null, false);
            }
            const modalId = $(form).closest(".modal").attr("id");
            if (modalId) {
              $("#" + modalId).modal("hide");
            }
            toastr.success(data.msg);
          }
        } else {
          toastr.error(data.msg || "An unexpected error occurred.");
        }
      } else {
        // Validation failed, display errors using Bootstrap classes
        $.each(data.errors, function (prefix, val) {
          var field = $(form).find('[name="' + prefix + '"]');
          field.addClass("is-invalid");
          // Add the error message display
          field.after(
            '<div class="invalid-feedback d-block">' + val + "</div>"
          );
        });
        toastr.error(data.msg || "Please correct the errors and try again.");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // Use toastr for consistency
      toastr.error("A server error occurred: " + errorThrown);
    },
    complete: function () {
      $(form).find('button[type="submit"]').prop("disabled", false);
    },
  });
}

/**
 * Handles form submissions via AJAX.
 * @param {HTMLFormElement} form - The form element to be submitted.
 * @param {function} [successCallback] - Optional callback function to run on successful submission.
 *                                       Receives the server response data as an argument.
 *                                       If not provided, a default success behavior is executed.
 */
function handleOldFormSubmit(form, successCallback) {
  $.ajax({
    url: $(form).attr("action"),
    method: $(form).attr("method"),
    data: new FormData(form),
    processData: false,
    dataType: "json",
    contentType: false,
    beforeSend: function () {
      $(form).find("span.error-text").text("");
    },
    success: function (data) {
      if ($.isEmptyObject(data.errors)) {
        if (data.code == 1) {
          if (typeof successCallback === "function") {
            successCallback(data);
          } else {
            $(form)[0].reset();
            // Default success behavior
            const tableId = $(form).data("table");
            if (tableId) {
              $(tableId).DataTable().ajax.reload(null, false);
            }
            // Explicitly blur the active element before hiding the modal to prevent focus warnings.
            if (document.activeElement) {
              document.activeElement.blur();
            }
            const $modal = $(form).closest(".modal");
            if ($modal.length) {
              $modal.modal("hide");
            }
            toastr.success(data.msg);
          }
        } else {
          $.each(data.error, function (prefix, val) {
            $(form)
              .find("span." + prefix + "_error")
              .text(val);
          });
          toastr.error(data.msg || "Please correct the errors and try again.");
        }
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // Use toastr for consistency
      toastr.error("A server error occurred: " + errorThrown);
    },
    complete: function () {
      $(form).find('button[type="submit"]').prop("disabled", false);
    },
  });
}

/**
 * Sets up a delete confirmation dialog.
 * @param {string} buttonSelector - The jQuery selector for the delete button(s).
 * @param {string} entityName - The name of the entity being deleted (e.g., 'Delivery', 'User').
 * @param {tableId} - name of table to reload after delete.
 */
function handleConfirmation(buttonSelector, actionName, entityName, tableId) {
  const entityId = $(buttonSelector).data("id");
  const url = $(buttonSelector).data("url");

  const csrfName = $("meta.csrf").attr("name");
  const csrfHash = $("meta.csrf").attr("content");

  Swal.fire({
    title: "Are you sure?",
    html: `You want to ${actionName} this ${entityName}: <b>${entityId}</b>`,
    showCloseButton: true,
    showCancelButton: true,
    cancelButtonText: "Cancel",
    confirmButtonText: `Yes, ${actionName}`,
    cancelButtonColor: "#d33",
    confirmButtonColor: "#556eeb",
    width: 300,
    allowOutsideClick: false,
  }).then(function (result) {
    if (result.value) {
      $.post(
        url,
        {
          [csrfName]: csrfHash,
          id: entityId, // Use a consistent parameter name 'id'
        },
        function (data) {
          if (data.code == 1) {
            if (tableId) {
              $(tableId).DataTable().ajax.reload(null, false);
            }
            toastr.success(data.msg);
          } else {
            toastr.error(data.msg);
          }
        },
        "json"
      ).fail(function (response) {
        toastr.error("Failed to " + actionName + " : " + response.responseText);
      });
    }
  });
}

const falsyToZero = (value) =>
  value === null || isNaN(value) || value === false ? 0 : value;
const getInputIDVal = (e, v) => falsyToZero(parseFloat($(e).find(v).val()));

// This handler will clear validation errors on input change.
$(document).on("input change", ".is-invalid", function () {
  // Remove the error state from the current input field
  $(this).removeClass("is-invalid");
  $(this).siblings(".invalid-feedback").remove();

  // Find the form this input belongs to
  const $form = $(this).closest("form");

  // Re-enable the form's submit button
  $form.find('button[type="submit"]').prop("disabled", false);
});
