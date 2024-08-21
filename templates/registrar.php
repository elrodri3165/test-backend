<div class="container">
    <h3 class="text-center">Registro</h3>
    <form class="" method="post" action="{ruta}crear-usuario" id="form_registro" onsubmit="AbrirModalLoading()">

        <input type="hidden" name="token" value="{token}" id="token">

        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control rounded-3" id="email" placeholder="name@example.com" onblur="ValidarEmail()" required autocomplete="email">
            <label for="email">Email</label>
        </div>

        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control rounded-3" id="password_register" placeholder="Password" required autocomplete="new-password">
            <label for="password_register">Password</label>
        </div>

        <div class="form-floating mb-3">
            <input type="password" name="password2" class="form-control rounded-3" id="password_register2" placeholder="Password" onblur="ValidarPass()" required autocomplete="off">
            <label for="password_register2">Repita el password</label>
        </div>


        <div class="form-floating mb-3">
            <input type="text" name="apellido" class="form-control rounded-3" id="apellido" placeholder="Apellido" required>
            <label for="apellido">Apellido</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text" name="nombre" class="form-control rounded-3" id="nombre" placeholder="Nombre" required>
            <label for="apellido">Nombre</label>
        </div>

        <button class="w-100 mb-2 btn btn-lg rounded-3 btn btn-primary" type="submit" id="boton">Registrarme</button>

        <a class="w-100 mb-2 btn btn-lg rounded-3 btn btn-secondary" href="{ruta}">Volver</a>

        <small class="text-muted">Al hacer clic en Registrarme, acepta los términos de uso y condiciones</small>

        <div class="d-flex justify-content-center">
            <a class="btn btn-link p-0" href="{ruta}olvide-mi-password">Olvide mi contraseña</a>
        </div>
    </form>
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-primary">
                <strong class="me-auto text-white">Atención!!!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toast-body">

            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalLoading" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body p-5 m-5">
                <div class="d-flex justify-content-center">
                    <img src="{ruta}img/sh1-removebg-preview-e1668097413884.png" style="max-width:300px;" alt="Logo Somoshermanas">
                </div>
                <p class="h1 text-center">Por favor espere mientas generamos la cuenta usuario...</p>
                <div class="d-flex justify-content-center">
                    <div class="spinner-grow bg-sh-secondary" style="width:150px;height:150px;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<script>
    const toastLiveExample = document.getElementById('liveToast');

    function ValidarEmail() {
        email = $('#email').val();
        var exp = /\w+@\w+\.+[a-z]/;

        if (email != null && email != ''){
            if (!exp.test(email)) {
                const toast = new bootstrap.Toast(toastLiveExample);
                $('#toast-body').empty().append('Por favor coloque un mail válido!');
                toast.show();
            }
        }
    }


    $("#email").change(function() {

        email = $('#email').val();
        token = $('#token').val();
        let datos = new FormData();
        datos.append("email", email);
        datos.append("token", token);


        $.ajax({
            url: "{ruta}buscar-email-user",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {
                if (respuesta != null) {
                    $("#email").val("");
                    const toast = new bootstrap.Toast(toastLiveExample);
                    $('#toast-body').empty().append('Este email ya se encuentra registrado en nuestra base de datos!!!');
                    toast.show();
                } else {
                    ValidarEmail();
                }
            },
        });
    });

 