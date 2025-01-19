$(document).ready(function () {
    $("#create-modal").on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget)
        const data = {
            title: button.data("title"),
            url: button.data("url"),
            method: button.data("method"),

            name: button.data("name"),
            type: button.data("type"),
            email: button.data("email"),
            phoneNumber: button.data("phone-number"),
            address: button.data("address"),
        }

        $(".modal-title").text(data.title)
        $("#form").attr("action", data.url)
        $("#form-method").val(data.method)

        if (data.method === "put") {
            $("#name").val(data.name)
            $("input[name='type'][value='" + data.type + "']").prop("checked", true)
            $("#email").val(data.email)
            $("#phone_number").val(data.phoneNumber)
            $("#address").val(data.address)
        }
    })

    $("#create-modal").on("hidden.bs.modal", function () {
        const method = $("#form-method").val()
        if (method === "put") {
            $("#form")[0].reset();
        }
    })
})

