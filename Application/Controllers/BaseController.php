<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!defined('EG')) die('Direct access not allowed!');

class BaseController extends Controller
{
	use TraitController;
	
	public $parentUrl;
	public $parentRootFolder;
	
	public function __construct($model, $controller, $queryString, $application, $action)
	{
		parent::__construct($model, $controller, $queryString, $application, $action);
		
		if( !session_id() )
		{
			session_start();
		}

		$this->parentUrl = App::$parentUrl = $this->baseUrl;
		
		Lang::$current = strtolower(Params::$language);
		
		$baseArgsKeys = array('page:forceNat'=>1,'attivo:sanitizeAll'=>'tutti','partial:sanitizeAll' => "tutti", 'nobuttons:sanitizeAll' => "tutti", 'report:sanitizeAll' => "tutti", 'skip:sanitizeAll' => "tutti", 'page_fgl:forceNat'=>1, 'cerca:sanitizeAll'=>'tutti','dal:pulisciData'=>'tutti', 'al:pulisciData'=>'tutti',);
		
		if (isset($this->argKeys))
		{
			$baseArgsKeys = array_merge($baseArgsKeys, $this->argKeys);
		}
		
		$this->setArgKeys($baseArgsKeys);
		
		$this->parentRoot = $data['parentRoot'] = $this->baseUrl;
		$this->parentRootFolder = $data['parentRootFolder'] = App::$parentRoot = ROOT;
		
		$this->session('admin', array(
			new UtentiModel(),
			new SessioniModel(),
			new AccessiModel(),
			new PermessiModel(),
		));
		
		if (strcmp($controller,"utenti") !== 0)
			$this->s['admin']->check();
		
		$this->model('UtentiModel');
		$this->model('UtentipermessiModel');
		$this->model('ImpostazioniModel');
		$this->model('TraduzioniModel');
		$this->model('RevisioniModel');
		$this->model('RevisioniutentiModel');
		
		$this->m["TraduzioniModel"]->ottieniTraduzioni();
		
		$this->m["ImpostazioniModel"]->getImpostazioni();
		
// 		print_r(ImpostazioniModel::$valori);
		
		if (class_exists($model))
		{
			$this->model($model);
		}
		
		$this->_topMenuClasses[$controller] = "active";
		$data['tm'] = $this->_topMenuClasses;
		
		$data['token'] = null;
		
		$this->s['admin']->checkStatus();
		
		if ( strcmp($this->s['admin']->status['status'],'logged') === 0 ) { //check if already logged
			User::$logged = true;
			User::$id = (int)$this->s['admin']->status['id_user'];
			
			User::$name = $this->s['admin']->status['user'];
			
			User::$permessi = $this->s['admin']->status['groups'];
			
			//estraggo i permessi
			User::$permessiEsteso = $this->m["UtentipermessiModel"]->clear()->select("permessi.titolo")->inner("permessi")->using("id_permesso")->where(array("id_utente"=>User::$id))->toList("permessi.titolo","permessi.titolo")->send();
			
			$data["datiUtente"] = User::$data = $this->m["UtentiModel"]->selectId(User::$id);
		}
		
		if (!User::has("Admin") && $controller != "contatti")
			$this->menuLinks = "save";
		
		if (User::has("Admin") && isset($_GET["lid"]))
			$this->m["RevisioniutentiModel"]->segnaLetta($_GET["lid"]);
		
		if ($controller != "utenti" && $action != "login" && $action != "logout")
		{
			$checkAccesso = true;
			
			if (!$checkAccesso)
			{
				$res = $this->s['admin']->logout();
				header('Refresh: 0;url='.$this->baseUrl);
				die();
			}
		}
		
		// Estraggo le licenze attive
		$data['logged'] = $this->s['admin']->getUsersLogged();
		
		$data['tm'] = $this->_topMenuClasses;
		
		$data['queryResult'] = false;
		
		$data["orderBy"] = $this->orderBy;
		
		$data["sezionePannello"] = $this->sezionePannello;
		
		$data["titoloIframe"] = "Gestisci elemento";
		
		$data["title"] = $titleReport = "Area riservata";
		
		$data["ngApp"] = "";
		
		$data["datePickerStartView"] = 2;
		
		$data["datePickerOrientation"] = "auto";
		
		$data["larghezzaView"] = 12;
		$data["larghezzaForm"] = 6;
		
		$data["numeroNotificheDaLeggere"] = $this->m["RevisioniModel"]->daleggere(true);
		$data["notificheDaLeggere"] = $this->m["RevisioniModel"]->daleggere();
		
		$this->append($data);
		
		Params::$actionArray = "REQUEST";
		
		Params::$rewriteStatusVariables = false;
		
		$this->load('header');
		$this->load('footer','last');
		
		$this->generaPosizioni();
		
// 		print_r(Lang::$i18n[Lang::$current]);
	}
}
