<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Helpers\DoacoesHelper;
use App\Categoria;
use App\Bairro;
use App\Doacao;
use App\Imagem;
use App\Avaliacao;

use DB;

class DoacoesController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function index(Request $request)
	{
	    return view('doacoes.index', []);
	}

	public function create(Request $request){

		$bairros = Bairro::all();
		$categorias = Categoria::all();

	    return view('doacoes.create', compact("bairros", "categorias"));
	}

	public function meusAnuncios(Request $request){

		$anuncios = Doacao::where('usuario_id', Auth::user()->id)->get();

		//return $anuncios[0]->getImagens($anuncios[0]->id)[0];

	    return view('doacoes.meus-anuncios', compact('anuncios'));
	}

	public function anuncio($id){

		$anuncio = Doacao::find($id);

		$avaliacoes = Avaliacao::all();

		$avaliacaoExistente = Avaliacao::where('avaliador_id', Auth::id())->where('avaliado_id', $anuncio->usuario_id)->first();

		$qtdAvaliacoes = [
			'1-star' => Avaliacao::where('avaliado_id', $anuncio->usuario_id)->where('nivel', 1)->count(),
			'2-star' => Avaliacao::where('avaliado_id', $anuncio->usuario_id)->where('nivel', 2)->count(),
			'3-star' => Avaliacao::where('avaliado_id', $anuncio->usuario_id)->where('nivel', 3)->count(),
			'4-star' => Avaliacao::where('avaliado_id', $anuncio->usuario_id)->where('nivel', 4)->count(),
			'5-star' => Avaliacao::where('avaliado_id', $anuncio->usuario_id)->where('nivel', 5)->count()
		];

		if($anuncio->aprovado == 0 && Auth::user()->nivel != 1){
			return redirect('/')->with('warning', 'Este anúncio não está disponível!');
		}

		return view('doacoes.anuncio', compact("anuncio", "avaliacoes", "avaliacaoExistente", "qtdAvaliacoes"));
	}

	public function editar($id){

		$anuncio = Doacao::find($id);
		$bairros = Bairro::all();
		$categorias = Categoria::all();

		return view('doacoes.create', compact("anuncio", "bairros", "categorias"));
	}

	public function update(Request $request){

		if(!empty($request->imagens_deletadas)){
			foreach ($request->imagens_deletadas as $imagem) {
				unlink(base_path().'/'.$imagem);
			}
		}

		$doacao = Doacao::find($request->id);

		$doacao->titulo = $request->titulo;
		$doacao->descricao = $request->descricao;
		$doacao->bairro_id = $request->bairro_id;
		$doacao->categoria_id = $request->categoria_id;
		if(Auth::user()->nivel == 1){
			$doacao->aprovado = 1;
		}else{
			$doacao->aprovado = 0;
		}
		$doacao->doado = 0;

		$doacao->save();

		if(!empty($request->imagem)){
			foreach ($request->imagem as $imagem) {
				$numero = DoacoesHelper::proximoNumeroImagem($doacao);
				$upload = $imagem->storeAs("anuncio_$doacao->id", "DonateImage_$numero.png");
			}
		}

		return redirect('/doacoes/meus-anuncios')->with('status', 'Anúncio enviado para aprovação!');
	}


	public function insert(Request $request){

		$anuncio = new Doacao();

		$request['usuario_id'] = Auth::user()->id;

		if(Auth::user()->nivel == 1){
			$request['aprovado'] = 1;
		}

		$anuncio = $anuncio->create($request->all());

		foreach ($request->imagem as $key => $imagem) {
			$upload = $imagem->storeAs("anuncio_$anuncio->id", "DonateImage_$key.png");
		}

		return redirect('/doacoes/meus-anuncios')->with('status', 'Anúncio enviado para aprovação!');
	}

	public function mudarStatus(Request $request){

		$anuncio = Doacao::find($request->id);

		if($anuncio->usuario_id != Auth::id() || Auth::user()->nivel != 1){
			return redirect('/')->with('warning', 'Desculpe, você não possuí permissão para executar esta ação!');
		}

		if($request->tipo == 'aprovado' && Auth::user()->nivel != 1){
			return redirect('/')->with('warning', 'Desculpe, você não possuí permissão para executar esta ação!');
		}

		$tipo = $request->tipo;

		$anuncio->$tipo = $request->valor;

		$anuncio->save();

		return back();
	}

	public function anuncios($categoria){

		if($categoria == 'all'){
			$anuncios = Doacao::where('aprovado', 1)->where('doado', 0)->paginate(10);
		}else{
			$anuncios = Doacao::where('categoria_id', $categoria)->where('aprovado', 1)->where('doado', 0)->paginate(10);
		}

		if(is_numeric($categoria)){
			$nomeCategoria = Categoria::find($categoria)->nome;
			
			return view('/doacoes/anuncios', compact("anuncios", "nomeCategoria"));
		}

		return view('/doacoes/anuncios', compact("anuncios"));
	}

	public function pesquisa(Request $request){

		$termos = $request['termos'];

		$anuncios = Doacao::where('aprovado', 1)
			->where('doado', 0)
			->when($termos, function ($query, $termos){	
	            return $query->where('titulo', 'like', '%'.$termos.'%')
	            ->orWhere('descricao', 'like', '%'.$termos.'%');
	        })->get();

		return view('/doacoes/anuncios', compact("anuncios", "termos"));
	}

	// public function edit(Request $request, $id)
	// {
	// 	$doacao = Doacao::findOrFail($id);
	//     return view('doacoes.add', [
	//         'model' => $doacao	    ]);
	// }

	// public function show(Request $request, $id)
	// {
	// 	$doacao = Doacao::findOrFail($id);
	//     return view('doacoes.show', [
	//         'model' => $doacao	    ]);
	// }

	// public function grid(Request $request)
	// {
	// 	$len = $_GET['length'];
	// 	$start = $_GET['start'];

	// 	$select = "SELECT *,1,2 ";
	// 	$presql = " FROM doacoes a ";
	// 	if($_GET['search']['value']) {	
	// 		$presql .= " WHERE titulo LIKE '%".$_GET['search']['value']."%' ";
	// 	}
		
	// 	$presql .= "  ";

	// 	$sql = $select.$presql." LIMIT ".$start.",".$len;


	// 	$qcount = DB::select("SELECT COUNT(a.id) c".$presql);
	// 	//print_r($qcount);
	// 	$count = $qcount[0]->c;

	// 	$results = DB::select($sql);
	// 	$ret = [];
	// 	foreach ($results as $row) {
	// 		$r = [];
	// 		foreach ($row as $value) {
	// 			$r[] = $value;
	// 		}
	// 		$ret[] = $r;
	// 	}

	// 	$ret['data'] = $ret;
	// 	$ret['recordsTotal'] = $count;
	// 	$ret['iTotalDisplayRecords'] = $count;

	// 	$ret['recordsFiltered'] = count($ret);
	// 	$ret['draw'] = $_GET['draw'];

	// 	echo json_encode($ret);

	// }


	// public function update(Request $request) {
	//     //
	//     /*$this->validate($request, [
	//         'name' => 'required|max:255',
	//     ]);*/
	// 	$doacao = null;
	// 	if($request->id > 0) { $doacao = Doacao::findOrFail($request->id); }
	// 	else { 
	// 		$doacao = new Doacao;
	// 	}
	    

	    		
	// 		    $doacao->id = $request->id?:0;
				
	    		
	// 				    $doacao->titulo = $request->titulo;
		
	    		
	// 				    $doacao->usuario_id = $request->usuario_id;
		
	    		
	// 				    $doacao->descricao = $request->descricao;
		
	    		
	// 				    $doacao->bairro_id = $request->bairro_id;
		
	    		
	// 				    $doacao->categoria_id = $request->categoria_id;
		
	    		
	// 				    $doacao->aprovado = $request->aprovado;
		
	    		
	// 				    $doacao->doado = $request->doado;
		
	    		
	// 				    $doacao->created_at = $request->created_at;
		
	    		
	// 				    $doacao->updated_at = $request->updated_at;
		
	    		
	// 				    $doacao->deleted_at = $request->deleted_at;
		
	//     	    //$doacao->user_id = $request->user()->id;
	//     $doacao->save();

	//     return redirect('/doacoes');

	// }

	// public function store(Request $request)
	// {
	// 	return $this->update($request);
	// }

	// public function destroy(Request $request, $id) {
		
	// 	$doacao = Doacao::findOrFail($id);

	// 	$doacao->delete();
	// 	return "OK";
	    
	// }

	
}