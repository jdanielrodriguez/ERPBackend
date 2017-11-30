<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usuarios Por Mes</title>
    <style type="text/css">
		body{
			width: 100%;
			height: 100%;
			margin: 0;
		}

		#main-content{
			width: 100%;
			height: auto;
			margin-top: 150px;
		}
        .row {
            margin-right: -15px;
            margin-left: -15px;
        }
		.logo{
			width: 250px;
			height: 100px;
			display: inline-block;
			left: 0;
			position: absolute;
		}

        .logo img{
            width: 75px;
            height: 75px;
            margin-left: 35px;
            
        }
        .logo h1{
            margin-top: -5px;
        }
		.datos-empresa{
			width: 250px;
			height: 120px;
			display: inline-block;
			right: 0;
			position: absolute;
		}

		.titulo-empresa{
			font-size: 22px;
            text-align: left;
		}

		span{
			display: block;
		}

		#tabla-datos > thead > tr > th {
			border-bottom: 1px solid black;
		}

		#tabla-datos > tbody > tr > td {
			text-align: center;
		}
        .row .scol-6 {
            width: 50%;
        }
	</style>
</head>

<body>
        <div class="row">
                
                    <div class="form-group col-xs-6">
                        Nombre:
                        {!! $student->students->firstname !!} {!! $student->students->lastname !!}
                    </div> 
                    <div class="form-group col-xs-6">
                        Telefono:
                        {!! $student->students->phone !!}
                    </div> <br>
                    <div class="form-group col-xs-6">
                        Direccion:
                        {!! $student->students->address !!}
                    </div> 
                    <div class="form-group col-xs-6">
                        Celular:
                        {!! $student->students->cellphone !!}
                    </div> 
                    
                </div>   
        <div id="main-content">
                <center><h3>Tareas de {!! $student->students->firstname.' '.$student->students->lastname !!}</h3></center>
				<table id="tabla-datos" style="width: 100%;">
					<thead>
						<tr>
							<th style="width:20%;text-align:center;">Nombre</th>
							<th style="width:20%;text-align:center;">Descripcion</th>
							<th style="width:10%;text-align:center;">Valor</th>
							<th style="width:10%;text-align:center;">Nota</th>
							<th style="width:20%;text-align:center;">Fecha Fin</th>
							<th style="width:20%;text-align:center;">Entregado</th>
						</tr>
					</thead>
					<tbody>
						@foreach($student->homework as $item)
							<tr>
                            
								<td>{!! $item["name"] !!}</td>
								<td>{!! $item["description"] !!}</td>
								<td>{!! $item["homework_note"] !!}</td>
								<td>{!! $item["student_note"] !!}</td>
								<td>{!! $item["date_end"] !!}</td>
								<td>{!! $item["set_date"].' '.$item["set_time"] !!}</td>
							</tr>
						@endforeach
					</tbody>
                </table>
                
                <center><h3>Asistencias de {!! $student->students->firstname.' '.$student->students->lastname !!}</h3></center>
				<table id="tabla-datos" style="width: 100%;">
					<thead>
						<tr>
							<th style="width:50%;text-align:center;">Fecha</th>
							<th style="width:50%;text-align:center;">Asitio</th>
						</tr>
					</thead>
					<tbody>
						@foreach($student->assistance as $item)
							<tr>
                            
								<td>{!! $item["assistance_date"] !!}</td>
								<td>{!! $item["assistance"]=='1'?'Si Asistio':'No Asistio' !!}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
        </div>
</body>
</html>