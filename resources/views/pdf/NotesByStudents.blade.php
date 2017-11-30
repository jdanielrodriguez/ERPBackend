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
<?php
$nota=0;
?>
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
                <center><h3>Notas {!! $student->students->firstname.' '.$student->students->lastname !!}</h3></center>
				<table id="tabla-datos" style="width: 100%;">
					<thead>
						<tr>
							<th style="width:30%;text-align:center;">Materia</th>
							@foreach($ciclos as $item)
								<th style="width:20%;text-align:center;">{!! $item->ciclo->cycles_studying_days->cycles["description"] !!}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@foreach($materias as $materia)
							<tr>
								<td>{!! $materia->subjects["name"] !!}</td>
								@foreach($ciclos as $ciclo)
									@foreach($ciclo->materias as $ciclo_materia)
										@if ($ciclo_materia->subjects->subjects["name"] == $materia->subjects["name"])
											<?php $nota=0; ?>
											@foreach($ciclo_materia->homework as $tarea)
												<?php $nota+=$tarea->student_note ?>
											@endforeach
											<td>{!! $nota !!}</td>
										@endif
									@endforeach
								@endforeach
							</tr>
						@endforeach
					</tbody>
                </table>
                
        </div>
</body>
</html>