function Botones_Inventario() {
  
  $.ajax({
    type: "POST",
    url: "controlador/Botones_Inventario.php",
    success:function(d) {
        $("#Botones_Inventario").html(d);
    }
  })

}
  
  
  
  var contador=0;//variable de apoyo para determinar la identidad de cada producto
  function Agregar_producto_renovar() {

    contador += 1;

    var datos = {
      "provedores_renovar":$("#provedores_renovar").val(),
      "idcasilla":contador
    }

    var proveedor = $("#provedores_renovar").val();

    if (proveedor == "" || proveedor == null) {
      alert("Debes de elegir un proveedor primero");      
    } else {
      $.ajax({
        type: "POST",
        url: "controlador/Agregar_producto_renovar.php",
        data:datos,
        success:function(d) {
            $("#Renovar_productos").append(d);
        }
      })
    }
    
  }
  
  function eliminar_Productos_def() {
    // Obtén el contador actual o ajústalo según tus necesidades
    var contadorE = contador;
    
    if (contadorE >= 1) {
      // Selecciona y elimina solo el último elemento creado
      var ultimoElemento = contadorE;
      var producto = $("#producto" + ultimoElemento).val();
      var cantidad = $("#cantidad" + ultimoElemento).val();
      var precio = $("#precio" + ultimoElemento).val();
      
      // Verifica si los elementos están vacíos antes de eliminarlos
      if (producto === "" && cantidad === "" && precio === "") {
        $("#producto" + ultimoElemento).remove();
        $("#cantidad" + ultimoElemento).remove();
        $("#precio" + ultimoElemento).remove();
        
        // Disminuye el contador en 1
        contador -= 1;
      }
    }
  }

  function Refrescar_seleccion() {
    $("#Renovar_productos").html("");
    $("#renovar_valor_total").val("");
    contador = 0;
  }

  function Realizar_Pedido() {
    var Productos = [];
    var V_produc = 0; //valida cuantos productos hay seleccionados
    var V_cantidades = 0; //valida cuantas cantidades han sido digitadas
  
    $('.productos_renovar').each(function() {
      Productos.push($(this).val());
      if ($(this).val() != "") {
        V_produc += 1; //Cuenta cuantos productos hay realmente
      }
    });

    var cantidad = [];
  
    $('.cantidad_renovar').each(function() {
      cantidad.push($(this).val());
      if ($(this).val() != "" && $(this).val() != 0) {
        V_cantidades += 1; //Cuenta cuantas cantidades se digitaron
      }
    });

    if (V_produc == 0) { //Alerta si no se han seleccionado productos
      alert("Se debe seleccionar almenos un producto!");
    } else { if (V_produc == V_cantidades) { //Revisa que las cantidades digitadas son iguales a la cantidad de productos

      Swal.fire({
        title: '¿Realizar Pedido?',
        text: "Podrás revocar esta acción después si deseas!",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Realizar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
  
          var datos = {
            "Productos":Productos,
            "cantidad":cantidad,
            "renovar_valor_total":$("#renovar_valor_total").val(),
            "provedores_renovar":$("#provedores_renovar").val(),
          }
      
          $.ajax({
            type: "POST",
            url: "controlador/Realizar_Pedido.php",
            data:datos,
            success:function(d) {
              Swal.fire(
                'Realizado!',
                'Se ha realizado el pedido con éxito!',
                'success'
              )
            }
          })

          provedores_renovar();

        }
      })
      
    } else { //alerta si hay cantidades vacias
      alert("Hay cantidades vacias!");
    }

      

    }

  }

  function renovar_valor_total() {
    var cantidad = [];
  
    $('.cantidad_renovar').each(function() {
      cantidad.push($(this).val());
    });

    var Precios = [];
  
    $('.precio_renovar').each(function() {
      Precios.push($(this).val());
    });

    var total = 0;
  
    for (let i = 0; i < cantidad.length; i++) {
      total += cantidad[i] * Precios[i];
    }

    var mensaje2 = 'Total a consignar: ' + total;

    document.getElementById("renovar_valor_total").value = total;
  }

  function cambiar_precio_compra(id_casilla) {
    var precio_id = "precio" + id_casilla;
    var producto_id = "producto" + id_casilla;
    var precio = $("#" + precio_id).val();
    var producto = $("#" + producto_id).val();
    //alert(producto + " vale: " + precio);

    var datos = {
      "precio":precio,
      "producto":producto,
      "proveedor":$("#provedores_renovar").val()
    }

    $.ajax({
      type: "POST",
      url: "controlador/cambiar_precio_compra.php",
      data:datos,
      success:function(d) {
                
      }
    })
    renovar_valor_total();
  }

  function validar_cantidad(id_casilla) {
    var producto_id = "producto" + id_casilla;
    var cantidad_id = "cantidad" + id_casilla;

    if ( $("#" + producto_id).val() == "") {
      alert("Selecciona un producto primero");
      $("#" + cantidad_id).val("");
    }
    renovar_valor_total();

  }

  function validar_duplicacion(id_casilla) {


    var producto_id = "producto" + id_casilla;
    
    var Productos = [];
  
    $('.productos_renovar').each(function() {
      Productos.push($(this).val());
    });
    for(let i = 0; i < Productos.length; i++) {
      if ( $("#" + producto_id).val() == Productos[i] 
            && i != (id_casilla - 1) 
            && $("#" + producto_id).val() != "" ) {
        alert("Ya se ha seleccionado ese producto!");
        document.getElementById(producto_id).selectedIndex = 0;
      }
    }
  }

  function precio_renovar(id_casilla) {
   validar_duplicacion(id_casilla);
   var nombre_id = "precio" + id_casilla;
   var producto_id = "producto" + id_casilla;
   var cantidad_id = "cantidad" + id_casilla;
   var precio = 0
   //precio = $("#" + producto_id + " option:selected").attr("data-precio");

    var datos = {
      "producto_id":$("#" + producto_id).val(),
      "proveedor":$("#provedores_renovar").val()
    };

    $.ajax({
      type: "POST",
      url: "controlador/precio_renovar.php",
      data:datos,
      success:function(d) {
        var cleanedValue = d.trim().replace(/[\r\n]+/g, '');
        precio = parseFloat(cleanedValue);
        $("#" + nombre_id).val(precio);
        if ($("#" + producto_id).val() == "") {
          document.getElementById(cantidad_id).value = "";
        };
        renovar_valor_total();
      }
    })

   
  }

  function mostrar_provedores() {

    $.ajax({
      type: "POST",
      url: "controlador/mostrar_proveedores_modal.php",
      success:function(d) {
          
          $("#lista_provedoores").html(d);
      }
    })
    
  }

  

  function mostrar_provedores_producto() {

    $.ajax({
      type: "POST",
      url: "controlador/mostrar_provedores_producto.php",
      success:function(d) {
          
          $("#proveedores_crear_producto").html(d);
      }
    })
    
  }

  function provedores_renovar() {

    $.ajax({
      type: "POST",
      url: "controlador/provedores_renovar.php",
      success:function(d) {
          
          $("#provedores_renovar").html(d);
      }
    })

    Refrescar_seleccion();

    
  }

  function pedidos_proveedores() {

    $.ajax({
      type: "POST",
      url: "controlador/pedidos_proveedores.php",
      success:function(d) {
          
          $("#Contenido_inventario").html(d);
      }
    })
    
  }

  function historial_ingreso(id_producto) {
    var datos = {
      "id_producto":id_producto
    }
    $.ajax({
      type: "POST",
      url: "controlador/historial_ingreso.php",
      data:datos,
      success:function(d) {
          
          $("#Contenido_inventario").html(d);
      }
    })
  }

  function productos_pedidos(id_acordeon) {
    habilitar_envios(id_acordeon);
    var tabla = 'tabla' + id_acordeon;

    var datos = {
      "id_acordeon":id_acordeon
    }

    $.ajax({
      type: "POST",
      url: "controlador/productos_pedidos.php",
      data:datos,
      success:function(d) {
        $("#"+tabla).html(d);
        habilitar_envios(id_acordeon);
      }
    })
  }

  function cancelar_pedido(id_pedido) {

    Swal.fire({
      title: '¿Cancelar el pedido?',
      text: "No podrán revocar esta opción",
      icon: 'warning',
      showCancelButton: true,
      //confirmButtonColor: '#d33',
      cancelButtonColor: 'success',
      confirmButtonText: 'No Recibir'
    }).then((result) => {
      if (result.isConfirmed) {

        var datos = { //capturo los datos
          "id_pedido":id_pedido
        };
    
        $.ajax({
          type: "POST",
          url: "controlador/cancelar_pedido.php",
          data:datos,
          success:function(d) {
            
            Swal.fire(
               'Cancelado!',
               'Se ha cancelado el pedido.',
               'success'
            );
            pedidos_proveedores();
          }
        })  
      }
    })

  }

  function recibir_pedido(id_pedido) {

    Swal.fire({
      title: 'Recibir el pedido?',
      text: "no podras revocar esta opcion",
      icon: 'warning',
      showCancelButton: true,
      //confirmButtonColor: '#d33',
      cancelButtonColor: 'success',
      confirmButtonText: 'Recibir'
    }).then((result) => {
      if (result.isConfirmed) {

        var datos = { //capturo los datos
          "id_pedido":id_pedido
        };
    
        $.ajax({
          type: "POST",
          url: "controlador/recibir_pedido.php",
          data:datos,
          success:function(d) {
            
            Swal.fire(
               'Recibido!',
               'Los productos se han agregado al inventario.',
               'success'
            );
            pedidos_proveedores();
          }
        })  
      }
    })

  }

  function validar_cantidad_recibida(id_pedido,id_casilla) {
    var max = parseFloat($("#producto"+id_casilla+"-"+id_pedido).attr("max"));
    var valor = parseFloat($("#producto"+id_casilla+"-"+id_pedido).val());

    if (max < valor) {
      $("#producto"+id_casilla+"-"+id_pedido).val(max);
    };

    habilitar_envios(id_pedido);
  }
  
  function habilitar_envios(id_pedido) {

    var cambios = 0;
    $('.productos_pedido' + id_pedido).each(function() { 
      
      var valor = parseFloat($(this).val());
      if ($(this).val() == "" || valor == 0) {
        
      } else {
        cambios += 1;
      }

    });

    var id_boton = "boton_recibir" + id_pedido;

    if (cambios == 0) {
      $("#" + id_boton).html('<button disabled type="button" onclick="recibir_productos(' + id_pedido + ')" class="btn btn-outline-success">Recibir</button>')
    } else {
      $("#" + id_boton).html('<button type="button" onclick="recibir_productos(' + id_pedido + ')" class="btn btn-outline-success">Recibir <span class="badge rounded-pill bg-success" id="Recibir_pedido' + id_pedido +'">' + cambios + '</span></button>')
    }

  }

  function recibir_productos(id_pedido) {
    var Cantidad = [];
    var Productos = [];

    $('.productos_pedido' + id_pedido).each(function() { 
      
      var valor = parseFloat($(this).val());
      if ($(this).val() == "" || valor == 0) {
        
      } else {
        Cantidad.push($(this).val());
        Productos.push($(this).attr("data-producto"));
      }

    });

    Swal.fire({
      title: '¿Recibir los productos digitados?',
      text: "No podrás revocar esta acción",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Realizar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {

        var datos = {
          "Productos":Productos,
          "Cantidad":Cantidad,
          "id_pedido":id_pedido
        }
    
        $.ajax({
          type: "POST",
          url: "controlador/recibir_productos.php",
          data:datos,
          success:function(d) {
            Swal.fire(
              'Recibidos!',
              'Se ha ingresado los productos seleccionados al inventario',
              'success'
            );
            productos_pedidos(id_pedido);
            if (d == "refrescar") {
              pedidos_proveedores();
            }
          }
        })

      }
    })

  }

  function tabla_inventario() {

    $.ajax({
      type: "POST",
      url: "controlador/tabla_inventario.php",
      success:function(d) {
          
          $("#Contenido_inventario").html(d);
          cambiar_estado_producto();
          Botones_Inventario();
          alertas();
      }
    })
    
  }

  function precioKL_inventario(id_inventario) {
    var input_id = "precio_kl" + id_inventario;
    var precio_kl = $("#" + input_id).val();

    
    var datos = {
      "id_inventario":id_inventario,
      "precio_kl":precio_kl
    }

    $.ajax({
      type: "POST",
      url: "controlador/precioKL_inventario.php",
      data:datos,
      success:function(d) {
        
      }
    })
   
  }

  function precioBL_inventario(id_inventario) {
    var input_id = "precio_bulto" + id_inventario;
    var precio_bulto = $("#" + input_id).val();

    
    var datos = {
      "id_inventario":id_inventario,
      "precio_bulto":precio_bulto
    }

    $.ajax({
      type: "POST",
      url: "controlador/precioBL_inventario.php",
      data:datos,
      success:function(d) {
        
      }
    })
   
  }

  function cambiar_estado_producto() {
    $.ajax({
      type: "POST",
      url: "controlador/cambiar_estado_producto.php",
      success:function(d) {
      }
    })
  }

  function F_vencimiento(id_inventario) {
    var input_id = "F_vencimiento" + id_inventario;
    var F_vencimiento = $("#" + input_id).val();

    

    var datos = {
      "id_inventario":id_inventario,
      "F_vencimiento":F_vencimiento
    }

    $.ajax({
      type: "POST",
      url: "controlador/F_vencimiento.php",
      data:datos,
      success:function(d) {
        cambiar_estado_producto();
        alertas();
      }
    })
   
  }

  function StockMinimo(id_inventario) {
    var input_id = "StockMinimo" + id_inventario;
    var StockMinimo = $("#" + input_id).val();

    

    var datos = {
      "id_inventario":id_inventario,
      "StockMinimo":StockMinimo
    }

    $.ajax({
      type: "POST",
      url: "controlador/StockMinimo.php",
      data:datos,
      success:function(d) {
        alertas();
      }
    })
   
  }

  function seleccionar_producto() {

    $.ajax({
      type: "POST",
      url: "controlador/seleccionar_producto.php",
      success:function(d) {
          
          $("#seleccionar_producto").html(d);
      }
    })
    
  }

  function validar_nombre_producto() {

    var datos = {
      "producto_nombre":$("#producto_nombre").val()
    };

    $.ajax({
      type: "POST",
      url: "controlador/validar_nombre_producto.php",
      data:datos,
      success:function(d) {

        if (d == "existe") {
          alert($("#producto_nombre").val() + " ya existe!, prueba con otro nombre");
          $("#producto_nombre").val("");
        }
        
        //document.getElementById("producto_nombre").value = "";
        
      }
    })
    
  }

  function informacion_cantidad_productos() {
    Swal.fire({
      title: 'Instrucciones: Contenido',
      icon: 'info',
      html:
        'En el apartado "Contenido" debes digitar la cantidad de producto que contiene el paquete o bulto. <br>' +
        
        '<b>Ejemplos de uso:</b> <br>' +
  
        '<div class="accordion" id="accordionExample">' +
          '<div class="accordion-item"><h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">'
            + 'Productos a granel' +
          '</button></h2>' +
          '<div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample"><div class="accordion-body">'
            
            + 'En el caso de productos en donde su venta es a granel: se digita el peso en kilos del bulto o paquete, <b>ejemplo:</b> Hay un producto llamado ponedora el cual el peso del bulto es 40 kg <br>' +
            '<div class="input-group mb-1"><span class="input-group-text" id="basic-addon1">Nombre:</span><input readonly type="text" class="form-control" value="Ponedora" aria-describedby="basic-addon3 basic-addon4"></div>' +
            '<div class="input-group mb-1"><span class="input-group-text" id="basic-addon1">Contenido:</span><input readonly type="number" class="form-control" value="40"><button type="button" class="btn btn-outline-primary"><i class="fa-solid fa-circle-question fa-lg"></i></button></div>' +
          
          '</div></div></div>' +
          '<div class="accordion-item"><h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">'
            + 'Productos empaquetados' +
            '</button></h2>' +
          '<div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample"><div class="accordion-body">'
            
            +  'En caso de productos que se venden por unidad pero se compran en paquetes: se digita el número de productos que hay en el paquete, <b>ejemplo:</b> Se compra un paquete de agujas que contiene 5 agujas <br>' +
            '<div class="input-group mb-1"><span class="input-group-text" id="basic-addon1">Nombre:</span><input readonly type="text" class="form-control" value="Aguja" aria-describedby="basic-addon3 basic-addon4"></div>' +
            '<div class="input-group mb-1"><span class="input-group-text" id="basic-addon1">Contenido:</span><input readonly type="number" class="form-control" value="5"><button type="button" class="btn btn-outline-primary"><i class="fa-solid fa-circle-question fa-lg"></i></button></div>' +
            
          '</div></div></div>' +
          '<div class="accordion-item"><h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">'
             + 'Productos unitarios' +
            '</button></h2>' +
          '<div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample"><div class="accordion-body">'
             
            + 'En caso de productos que se compran por unidad y se venden por unidad: se digita 1 por ser una compra unitaria, <b>ejemplo:</b> Se compran collares para perros <br>' +
             '<div class="input-group mb-1"><span class="input-group-text" id="basic-addon1">Nombre:</span><input readonly type="text" class="form-control" value="Collar Perro" aria-describedby="basic-addon3 basic-addon4"></div>' +
             '<div class="input-group mb-1"><span class="input-group-text" id="basic-addon1">Contenido:</span><input readonly type="number" class="form-control" value="1"><button type="button" class="btn btn-outline-primary"><i class="fa-solid fa-circle-question fa-lg"></i></button></div>' +
             
        '</div></div></div></div>',
      showCloseButton: true,
      focusConfirm: false,
      confirmButtonText:
        '<i class="fa fa-thumbs-up"></i> Entendido!',
      confirmButtonAriaLabel: 'Thumbs up, great!'
    })
  }

  function mostrar_productos() {

    $.ajax({
      type: "POST",
      url: "controlador/mostrar_productos.php",
      success:function(d) {
          
          $("#Contenido_inventario").html(d);
      }
    })
    
  }

  function mostrar_productos_deshabilitados() {

    $.ajax({
      type: "POST",
      url: "controlador/mostrar_productos_deshabilitados.php",
      success:function(d) {
          
          $("#Contenido_inventario").html(d);
      }
    })
    
  }

  function Cambiar_nombre_producto(input,id_producto) {
    
    if (input.value.trim() == "") {
      mostrar_productos();  
    } else {
      var datos = {
        "id_producto":id_producto,
        "nombre":input.value.trim()
      }
  
      $.ajax({
        type: "POST",
        url: "controlador/Cambiar_nombre_producto.php",
        data:datos,
        success:function(d) {
          mostrar_productos();
        }
      })
    }

     

  }

  function Cambiar_contenido(input,id_producto) {
    
    if (input.value == "" || input.value == 0) {
      mostrar_productos();
    } else {
      var datos = {
        "id_producto":id_producto,
        "valor":input.value
      }
  
      $.ajax({
        type: "POST",
        url: "controlador/Cambiar_contenido.php",
        data:datos,
        success:function(d) {
          mostrar_productos();
        }
      })
    }

      

  }

  function eliminar_producto(id_producto,validacion) {

    if (validacion > 0) {
      alert("Debes de quitar todos los proveedores relacionados con este producto antes de eliminarlo!");
    } else {

      Swal.fire({
        title: '¿Deshabilitar este producto?',
        text: "El producto no se mostrara en el inventario. Podras revocar esta accion despues",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5C636A',
        cancelButtonColor: '#6459DD',
        confirmButtonText: 'Deshabilitar'
      }).then((result) => {
        if (result.isConfirmed) {
  
          var datos = { //capturo los datos
            "id_producto":id_producto
          };
      
          $.ajax({
            type: "POST",
            url: "controlador/eliminar_producto.php",
            data:datos,
            success:function(d) {
              Swal.fire(
                'Deshabilitado!',
                'Has deshabilitado con éxito este producto.',
                'success'
              );
              mostrar_productos();
            }
          })  
        }
      })

    }
    
  }

  function habilitar_producto(id_producto,validacion) {

    if (validacion > 0) {
      alert("Debes de quitar todos los proveedores relacionados con este producto antes de eliminarlo!");
    } else {

      Swal.fire({
        title: 'Habilitar este producto?',
        text: "podrás revocar esta accion despues!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: 'success',
        confirmButtonColor: '#157347',
        confirmButtonText: 'habilitar'
      }).then((result) => {
        if (result.isConfirmed) {
  
          var datos = { //capturo los datos
            "id_producto":id_producto
          };
      
          $.ajax({
            type: "POST",
            url: "controlador/habilitar_producto.php",
            data:datos,
            success:function(d) {
              Swal.fire(
                'Habilitado!',
                'Has habilitado con éxito este producto.',
                'success'
              );
              mostrar_productos_deshabilitados();
            }
          })  
        }
      })

    }
    
  }

  function desasociar_proveedor(id_producto,id_proveedor) {
    Swal.fire({
      title: '¿Quitar este proveedor?',
      html: 'Puedes volverlo a asociar en <button type="button" class="btn btn-warning"><i class="fa-solid fa-circle-plus"></i> Productos</button> si te arrepientes!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: 'success',
      confirmButtonText: 'eliminar'
    }).then((result) => {
      if (result.isConfirmed) {

        var datos = { //capturo los datos
          "id_producto":id_producto,
          "id_proveedor":id_proveedor
        };
    
        $.ajax({
          type: "POST",
          url: "controlador/desasociar_proveedor.php",
          data:datos,
          success:function(d) {

            if (d == "No") {
              Swal.fire(
                'Quitado!',
                'Has quitado con éxito este proveedor.',
                'success'
              );  
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Parece que ya has hecho un pedido a este proveedor'
              })
            }
            
            mostrar_productos();
          }
        })  
      }
    })
  }

  function crear_producto() {

    var datos = {
      "producto_nombre":$("#producto_nombre").val(),
      "peso_producto":$("#peso_producto").val()
    };

    var producto = $("#producto_nombre").val();
    var peso = $("#peso_producto").val();

    if (producto == "" || peso == "") {
      alert("No se ha especificado el Nombre de producto o Peso :/");
    } else {

      $.ajax({
        type: "POST",
        url: "controlador/crear_producto.php",
        data:datos,
        success:function(d) {
          Swal.fire(
            'Creado!',
            'Has creado con éxito este producto.',
            'success'
          );

          document.getElementById("producto_nombre").value = "";
          document.getElementById("peso_producto").value = "";
          seleccionar_producto();
          
        }
      })

    }

  }

  function validar_asociacion_producto() {

    var datos = {
      "seleccionar_producto":$("#seleccionar_producto").val(),
      "proveedores_crear_producto":$("#proveedores_crear_producto").val()
    }

    $.ajax({
      type: "POST",
      url: "controlador/validar_asociacion_producto.php",
      data:datos,
      success:function(d) {
        
        if (d == "existe") {
          alert($("#seleccionar_producto option:selected").text() + " ya es proveido por " + $("#proveedores_crear_producto option:selected").text() +"!, Si deseas cambiar el precio de este producto, dirigete a el apartado de 'Pedidos'");
          $("#producto_nombre").val("");
        } else {
          Producto_y_proveedor();
        }

      }
    })
    
  }

  function Producto_y_proveedor() {

    var datos = {
      "seleccionar_producto":$("#seleccionar_producto").val(),
      "proveedores_crear_producto":$("#proveedores_crear_producto").val(),
      "producto_precio":$("#producto_precio").val(),
    }

    var producto = $("#seleccionar_producto").val();
    var proveedor = $("#proveedores_crear_producto").val();
    var precio = $("#producto_precio").val();

    if (precio == "" || proveedor == "" || producto == "") {
      alert("El producto, proveedor o precio esta vacio :/")
    } else {
      $.ajax({
        type: "POST",
        url: "controlador/Producto_y_proveedor.php",
        data:datos,
        success:function(d) {
          Swal.fire(
            'Asociado!',
            'Has asociado con éxito el producto y su proveedor. Si en un futuro deseas cambiar su precio, dirígete a la sección <button type="button" class="btn btn-dark"><i class="fa-sharp fa-solid fa-recycle"></i> Pedidos</button>',
            'success'
          );
          document.getElementById("producto_precio").value = "";
          document.getElementById("proveedores_crear_producto").selectedIndex = 0; 
          document.getElementById("seleccionar_producto").selectedIndex = 0;
          
        }
      })
    }

    
  }

  function eliminar_proveedor(idproveedor) {

    Swal.fire({
      title: '¿Descartar este Proveedor?',
      text: "no podrán revocar esta opción y no podrás ejecutarla si ya has hecho acciones con este proveedor",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: 'success',
      confirmButtonText: 'descartar'
    }).then((result) => {
      if (result.isConfirmed) {

        var datos = { //capturo los datos
          "idproveedor":idproveedor
        };
    
        $.ajax({
          type: "POST",
          url: "controlador/eliminar_proveedor.php",
          data:datos,
          success:function(d) {
            Swal.fire(
              'Eliminado!',
              'Has eliminado con éxito este proveedor.',
              'success'
            );
            mostrar_provedores();
          }
        })  
      }
    })

    
    
  }

  function info_proveedor(idproveedor) {
    var datos = { //capturo los datos
      "idproveedor":idproveedor
    };

    $.ajax({
      type: "POST",
      url: "controlador/info_proveedor.php",
      data:datos,
      success:function(d) {
        $("#editar_proveedores").html(d);
      }
    }) 
  }

  function editar_proveedor() {
    var datos = { //capturo los datos
      "id_proveedor_edit":$("#id_proveedor_edit").val(),
      "Nombre_proveedor_editar":$("#Nombre_proveedor_editar").val(),
      "Proveedor_telefono_edit":$("#Proveedor_telefono_edit").val(),
      "Proveedor_banco_edit":$("#Proveedor_banco_edit").val()
    };

    var Nombre = $("#Nombre_proveedor_editar").val();

    if (Nombre == "") {
      alert("Se requiere almenos un nombre");
    } else {
      $.ajax({
        type: "POST",
        url: "controlador/editar_proveedor.php",
        data:datos,
        success:function(d) {
          Swal.fire(
            'Editado!',
            'Has editado con éxito este proveedor.',
            'success'
          );
          mostrar_provedores();     
        }
      })
    }
 
  }

  function crear_proveedor() {

    var datos = {
      "Nombre_proveedor":$("#Nombre_proveedor").val(),
      "Proveedor_telefono":$("#Proveedor_telefono").val(),
      "Proveedor_banco":$("#Proveedor_banco").val()
    }

    var Nombre = $("#Nombre_proveedor").val();

    if (Nombre == "") {
      alert ("Se requiere un nombre");
    } else {
      $.ajax({
        type: "POST",
        url: "controlador/crear_proveedor.php",
        data:datos,
        success:function(d) {
          mostrar_provedores();
          Swal.fire(
            'Creado!',
            'Has creado con éxito este proveedor!.',
            'success'
          );
          
        }
      })
    }

  }

  function alertas() {

    $.ajax({
      type: "POST",
      url: "controlador/alertas.php",
      success:function(d) {
        $('#Numero_alertas').html(d);
      }
    })
    
  }

  function MostrarAlertas() {

    $.ajax({
      type: "POST",
      url: "controlador/MostrarAlertas.php",
      success:function(d) {
        $('#MostrarAlertas').html(d);
      }
    })
    
  }