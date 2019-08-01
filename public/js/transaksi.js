function getIndex() {
    $.get(`/api/cart`, function (data) {
        $(".itemRow").remove();
        $(".total").remove();
        var total = 0;
        Object.keys(data).forEach(dt => {
            total = total + (data[dt].price * data[dt].qty);
            $(`
            <tr class="itemRow">
                <td>${data[dt].product}</td>
                <td>${data[dt].price}</td>
                <td>${data[dt].qty}</td>
                <td><button class="btn btn-danger remove" data-id=${data[dt].id}><i class="fa fa-trash" aria-hidden="true"></i></button></td>
            </tr>
            `).insertAfter(".table-cart");

        });
        if (total <= 0) {
            $(".checkout").prop("disabled", true);
        } else {
            $(".checkout").prop("disabled", false);
        }
        $('.header').prepend(`<div class="d-inline total">Total : ${total}</div>`);
        $(".remove").click(function () {
            // Masih belum fix
            var id = $(this).data("id");
            $.ajax({
                url: `/api/cart/` + id,
                type: "DELETE",
                success: function (result) {
                    getIndex();
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
}
$(document).ready(function () {
    getIndex();
    $('.add').click(function () {
        const product_id = $(this).data("id");
        const user_id = $(this).data("user");
        data = { user_id, product_id };
        $.ajax({
            type: "post",
            url: `/api/cart`,
            data: data,
            success: function () {
                getIndex();
            },
            dataType: "json"
        });
    });
});