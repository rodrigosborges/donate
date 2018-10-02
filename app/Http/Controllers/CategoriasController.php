<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Categoria;

use DB;

class CategoriasController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function index(Request $request)
	{
	    return view('categorias.index', []);
	}

	public function create(Request $request)
	{
	    return view('categorias.add', [
	        []
	    ]);
	}

	public function edit(Request $request, $id)
	{
		$categoria = Categoria::findOrFail($id);
	    return view('categorias.add', [
	        'model' => $categoria	    ]);
	}

	public function show(Request $request, $id)
	{
		$categoria = Categoria::findOrFail($id);
	    return view('categorias.show', [
	        'model' => $categoria	    ]);
	}

	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$select = "SELECT *,1,2 ";
		$presql = " FROM categorias a ";
		if($_GET['search']['value']) {	
			$presql .= " WHERE nome LIKE '%".$_GET['search']['value']."%' ";
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


	public function update(Request $request) {
	    //
	    /*$this->validate($request, [
	        'name' => 'required|max:255',
	    ]);*/
		$categoria = null;
		if($request->id > 0) { $categoria = Categoria::findOrFail($request->id); }
		else { 
			$categoria = new Categoria;
		}
	    

	    		
			    $categoria->id = $request->id?:0;
				
	    		
					    $categoria->nome = $request->nome;
		
	    		
					    $categoria->icon = $request->icon;
		
	    	    //$categoria->user_id = $request->user()->id;
	    $categoria->save();

	    return redirect('/categorias');

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {
		
		$categoria = Categoria::findOrFail($id);

		$categoria->delete();
		return "OK";
	    
	}

	
}