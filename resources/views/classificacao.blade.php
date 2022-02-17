@extends('layouts.AdminLTE.index')

@section('title', 'Classificação')

@section('menu_pagina')

	<li role="presentation">
        <a class="btn btn-success  btn-xs" href="#" data-toggle="modal" id="btnModal">Novo Confronto</a>
    </li>

@endsection

@section('content')

    <div class="box box-primary">
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table id="tabelapadrao" class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">Clube</th>
									<th class="text-center">PTS</th>
									<th class="text-center">J</th>
									<th class="text-center">V</th>
									<th class="text-center">E</th>
									<th class="text-center">D</th>
									<th class="text-center">GP</th>
									<th class="text-center">GC</th>
									<th class="text-center">SG</th>
								</tr>

							</thead>
							<tbody>
							</tbody>
                            <div class="modal fade" id="modal-confronto">
                                <form method="post" id="formRodada">
                                    {{ csrf_field() }}
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <h5>Rodada #<span class="numeroRodadaSpan"></span></h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="nome">Time da Casa</label>
                                                        <select class="form-control" id="time_casa" name="time_casa">
                                                            @foreach($clubes as $clube)
                                                            <option value="{{ $clube->id }}">{{ $clube->nome }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="number" id="time_casa_gol"name="time_casa_gol" class="form-control input-sm" minlength="1" width="10px">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="nome">Time Visitante</label>
                                                        <select class="form-control" id="time_visitante" name="time_visitante">
                                                            @foreach($clubes as $clube)
                                                                <option value="{{ $clube->id }}">{{ $clube->nome }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="number" id="time_visitante_gol"name="time_visitante_gol" class="form-control input-sm" minlength="1" width="10px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <span style="float: left" class="modalResult"></span>
                                            <input type="submit" class="btn btn-success" value="Salvar">
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
							<tfoot>
								<tr>
                                    <th class="text-center">Clube</th>
                                    <th class="text-center">PTS</th>
                                    <th class="text-center">J</th>
                                    <th class="text-center">V</th>
                                    <th class="text-center">E</th>
                                    <th class="text-center">D</th>
                                    <th class="text-center">GP</th>
                                    <th class="text-center">GC</th>
                                    <th class="text-center">SG</th>
                                </tr>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="col-md-12 text-center">

				</div>
			</div>
		</div>
	</div>
@endsection

@include('layouts.AdminLTE._includes._data_tables')

@section('js')
    <script>
        //var table = $('#tabelapadrao').DataTable();
        $('#btnModal').on('click',function (e) {
            $('.numeroRodadaSpan').text("");
            $.get( "getRodada", function( data ) {
                var numeroRodada = data.numeroRodada;
                $('.numeroRodadaSpan').text(numeroRodada).appendTo();
                $('#modal-confronto').modal('show');
            });
        });


    </script>
@endsection
