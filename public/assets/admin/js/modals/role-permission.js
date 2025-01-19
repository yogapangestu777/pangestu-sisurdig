$(document).ready(function () {
    $("#create-modal").on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget)
        const data = {
            title: button.data("title"),
            url: button.data("url"),
            method: button.data("method"),

            name: button.data("name"),
            permissions: button.data("permissions"),
        }

        $(".modal-title").text(data.title)
        $("#form").attr("action", data.url)
        $("#form-method").val(data.method)

        if (data.method === "put") {
            $("#name").val(data.name)
            $("input[name='permissions[]']").each(function () {
                const value = $(this).val()
                $(this).prop("checked", data.permissions.includes(value))
            })
        }
    })

    $("#create-modal").on("hidden.bs.modal", function () {
        const method = $("#form-method").val()
        if (method === "put") {
            $("#form")[0].reset();
        }
    })
})

