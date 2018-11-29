<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\DoacoesRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Helpers\DoacoesHelper;
use App\Helpers\UsuariosHelper;
use App\Categoria;
use App\Cidade;
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

    public function index()
	{

	    return view('doacoes.index', []);
	}

	public function create(){

		//$bairros = Bairro::all();
		$cidades = Cidade::all();
		$categorias = Categoria::all();

	    return view('doacoes.create', compact("cidades", "categorias"));
	}

	public function buscarBairros(Request $request){
		$cidade_id = $request['cidade_id'];

		$bairros = Bairro::where('cidade_id', $cidade_id)->get();

		return json_encode($bairros);
	}

	public function meusAnuncios(){

		$anuncios = Doacao::where('usuario_id', Auth::user()->id)->withTrashed()->get();

	    return view('doacoes.meus-anuncios', compact('anuncios'));
	}

	public function aguardandoAprovacao(){

		if(Auth::user()->nivel != 1){
			return redirect('/')->with('warning', 'Desculpe, você não possuí permissão para executar esta ação!');
		}

		$anuncios = Doacao::where('aprovado', 0)->get();

	    return view('doacoes.aguardando-aprovacao', compact('anuncios'));
	}

	public function anuncio($id){

		$anuncio = Doacao::find($id);

		// if(empty($anuncio)){
		// 	return back()->with('status', 'Este anúncio não está disponível!');
		// }

		$avaliacoes = Avaliacao::all();

		$avaliacaoExistente = Avaliacao::where('avaliador_id', Auth::id())->where('avaliado_id', $anuncio->usuario_id)->first();

		$avaliacoes = Avaliacao::select('nivel')->where('avaliado_id', $anuncio->usuario_id)->get();

		$avaliacaoMedia = UsuariosHelper::calcularAvaliacaoMedia($avaliacoes);

		// if($anuncio->aprovado == 0 && Auth::user()->nivel != 1){
		// 	return redirect('/')->with('warning', 'Este anúncio não está disponível!');
		// }

		return view('doacoes.anuncio', compact("anuncio", "avaliacaoMedia", "avaliacaoExistente"));
	}

	public function editar($id){

		$anuncio = Doacao::find($id);

		// if(empty($anuncio)){
		// 	return back()->with('status', 'Este anúncio não está disponível!');
		// }

		if(Auth::user()->id != $anuncio->usuario_id && Auth::user()->nivel != 1){
			return redirect('/')->with('warning', 'Desculpe, você não possuí permissão para executar esta ação!');
		}

		$categorias = Categoria::all();
		$cidades = Cidade::all();

		$bairros = Bairro::where("cidade_id", $anuncio->bairro->cidade_id)->get();

		return view('doacoes.create', compact("anuncio", "bairros", "cidades", "categorias"));
	}

	public function update(DoacoesRequest $request){
		DB::beginTransaction();
		try{
			$doacao = Doacao::find($request->id);

			// if(empty($doacao)){
			// 	return back()->with('status', 'Este anúncio não está disponível!');
			// }

			if(Auth::user()->id != $doacao->usuario_id && Auth::user()->nivel != 1){
				return redirect('/')->with('warning', 'Desculpe, você não possuí permissão para executar esta ação!');
			}

			if(isset($request->imagens_deletadas)){

				if(count($doacao->getImagens()) == count($request->imagens_deletadas)){
					return back()->with("status","O anúncio deve conter pelo menos 1 imagem!");
				}

			}

			if(!empty($request->imagens_deletadas)){
				foreach ($request->imagens_deletadas as $imagem) {
					unlink(base_path().'/'.$imagem);
				}
			}

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

			DB::commit();
			if(Auth::user()->nivel == 1){
				return redirect('/doacoes/meus-anuncios')->with('status', 'Anúncio atualizado com sucesso!');
			}else{
				return redirect('/doacoes/meus-anuncios')->with('status', 'Anúncio enviado para aprovação!');
			}

		}catch(Exception $e){
			DB::rollback();
			return back()->with("status", $e->getMessage());
		}
	}


	public function insert(DoacoesRequest $request){
		DB::beginTransaction();
		try{

			if(!$request->hasFile("imagem")){
				return back()->with("status","O anúncio deve conter pelo menos 1 imagem!")->withInput(Input::all());
			}

			$anuncio = new Doacao();

			$request['usuario_id'] = Auth::user()->id;

			if(Auth::user()->nivel == 1){
				$request['aprovado'] = 1;
			}

			$anuncio = $anuncio->create($request->all());

			foreach ($request->imagem as $key => $imagem) {
				$upload = $imagem->storeAs("anuncio_$anuncio->id", "DonateImage_$key.png");
			}

			DB::commit();
			if(Auth::user()->nivel == 1){
				return redirect('/doacoes/meus-anuncios')->with('status', 'Anúncio cadastrado!');
			}else{
				return redirect('/doacoes/meus-anuncios')->with('status', 'Anúncio enviado para aprovação!');
			}
		}catch(Exception $e){
			DB::rollback();
			return back()->with("status", $e->getMessage());
		}
	}

	public function delete(Request $request){
		DB::beginTransaction();
		try{

			$anuncio = Doacao::find($request["anuncio_id"]);

			// if(empty($anuncio)){
			// 	return back()->with('status', 'Este anúncio não está disponível!');
			// }

			if(Auth::user()->id != $anuncio->usuario_id && Auth::user()->nivel != 1){
				return redirect('/')->with('warning', 'Desculpe, você não possuí permissão para executar esta ação!');
			}	

			$anuncio->delete();

			DB::commit();
			return redirect('/doacoes/meus-anuncios')->with('status', 'Anúncio desativado!');

		}catch(Exception $e){
			DB::rollback();
			return back()->with("status", $e->getMessage());
		}
	}

	public function restore(Request $request){
		DB::beginTransaction();
		try{

			$anuncio = Doacao::where("id", $request["anuncio_id"])->withTrashed()->first();

			// if(empty($anuncio)){
			// 	return back()->with('status', 'Este anúncio não está disponível!');
			// }

			if(Auth::user()->id != $anuncio->usuario_id && Auth::user()->nivel != 1){
				return redirect('/')->with('warning', 'Desculpe, você não possuí permissão para executar esta ação!');
			}	

			$anuncio->restore();

			DB::commit();
			return redirect('/doacoes/meus-anuncios')->with('status', 'Anúncio reativado!');

		}catch(Exception $e){
			DB::rollback();
			return back()->with("status", $e->getMessage());
		}
	}

	public function mudarStatus(Request $request){

		$anuncio = Doacao::find($request->id);

		if(Auth::user()->nivel != 1 && Auth::user()->id != $anuncio->usuario_id){
			return redirect('/')->with('warning', 'Desculpe, você não possuí permissão para executar esta ação!');
		}

		if($request->tipo == 'aprovado' && Auth::user()->nivel != 1){
			return redirect('/')->with('warning', 'Desculpe, você não possuí permissão para executar esta ação!');
		}

		$tipo = $request->tipo;

		$anuncio->$tipo = $request->valor;

		$anuncio->save();

		if($request->valor == 0){
			return back()->with("status", "Anúncio marcado como não ".$tipo);
		}else{
			return back()->with("status", "Anúncio marcado como ".$tipo);
		}

		return back();
	
	}

	public function anuncios($categoria){

		if($categoria == 'all'){
			$anuncios = Doacao::where('aprovado', 1)->where('doado', 0)->paginate(10);
		}else{
			$anuncios = Doacao::where('categoria_id', $categoria)->where('aprovado', 1)->where('doado', 0)->paginate(10);
		}

		$cidades = Cidade::all();

		if(is_numeric($categoria)){
			$nomeCategoria = Categoria::find($categoria)->nome;
			
			return view('/doacoes/anuncios', compact("anuncios", "nomeCategoria", "cidades"));
		}


		return view('/doacoes/anuncios', compact("anuncios", "cidades"));
	}

	public function pesquisa(Request $request){

		$cidades = Cidade::all();

		$termos = $request['termos'];

		$anuncios = Doacao::join('bairros','bairros.id','=','doacoes.bairro_id')
			->join('cidades','cidades.id','=','bairros.cidade_id')
			->join('usuarios','usuarios.id','=','doacoes.usuario_id')
			->join('categorias','categorias.id','=','doacoes.categoria_id')
			->where('doado',0)->where('aprovado',1);

	    if(isset($request['cidade_id']) && $request['cidade_id'] != "todas"){
	    	$anuncios = $anuncios->where('cidade_id',$request['cidade_id']);
		}

		if(isset($request['cidade_id'])){
			$cidade_id = $request['cidade_id'];
		}
		$anuncios = $anuncios->select('doacoes.*');


		$anuncios = $anuncios->where(function ($query) use($termos){
			return $query->where('titulo', 'like', '%'.$termos.'%')
			->orWhere('descricao', 'like', '%'.$termos.'%');
		});

		$anuncios = $anuncios->paginate(10);

		return view('/doacoes/anuncios', compact("anuncios", "termos", "cidades", "cidade_id"));
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