function genera_curp_Auxiliar(key,nombre,apellido_paterno,apellido_materno,dia,mes,anio,estado,sexo){
	// var objParam="";
		// for (var i = 0; i < datos.length; i++) {
			if(dia<10){
				dia="0"+dia;
			}
			if(mes<10){
				mes="0"+mes;
			}
		objParam = {
		    nombre : nombre,
		    apellido_paterno :apellido_paterno,
		    apellido_materno :apellido_materno,
		    sexo : sexo,
		    estado : estado,
		   	fecha_nacimiento : [dia,mes, anio],
		    homonimia : "-"
    		};
    	curp = generaCurp(objParam);
    	console.log(key+": "+nombre+" "+apellido_paterno+" ",apellido_materno);
    	console.log(curp);
    	if(curp){
    		// var ruta = base_url + 'Index/actualizaCurpInterno';
    		var ruta = base_url + 'Index/actualizaCurpInterno';
			$.ajax({
				url: ruta,
				type: 'POST',
				dataType: 'json',
				data: { 'curp': curp,'apellido_paterno':apellido_paterno,'nombre':nombre },
				success: function (response) {
					console("update hecho");
				},
				error: function (error) {
					console.log(error);
				}
	    	});
	    }
}