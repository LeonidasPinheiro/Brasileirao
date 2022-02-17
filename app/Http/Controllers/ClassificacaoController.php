<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use App\Models\Clube;
use App\Models\Partida;
use App\Models\Classificacao;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;


class ClassificacaoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clubes = Clube::paginate(20);

        return view('classificacao', compact('clubes'));
    }

    public function anyData()
    {
        return Datatables::of(User::query())->make(true);
    }

    public function getClassificacao(Request $request)
    {

        $clubes = Clube::all();
        $classificacao = classificacao::all();
        $classificacaoClube = [];

        if ($request->ajax()) {

            foreach ($clubes as $clube) {
                foreach ($classificacao as $key => $value) {

                    $pontos = Classificacao::where('clube', $clube->id)->sum('pontos');
                    $jogos_disputados = Classificacao::where('clube', $clube->id)->count();
                    $vitorias = Classificacao::where('clube', $clube->id)->sum('vitorias');
                    $empates = Classificacao::where('clube', $clube->id)->sum('empates');
                    $derrotas = Classificacao::where('clube', $clube->id)->sum('derrotas');
                    $saldo_gols = Classificacao::where('clube', $clube->id)->sum('saldo_gols');

                    $classificacaoClube[$clube->id] = [
                        'IDClube' => $clube->id,
                        'nome' => $clube->nome,
                        'pontos' => $pontos,
                        'jogos_disputados' => $jogos_disputados,
                        'vitorias' => $vitorias,
                        'empates' => $empates,
                        'derrotas' => $derrotas,
                        'gol_pro' => '',
                        'gol_contra' => '',
                        'saldo_gols' => $saldo_gols,
                    ];
                }

            }

            $ranq = array();
            foreach ($classificacaoClube as $key => $row)
            {
                $ranq[$row['nome']] = $row['pontos'];

            }
            array_multisort($ranq, SORT_DESC, $classificacaoClube);

            $data = $classificacaoClube;
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('nome', function ($row) use ($ranq) {
                   foreach ($ranq as $value){
                       if($value==$row['pontos']){
                            $nome = $row['nome'];
                       }
                   }
                    return $nome;
                })
                ->rawColumns(['nome'])
                ->make(true);
        }
    }

    public function salvaRodada(Request $req)
    {

        if (($req->time_casa_gol == '') && ($req->time_visitante_gol == '')) {
            return response(['confronto' => false, 'msg' => 'Preencha os resultados corretamente'], 200);
        }

        if ($req->time_casa == $req->time_visitante) {
            return response(['confronto' => false, 'msg' => 'O Clube da casa e o visitante são os mesmos'], 200);
        }

        $partidas = Partida::all();

        foreach ($partidas as $key => $value) {
            if (($req->time_casa == $value->clube_mandante) && ($req->time_visitante == $value->clube_visitante)) {
                return response(['confronto' => false, 'msg' => 'Partida já executada nesta rodada'], 200);
            }
        }

        if (count($partidas) === 0) {
            $uid = Str::uuid();
            $rodada = 1;
        } else {

            $rodadaAnterior = Partida::where('ativa', 1)->max('id');
            $ArrRodAnterior = Partida::where('id', $rodadaAnterior)->get();

            $uid = $ArrRodAnterior[0]['uid_rodada'];
            $rodada = $ArrRodAnterior[0]->rodada + 1;
        }

        $pontosClubeC = 0;
        $pontosClubeV = 0;

        try {
            Partida::create([
                'rodada' => $rodada,
                'uid_rodada' => $uid,
                'clube_mandante_gol' => $req->time_casa_gol,
                'clube_visitante_gol' => $req->time_visitante_gol,
                'clube_mandante' => $req->time_casa,
                'clube_visitante' => $req->time_visitante,
                'ativa' => 1
            ]);

            if ($req->time_casa_gol > $req->time_visitante_gol) {
                $pontosClubeC = 3;
                $pontosClubeV = 0;
            } elseif ($req->time_casa_gol == $req->time_visitante_gol) {
                $pontosClubeC = 1;
                $pontosClubeV = 1;
            } else {
                $pontosClubeC = 0;
                $pontosClubeV = 3;
            }

            Classificacao::create([
                'clube' => $req->time_casa,
                'pontos' => $pontosClubeC,
                'vitorias' => $pontosClubeC == 3 ? 1 : 0,
                'empates' => $pontosClubeC == 1 ? 1 : 0,
                'derrotas' => $pontosClubeC == 0 ? 1 : 0,
                'gol_pro' => $req->time_casa_gol,
                'gol_contra' => 0,
                'saldo_gols' => $req->time_casa_gol
            ]);

            Classificacao::create([
                'clube' => $req->time_visitante,
                'pontos' => $pontosClubeV,
                'vitorias' => $pontosClubeV == 3 ? 1 : 0,
                'empates' => $pontosClubeV == 1 ? 1 : 0,
                'derrotas' => $pontosClubeV == 0 ? 1 : 0,
                'gol_pro' => $req->time_visitante_gol,
                'gol_contra' => 0,
                'saldo_gols' => $req->time_visitante_gol
            ]);


            return response(['confronto' => true, 'numeroRodada' => $rodada], 200);

        } catch (Exception $e) {

            return redirect()->back();
        }

    }

    public function getRodada()
    {

        $partidas = Partida::all();

        if (count($partidas) === 0) {
            return response(['numeroRodada' => 1], 200)
                ->header('Content-Type', 'json');
        }


    }


}
