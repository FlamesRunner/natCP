 $(document).ready(function() {

            function loading() {
                $('#loginbtn').val('PLEASE WAIT...');

                $("#loginbtn").prop('disabled', false);
            }

            function formResult(data) {
                $('#content').html(data);
                $('#password').val('');
            }

            function onSubmit() {
                $('#authenticate').submit(function() {
                    var action = $(this).attr('action');
                    loading();
                    $.ajax({
                        url: "https://nat.andrew-hong.me/index.php",
                        type: 'POST',
                        data: {
                            user_name: $('#username').val(),
                            user_password: $('#password').val()
                        },
                        success: function(data) {
                            formResult(data);
                        },
                        error: function(data) {
                            formResult(data);
                        }
                    });
                    return false;
                });
            }
            onSubmit();

        });
