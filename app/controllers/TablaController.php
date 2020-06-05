<?php
declare(strict_types=1);

class TablaController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
		/**
    	 * Proceso encargado de cargar todos los registros de la API en un arreglo
    	 */
    	$nunPagina = 1;
    	$fin = 0;
    	$nex = "true";
    	$arrResul = [];
    	$indice =  0;
    	do {
    		/**
    		 * Pagina de la API
    		 * El valor de $nunPagina se ira incrementando hasta llegar a la ultima pagina disponible
    		 */
    	 	$url = "https://rickandmortyapi.com/api/character/?page=".$nunPagina;

    	 	/**
    	 	 * Se leen los datos
    	 	 */
            $res = json_decode(file_get_contents($url));
            $nex = json_encode($res->info->next);	//bandera para validar si aun hay informacion
    	 	
    	 	/**
   	 		 * Si $next es NULL, entonces ya no hay mas paginas
   	 		 * Se leen los datos de la pagina acutal, pero no se buscaran otras
   	 		 */	
    	 	if ($nex == "null"){
    	 		$fin = 1;
    	 	}else{
    	 		$nunPagina = $nunPagina + 1;
    	 		$this->view->next = substr(strrchr(trim($res->info->next), "="), 1 );
    	 	}

    	 	/**
    	 	 * Recorremos los datos obtenidos para luego agregarlos al arreglo
    	 	 * que sera consumido por la vista
    	 	 */
    	 	for ($i=0; $i < count($res->results); $i++) { 
    	 		$arrResul[$indice]['id'] = $res->results[$i]->id;
    	 		$arrResul[$indice]['nombre'] = $res->results[$i]->name;
    	 		$arrResul[$indice]['status'] = $res->results[$i]->status;
    	 		$arrResul[$indice]['species'] = $res->results[$i]->species;
    	 		$arrResul[$indice]['type'] = $res->results[$i]->type;
    	 		$arrResul[$indice]['gender'] = $res->results[$i]->gender;
    	 		$arrResul[$indice]['fecha'] = substr($res->results[$i]->created,0,10);
    	 		$indice++;
    	 	}
    	 } while ($fin == 0); 

    	 /**	enviamos el arreglo la vista	*/
    	 $this->view->jsonObjet = $arrResul;
    }
}

