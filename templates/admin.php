       <div id="myModal" class="modal" tabindex="-1">
           <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title">Algun dato estaba mal!</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <div class="modal-body">
                       <p>Debe completar todos los campos correctamente!</p>
                       <p>Complete la clave con letras o numeros validos!</p>
                       <p>Ningun campo puede estar vacio!</p>
                       <p>El usuario no puede ser mayor a 12 dígitos y la clave mayor a 10 dígitos</p>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                   </div>
               </div>
           </div>
       </div>
       <div class="container" style="height: 150px">
       {contenido}

       </div>
       <div class="container border rounded" style="max-width: 500px">

           <div class="p-3 mb-2 mt-2 bg-light text-dark rounded">
               {notificacion}
               <form class="row g-3 needs-validation" novalidate action="{ruta}validarlogin" method="post" onsubmit="return validarlogin()">

                   <div class="input-group mb-5 input-group-lg">
                       <span class="input-group-text" id="addon-wrapping"><i class="bi bi-person-fill"></i></span>
                       <input name="user" type="text" class="form-control" id="user" placeholder="Usuario" aria-label="Apellido" aria-describedby="addon-wrapping" required value="{usuario}">
                       <div class="invalid-feedback">
                           Por favor ingrese el usuario registrado
                       </div>
                       <div class="valid-feedback">
                           Correcto!
                       </div>
                   </div>

                   <div class="input-group mb-5 input-group-lg">
                       <span class="input-group-text" id="addon-wrapping"><i class="bi bi-key-fill"></i></span>
                       <input id="password" name="password" type="password" class="form-control" id="password" placeholder="Clave" aria-label="Clave" aria-describedby="addon-wrapping" required value="{clave}">
                       <div class="invalid-feedback">
                           Por favor ingrese la clave
                       </div>
                       <div class="valid-feedback">
                           Correcto!
                       </div>
                   </div>

                   <div class="d-grid gap-2 col-6 mx-auto">
                       <input class="btn btn-primary" type="submit" value="Ingresar">
                       <a class="btn btn-primary" href="{ruta}registrar-usuario">Registrarse</a>
                   </div>

               </form>
           </div>
       </div>
       <script src="js/validacion.js" type="text/javascript"></script>
       <script src="js/form-control.js" type="text/javascript"></script>
