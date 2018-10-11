<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Categoria;
use App\Bairro;
use App\Doacao;
use App\Imagem;

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

	public function edit(Request $request, $id)
	{
		$doacao = Doacao::findOrFail($id);
	    return view('doacoes.add', [
	        'model' => $doacao	    ]);
	}

	public function show(Request $request, $id)
	{
		$doacao = Doacao::findOrFail($id);
	    return view('doacoes.show', [
	        'model' => $doacao	    ]);
	}

	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$select = "SELECT *,1,2 ";
		$presql = " FROM doacoes a ";
		if($_GET['search']['value']) {	
			$presql .= " WHERE titulo LIKE '%".$_GET['search']['value']."%' ";
		}
		
		$presql .= "  ";

		$sql = $select.$presql." LIMIT ".$start.",".$len;


		$qcount = DB::select("SELECT COUNT(a.id) c".$presql);
		//print_r($qcount);
		$count = $qcount[0]->c;

		$results = DB::select($sql);
		$ret = [];
		foreach ($results as $row) {
			$r = [];
			foreach ($row as $value) {
				$r[] = $value;
			}
			$ret[] = $r;
		}

		$ret['data'] = $ret;
		$ret['recordsTotal'] = $count;
		$ret['iTotalDisplayRecords'] = $count;

		$ret['recordsFiltered'] = count($ret);
		$ret['draw'] = $_GET['draw'];

		echo json_encode($ret);

	}

	public function insert(Request $request){

		$doacao = new Doacao();

		$upload = $request->imagem->store('img/anuncios');

		$request['usuario_id'] = Auth::user()->id;

		$doacao = $doacao->create($request->all());

		$doacaoImagem['nome'] = explode('/', $upload)[2];
		$doacaoImagem['doacao_id'] = $doacao->id;

		$doacao->imagens()->create($doacaoImagem);
	}


	public function update(Request $request) {
	    //
	    /*$this->validate($request, [
	        'name' => 'required|max:255',
	    ]);*/
		$doacao = null;
		if($request->id > 0) { $doacao = Doacao::findOrFail($request->id); }
		else { 
			$doacao = new Doacao;
		}
	    

	    		
			    $doacao->id = $request->id?:0;
				
	    		
					    $doacao->titulo = $request->titulo;
		
	    		
					    $doacao->usuario_id = $request->usuario_id;
		
	    		
					    $doacao->descricao = $request->descricao;
		
	    		
					    $doacao->bairro_id = $request->bairro_id;
		
	    		
					    $doacao->categoria_id = $request->categoria_id;
		
	    		
					    $doacao->aprovado = $request->aprovado;
		
	    		
					    $doacao->doado = $request->doado;
		
	    		
					    $doacao->created_at = $request->created_at;
		
	    		
					    $doacao->updated_at = $request->updated_at;
		
	    		
					    $doacao->deleted_at = $request->deleted_at;
		
	    	    //$doacao->user_id = $request->user()->id;
	    $doacao->save();

	    return redirect('/doacoes');

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {
		
		$doacao = Doacao::findOrFail($id);

		$doacao->delete();
		return "OK";
	    
	}

	
}