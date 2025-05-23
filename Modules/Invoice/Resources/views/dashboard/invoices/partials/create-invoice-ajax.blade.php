<script>
    $(".open-invoice-modal").on("click", function()
    {
        $("#create-invoice").find("input[type=text], textarea").val("");
        $("#share_tools").hide();
        $("#buttons").show();
    });

    $("form#create-invoice").on("submit", function(e)
    {
        e.preventDefault();
        var form_create = $(this);
        $.ajax({
            url: form_create.attr("action"),
            type: 'post',
            dataType: 'json',
            data: form_create.serialize(),
            success: function(data) {
                console.log(data['success']);
                if( data['success']==true )
                {
                    $("#share_tools").show();
                    $("#whatsapp").prop("href", 'https://wa.me/'+data['mobile']+'?text=' + data['link']);
                    $("#open").prop("href", data['link']);
                    $("#short").text(data['link']);
                    $("#shorten_link").val(data['link']);
                    $("#buttons").hide();
                } else {
                    $("#errors").show();
                    $("#errors_content").html(data['errors']);
                }
            }
        });
    })

    function copyPaymentLink() {
        // Get the text field
        var copyText = document.getElementById("shorten_link");

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);

        $("#copy_link").removeClass("btn-default");
        setTimeout(() => {$("#copy_link").addClass("btn-success");}, 50);
        setTimeout(() => {$("#copy_link").removeClass("btn-success");}, 70);
        setTimeout(() => {$("#copy_link").addClass("btn-default");}, 90);
        setTimeout(() => {$("#copy_link").removeClass("btn-default");}, 110);
        setTimeout(() => {$("#copy_link").addClass("btn-success");}, 130);
        setTimeout(() => {$("#copy_link").removeClass("btn-success");}, 150);
        setTimeout(() => {$("#copy_link").addClass("btn-default");}, 170);
    }
    </script>
