@section('layout_css')

	<link rel="stylesheet" href="{{ asset('datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

@endsection

@section('layout_js')

	<script src="{{ asset('datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="//cdn.datatables.net/plug-ins/1.11.4/api/fnReloadAjax.js"></script>
	<script>

		$(function (){
			var table = $('#tabelapadrao').DataTable({
				"order": [[ 1, "desc" ]],
				responsive: true,
                processing: true,
                serverSide: true,
                "paging": false,
                "searching": false,
                "info": false,
                "ajax": "getClassificacao",
                columns: [
                   //{data: 'nome', name: 'nome'},
                    { data: "nome", defaultContent: ''},
                    {data: 'pontos', name: 'pontos'},
                    {data: 'jogos_disputados', name: 'jogos_disputados'},
                    {data: 'vitorias', name: 'vitorias'},
                    {data: 'empates', name: 'empates'},
                    {data: 'derrotas', name: 'derrotas'},
                    {data: 'gol_pro', name: 'gol_pro'},
                    {data: 'gol_contra', name: 'gol_contra'},
                    {data: 'saldo_gols', name: 'saldo_gols'},
                ],
                drawCallback: function (data) {

                    api = this.api();
                    var arr = api.columns(1).data()[0];  //get array of column 3 (extn)
                    console.log(arr);




                }
			});

            $("#formRodada").submit(function(e) {

                e.preventDefault();
                var form = $(this);

                $.ajax({
                    type: "POST",
                    url: 'salvaRodada',
                    data: form.serialize(), // serializes the form's elements.
                    complete: function(data) {

                        if(data.responseJSON.confronto==false){
                            $('.modalResult').html(data.responseJSON.msg);
                                return false;
                        }
                        table.ajax.reload( null, true);
                        $('#modal-confronto').modal('hide');




                    }
                });

            });


		});
	</script>
	@yield('in_data_table')
@endsection
