var contador=0;//variable de apoyo para determinar la identidad de cada producto

function Botones_Ventas() {
  
  $.ajax({
    type: "POST",
    url: "controlador/Botones_ventas.php",
    success:function(d) {
        $("#Botones_Ventas").html(d);
    }
  })

}

  function agregar_Productos_def() { //funcion del criss -----------------------------------
    //Lo mismo de arriba, pero mas simplificado
    contador += 1;
    var datos = {
      "producto":$("#producto").val(),
      "idcasilla":contador
    }
    $.ajax({
      type: "POST",
      url: "controlador/seleccionar_producto_ven.php",
      data:datos,
      success:function(d) {
          $("#producto").append(d);
      }
    })
    }

    $(document).ready(function() {
      $("#botonEliminar").click(eliminar_Productos_def);
    });


    $(document).on('change', '.producto, .unidad', function() {
      // Obtener el id_casilla del elemento que disparó el evento
      var id_casilla = obtenerIdCasilla($(this));
      validar_duplicacion(id_casilla);
    });
    
    function eliminar_Productos_def() {
      // Obtén el contador actual o ajústalo según tus necesidades
      var contadorE = obtenerContadorActual();
      
      if (contadorE >= 1) {
        // Selecciona y elimina solo el último elemento creado
        var ultimoElemento = contadorE;
        var producto = $("#producto" + ultimoElemento).val();
        var unidadMedida = $("#unidad_medida" + ultimoElemento).val();
        var cantidad = $("#cantidad" + ultimoElemento).val();
        var precio = $("#precio" + ultimoElemento).val();
        
        // Verifica si los elementos están vacíos antes de eliminarlos
        if (producto === "" && unidadMedida === "" && cantidad === "") {
          $("#producto" + ultimoElemento).remove();
          $("#unidad_medida" + ultimoElemento).remove();
          $("#cantidad" + ultimoElemento).remove();
          $("#precio" + ultimoElemento).remove();
          
          // Disminuye el contador en 1
          contadorE -= 1;
          actualizarContador(contadorE);
        }
      }
    }
    

    function obtenerContadorActual() {
      return contador;
    }

    function actualizarContador(contadorE) {
      if(contadorE>0){
        contador = contadorE;
      }
      else{
        contador = 0;
      }
    }

  function revelar_tabla() {
    $.get("./Elementos-Ocultos/tabla.html", function(data) {
      $("#Prueba_tablaOculta").html(data);
    });
  }

  function eliminar_inventario() {
    Swal.fire({
      title: 'Eliminar del inventario?',
      text: "No podras revocar esta accion",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire(
          'Eliminado!',
          'Se ha eliminado del inventario con exito',
          'success'
        )
      }
    })
  }

function AgregarVendedor() {
  if(document.getElementById("vendedor_nombre").value == ""){alert("por favor ingrese un nombre");document.getElementById("vendedor_nombre").focus();return false;}
  if(document.getElementById("vendedor_documento").value == ""){alert("por favor ingrese el numero de documeto");document.getElementById("vendedor_documento").focus();return false;}
  if(document.getElementById("vendedor_contraseña").value == ""){alert("por favor ingrese una contraseña");document.getElementById("vendedor_contraseña").focus();return false;}
  else{
  var datos = {
    "vendedor_nombre":$("#vendedor_nombre").val(),
    "vendedor_documento":$("#vendedor_documento").val(),
    "vendedor_contraseña":$("#vendedor_contraseña").val()
  }

  $.ajax({
    type: "POST",
    url: "controlador/agregar_vendedor.php",
    data:datos,
    success:function(d) {
      Swal.fire(
        'Creado!',
        'Has creado con exito el nuevo vendedor.',
        'Success'
      );
      // Redirigir a la misma página desde cero
      window.location.href = window.location.origin + window.location.pathname;
    }
    })
  }
}

function mostrar_vendedores() {

  $.ajax({
    type: "POST",
    url: "controlador/mostrar_vendedores.php",
    success:function(d) {
        
        $("#lista_vendedores").html(d);
    }
  })
  
}

function eliminar_vendedor(idvendedores) {

  Swal.fire({
    title: 'Descartar este vendedor?',
    text: "No podras revocar esta opcion",
    icon: 'Warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: 'Success',
    confirmButtonText: 'Descartar'
  }).then((result) => {
    if (result.isConfirmed) {

      var datos = { //capturo los datos
        "idvendedores":idvendedores
      };
  
      $.ajax({
        type: "POST",
        url: "controlador/eliminar_vendedor.php",
        data:datos,
        success:function(d) {
          Swal.fire(
            'Eliminado!',
            'Has eliminado con exito este vendedor.',
            'Success'
          );
          mostrar_vendedores();
        }
      })  
    }
  })
  }

  function mostrar_datos_vendedor(idvendedores) {
    var datos = { //capturo los datos
      "idvendedores":idvendedores
    };
    $.ajax({
      type: "POST",
      url: "controlador/mostrar_datos_vendedor.php",
      data:datos,
      success:function(d) {
          
          $("#mostrar_datos_vendedor").html(d);
      }
    })
    
  }

  function EditarVendedor(idvendedores) {
    if($("#vendedor_nombre_edi").val() == "")
    {alert("por favor ingrese un nombre");document.getElementById("vendedor_nombre_edi").focus();
    return false;}
    if($("#vendedor_cc_edi").val() == "")
    {alert("por favor ingrese un numero de documento");document.getElementById("vendedor_cc_edi").focus();
    return false;}
    if($("#vendedor_contraseña_edi").val() == "")
    {alert("por favor ingrese una contraseña");document.getElementById("vendedor_contraseña_edi").focus();
    return false;}
    else{
      Swal.fire({
        title: 'editar este vendedor?',
        text: "No podras revocar esta opcion",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: 'success',
        confirmButtonText: 'Editar'
      }).then((result) => {
        if (result.isConfirmed) {
    
          var datos = { //capturo los datos
            "idvendedores":idvendedores,
            "vendedor_nombre":$("#vendedor_nombre_edi").val(),
            "vendedor_cc":$("#vendedor_cc_edi").val(),
            "vendedor_contraseña":$("#vendedor_contraseña_edi").val()
          };
      
          $.ajax({
            type: "POST",
            url: "controlador/editar_vendedor.php",
            data:datos,
            success:function(d) {
              Swal.fire(
                'editado!',
                'Has editado con exito este vendedor.',
                'success'
              );
              // Redirigir a la misma página desde cero
              window.location.href = window.location.origin + window.location.pathname;
            }
          }) 
        }
      })
    }
  }

  function seleccionar_vendedor() {

    $.ajax({
      type: "POST",
      url: "controlador/seleccionar_vendedor.php",
      success:function(d) {
          
          $("#seleccionar_vendedor").html(d);
      }
    })

  }

  function seleccionar_producto_ven() {

    $.ajax({
      type: "POST",
      url: "controlador/seleccionar_producto_ven.php",
      success:function(d) {
          
          $("#seleccionar_producto_ven").html(d);
      }
    })
    
  }

  function valor_total() {
    var cantidad = [];
    var precios = [];
  
    $('.cantidad').each(function() {
      cantidad.push($(this).val());
    });
  
    $('.precio').each(function() {
      precios.push($(this).val());
    });
  
    var total = 0;
  
    for (let i = 0; i < cantidad.length; i++) {
      var cantidadValor = parseFloat(cantidad[i]);
      var precioValor = parseFloat(precios[i]);
  
      if (!isNaN(cantidadValor) && !isNaN(precioValor)) {
        total += cantidadValor * precioValor;
      }
    }
  
    if (!isNaN(total)) {
      var mensaje2 = 'Total a consignar: ' + total;
      document.getElementById("valor_total").value = total;
    }
  }

  function valor_devolver() {
    var total = [];
    var pagado = [];
  
    $('#valor_total').each(function() {
      total.push($(this).val());
    });
  
    $('#cantidad_pagada').each(function() {
      pagado.push($(this).val());
    });
  
    var devuelto = pagado - total;
  
    if (!isNaN(devuelto) && devuelto > 0) {
      var mensaje2 = 'Total a consignar: ' + total;
      document.getElementById("devuelto").value = devuelto;
    }
    else
    {
      document.getElementById("devuelto").value = 0;
    }
  }

  function precio_renovar(id_casilla) {
    var nombre_id = "precio" + id_casilla;
    var producto_id = "producto" + id_casilla;
    var cantidad_id = "cantidad" + id_casilla;
    var precio = 0;
    var cantidad=0; 
    var idunidad_medida = "unidad_medida" + id_casilla;
    var idmedida = document.getElementById(idunidad_medida).value;
    if(idmedida == 1)
    {
      precio = $("#" + producto_id + " option:selected").attr("data-precio");
    }
    if(idmedida == 2)
    {
      precio = $("#" + producto_id + " option:selected").attr("data-bulto");
    }
    document.getElementById(nombre_id).value = precio;
    cantidad = $("#" + producto_id + " option:selected").attr("data-cantidad");
    document.getElementById(cantidad_id).max=cantidad;
   }

   function seleccionar_cliente() {

    $.ajax({
      type: "POST",
      url: "controlador/seleccionar_cliente.php",
      success:function(d) {
          
          $("#seleccionar_cliente").html(d);
      }
    })
    
  }

  function AgregarCliente() {
    if(document.getElementById("cliente_nombre").value == ""){alert("por favor ingrese un nombre");document.getElementById("cliente_nombre").focus();return false;}
    if(document.getElementById("documento").value == ""){parseFloat(alert("por favor escriba el numero de documento del vendedor"));document.getElementById("cliente_nombre").focus();return false;}
    else{
    var datos = {
      "cliente_nombre":$("#cliente_nombre").val(),
      "cliente_telefono":$("#cliente_telefono").val(),
      "cliente_direccion":$("#cliente_direccion").val(),
      "email":$("#email").val(),
      "documento":$("#documento").val()
    }
  
    $.ajax({
      type: "POST",
      url: "controlador/agregar_cliente.php",
      data:datos,
      success:function(d) {
        Swal.fire(
          'Creado!',
          'Has creado con exito el nuevo cliente.',
          'success'
        );
        // Redirigir a la misma página desde cero
        window.location.href = window.location.origin + window.location.pathname;
      }
      })
    }
  }

  function mostrar_clientes() {

    $.ajax({
      type: "POST",
      url: "controlador/mostrar_clientes.php",
      success:function(d) {
          
          $("#lista_clientes").html(d);
      }
    })
    
  }

  function eliminar_cliente(idclientes) {

    Swal.fire({
      title: 'Descartar este cliente?',
      text: "No podras revocar esta opcion",
      icon: 'Warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: 'success',
      confirmButtonText: 'descartar'
    }).then((result) => {
      if (result.isConfirmed) {
  
        var datos = { //capturo los datos
          "idclientes":idclientes
        };
    
        $.ajax({
          type: "POST",
          url: "controlador/eliminar_cliente.php",
          data:datos,
          success:function(d) {
            Swal.fire(
              'Eliminado!',
              'Has eliminado con exito este cliente.',
              'success'
            );
            mostrar_clientes();
          }
        })  
      }
    })
    }

    function mostrar_datos_cliente(idclientes) {
      var datos = { //capturo los datos
        "idclientes":idclientes
      };
      $.ajax({
        type: "POST",
        url: "controlador/mostrar_datos_cliente.php",
        data:datos,
        success:function(d) {
            
            $("#mostrar_datos_cliente").html(d);
        }
      })
      
    }

    function EditarCliente(idcliente) {
      if($("#cliente_nombre_edi").val() == "")
      {alert("por favor ingrese un nombre");document.getElementById("cliente_nombre_edi").focus();
      return false;}
      if($("#documento_edi").val() == "")
      {alert("por favor ingrese un de documento");document.getElementById("documento_edi").focus();
      return false;}
      else{
        Swal.fire({
          title: 'Editar este cliente?',
          text: "No podras revocar esta opcion",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: 'success',
          confirmButtonText: 'Editar'
        }).then((result) => {
          if (result.isConfirmed) {
      
            var datos = { //capturo los datos
              "idcliente":idcliente,
              "cliente_nombre":$("#cliente_nombre_edi").val(),
              "telefono_cliente":$("#cliente_telefono_edi").val(),
              "direccion_cliente":$("#cliente_direccion_edi").val(),
              "email_cliente":$("#email_edi").val(),
              "documento_cliente":$("#documento_edi").val()
            };
        
            $.ajax({
              type: "POST",
              url: "controlador/editar_cliente.php",
              data:datos,
              success:function(d) {
                Swal.fire(
                  'editado!',
                  'Has editado con exito este cliente.',
                  'success'
                );
                // Redirigir a la misma página desde cero
                window.location.href = window.location.origin + window.location.pathname;
              }
            }) 
          }
        })
      }
    }
  

    function seleccionar_venta() {

      $.ajax({
        type: "POST",
        url: "controlador/seleccionar_venta.php",
        success:function(d) {
            
            $("#seleccionar_venta").html(d);
        }
      })
      
    }

   function Realizar_venta() {
    if(document.getElementById("seleccionar_vendedor").value == ""){alert("por favor seleccione un vendedor");document.getElementById("seleccionar_vendedor").focus();return false;}
    if(document.getElementById("seleccionar_cliente").value == ""){alert("por favor seleccione un cliente");document.getElementById("seleccionar_cliente").focus();return false;}
    if(document.getElementById("seleccionar_venta").value == ""){alert("por favor seleccione el tipo de venta");document.getElementById("seleccionar_venta").focus();return false;}
    if(document.getElementById("valor_total").value == ""){alert("por favor haga click en Agregar y seleciona un producto, una unidad de medida y escribe una cantidad");document.getElementById("agregar").focus();return false;}
    if(document.getElementById("valor_total").value == 0){alert("por favor escribe una cantidad mayor que 0 para el producto que se va a vender");document.getElementById("agregar").focus();return false;}
    if(document.getElementById("cantidad_pagada").value == ""){alert("por favor escriba la cantidad pagada por el cliente");document.getElementById("cantidad_pagada").focus();return false;}
    if(document.getElementById("seleccionar_venta").value == 1 && parseFloat(document.getElementById("valor_total").value) > parseFloat(document.getElementById("cantidad_pagada").value)){alert("por favor seleccione que el tipo de venta es a credito");document.getElementById("seleccionar_venta").focus();return false;}
    if(document.getElementById("seleccionar_venta").value == 2 && parseFloat(document.getElementById("valor_total").value) <= parseFloat(document.getElementById("cantidad_pagada").value)){alert("por favor seleccione que el tipo de venta es a contado");document.getElementById("seleccionar_venta").focus();return false;}
    else{
      var producto = [];
      var V_produc = 0; //valida cuantos productos hay seleccionados
      var V_cantidades = 0; //valida cuantas cantidades han sido digitadas
    
      $('.producto').each(function() {
        producto.push($(this).val());
        if ($(this).val() != "") {
          V_produc += 1; //Cuenta cuantos productos hay realmente
        };
      });
    
      var unidad = [];
    
      $('.unidad').each(function() {
        unidad.push($(this).val());
      });
    
      var cantidad = [];
    
      $('.cantidad').each(function() {
        cantidad.push($(this).val());
        if ($(this).val() != "" && $(this).val() != 0) {
          V_cantidades += 1; //Cuenta cuantas cantidades se digitaron
        };
      });
    
      if (V_produc == V_cantidades) {

    Swal.fire({
      title: 'Realizar venta?',
      text: "No podrás revocar esta acción!",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Realizar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {

        var datos = {
          "vendedor":$("#seleccionar_vendedor").val(),
          "cliente":$("#seleccionar_cliente").val(),
          "producto":producto,
          "unidad":unidad,
          "cantidad":cantidad,
          "valor_total":$("#valor_total").val(),
          "cantidad_pagada":$("#cantidad_pagada").val(),
          "seleccionar_venta":$("#seleccionar_venta").val(),
        }
    
        $.ajax({
          type: "POST",
          url: "controlador/realizar_venta.php",
          data:datos,
          success:function(d) {
            Swal.fire(
              'Realizado!',
              'Se ha realizado el venta con exito!',
              'success',
              
            );
            // Redirigir a la misma página desde cero
            window.location.href = window.location.origin + window.location.pathname;
          }
        })
      }
    })
      
  } else {
    alert("Hay cantidades vacias!")
  }

  

    }
  }

function Realizar_domicilio() {

  

  if(document.getElementById("seleccionar_vendedor").value == ""){alert("por favor seleccione un vendedor");document.getElementById("seleccionar_vendedor").focus();return false;}
    if(document.getElementById("seleccionar_cliente").value == ""){alert("por favor seleccione un cliente");document.getElementById("seleccionar_cliente").focus();return false;}
    if(document.getElementById("seleccionar_venta").value == ""){alert("por favor seleccione el tipo de venta");document.getElementById("seleccionar_venta").focus();return false;}
    if(document.getElementById("valor_total").value == ""){alert("por favor agregue click a agregar y seleciona un producto, una unidad de medida y escribe una cantidad");document.getElementById("agregar").focus();return false;}
    if(document.getElementById("valor_total").value == 0){alert("por favor escribe una cantidad mayor que 0 para el producto que se va a vender");document.getElementById("agregar").focus();return false;}
    if(document.getElementById("cantidad_pagada").value == ""){alert("por favor escriba la cantidad pagada por el cliente");document.getElementById("cantidad_pagada").focus();return false;}
    if(document.getElementById("seleccionar_venta").value == 1 && parseFloat(document.getElementById("valor_total").value) > parseFloat(document.getElementById("cantidad_pagada").value)){alert("por favor seleccione que el tipo de venta es a credito");document.getElementById("seleccionar_venta").focus();return false;}
    if(document.getElementById("seleccionar_venta").value == 2 && parseFloat(document.getElementById("valor_total").value) <= parseFloat(document.getElementById("cantidad_pagada").value)){alert("por favor seleccione que el tipo de venta es a contado");document.getElementById("seleccionar_venta").focus();return false;}
    else{

  var producto = [];
  var V_produc = 0; //valida cuantos productos hay seleccionados
  var V_cantidades = 0; //valida cuantas cantidades han sido digitadas

  $('.producto').each(function() {
    producto.push($(this).val());
    if ($(this).val() != "") {
      V_produc += 1; //Cuenta cuantos productos hay realmente
    };
  });

  var unidad = [];

  $('.unidad').each(function() {
    unidad.push($(this).val());
  });

  var cantidad = [];

  $('.cantidad').each(function() {
    cantidad.push($(this).val());
    if ($(this).val() != "" && $(this).val() != 0) {
      V_cantidades += 1; //Cuenta cuantas cantidades se digitaron
    };
  });

  if (V_produc == V_cantidades) {

    Swal.fire({
      title: 'Realizar venta?',
      text: "No podrás revocar esta acción!",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Realizar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
  
        var datos = {
          "vendedor":$("#seleccionar_vendedor").val(),
          "cliente":$("#seleccionar_cliente").val(),
          "producto":producto,
          "unidad":unidad,
          "cantidad":cantidad,
          "valor_total":$("#valor_total").val(),
          "cantidad_pagada":$("#cantidad_pagada").val(),
          "seleccionar_venta":$("#seleccionar_venta").val(),
        }
    
        $.ajax({
          type: "POST",
          url: "controlador/realizar_domicilio.php",
          data:datos,
          success:function(d) {
            Swal.fire(
              'Realizado!',
              'Se ha realizado la venta con èxito!',
              'success'
            );
            // Redirigir a la misma página desde cero
            window.location.href = window.location.origin + window.location.pathname;
          }
        })
      }
      })
    
  } else {
    alert("Hay cantidades vacias!")
  }

  

    }
  }

function tabla_historial_venta() {

  $.ajax({
    type: "POST",
    url: "controlador/tabla_historial_venta.php",
    success:function(d) {
        
        $("#tabla_historial_venta").html(d);
    }
  })
  
}

function validar_cantidad(id_casilla) { 
  var producto_id = "producto" + id_casilla;
  var cantidad_id = "cantidad" + id_casilla;
  var unidad_medida_id = "unidad_medida" + id_casilla;

  if ( $("#" + producto_id).val() == "") {
    alert("Selecciona un producto primero");
    $("#" + cantidad_id).val("");
    document.getElementById(unidad_medida_id).selectedIndex = 0;
  }
  valor_total();

  }

function validar_duplicacion(id_casilla) {
  var producto_id = "producto" + id_casilla;
  var unidad_medida_id = "unidad_medida" + id_casilla;
  var precio_id = "precio" + id_casilla;
  
  var Productos = [];
  var unidad_medida = [];


  $('.producto').each(function() {
    Productos.push($(this).val());
  });
  $('.unidad').each(function() {
    unidad_medida.push($(this).val());
  });

  for (let i = 0; i < Productos.length; i++) {
      if ($("#" + producto_id).val() == Productos[i] &&
          i != (id_casilla - 1) &&
          $("#" + producto_id).val() != "" &&
          $("#" + unidad_medida_id).val() == unidad_medida[i] &&
          i != (id_casilla - 1) &&
          $("#" + unidad_medida_id).val() != "") {
        alert("¡Ya se ha seleccionado ese producto y con esa unidad de medida!");
        document.getElementById(producto_id).selectedIndex = 0;
        document.getElementById(unidad_medida_id).selectedIndex = 0;
        $("#" + precio_id).val("");
    }
  }
}

function validar_producto(id_casilla) {
  var producto_id = "producto" + id_casilla;
  var cantidad_id = "cantidad" + id_casilla;
  var unidad_medida_id = "unidad_medida" + id_casilla;

  // Verificar si el select de producto está vacío
  var selectProducto = $("#" + producto_id);
  if (selectProducto.val() === "") {
    alert("Se ha quitado el producto seleccionado!");
    $("#" + cantidad_id).val("");
    document.getElementById(unidad_medida_id).selectedIndex = 0;
    valor_total();
  }
  
}