<?php
declare(strict_types=1);

class CardController extends \Phalcon\Mvc\Controller
{
    public function indexAction(int $page = 1)
    {
 		/**
		 * URL de la API
		 */	
		$url = "https://rickandmortyapi.com/api/character/?page=".$page;

		/**
		 * Llama a la API
		 */
		$res = file_get_contents($url);
		
		/**
		 * Evaluamos si hubo o no resultados
		 * De no haber, lo llevamos a la pagina 1
		 */
		if ($res){
			$this->view->jsonObjet = json_decode($res);
		}else{
			$this->view->jsonObjet = json_decode(file_get_contents("https://rickandmortyapi.com/api/character/?page=1"));
		}
    
		/**
		 * Total gistros leidos
		 */
		$this->view->cantRegistros = count($this->view->jsonObjet->results);

		/**
		 * Variables de control de la navegacion
		 * Deberia mejorarse este codigo
		 */
		$next = json_encode($this->view->jsonObjet->info->next);
		$prev = json_encode($this->view->jsonObjet->info->prev);
		if ($next == "null"){
			$this->view->linkRight = "/card/index/1";
		}else{
			$this->view->linkRight = "/card/index/".substr(strrchr(trim($this->view->jsonObjet->info->next), "="), 1 );
		}

		if ($prev == "null"){
			$this->view->linkLeft = "/card/index/1";
		}else{
			$this->view->linkLeft = "/card/index/".substr(strrchr(trim($this->view->jsonObjet->info->prev), "="), 1 );
		}
		// mostrar la pagina actual
		$this->view->paginaActual = $page;
    }
}

