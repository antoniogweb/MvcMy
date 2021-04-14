<?php

// EasyGiant is a PHP framework for creating and managing dynamic content
//
// Copyright (C) 2009 - 2014  Antonio Gallo (info@laboratoriolibero.com)
// See COPYRIGHT.txt and LICENSE.txt.
//
// This file is part of EasyGiant
//
// EasyGiant is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// EasyGiant is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with EasyGiant.  If not, see <http://www.gnu.org/licenses/>.

if (!defined('EG')) die('Direct access not allowed!');

class Lang_It_ModelStrings extends Lang_ResultStrings {
	
	public function __construct() {

		$this->string = array(
			"error" => "<div class='".Params::$errorStringClassName."'>Errore nella query: contatta l'amministratore!</div>\n",
			"executed" => "<div class='".Params::$infoStringClassName."'>operazione eseguita!</div>\n",
			"associate" => "<div class='".Params::$errorStringClassName."'>Problema di integrit&agrave referenziale: il record &egrave associato ad un record di una tabella figlia. Devi prima rompere l'associazione.</div>\n",
			"no-id" => "<div class='".Params::$errorStringClassName."'>Non &egrave definito alcun id della query</div>\n",
			"not-linked" => "<div class='".Params::$errorStringClassName."'>Il record non &egrave associato, non puoi dissociarlo</div>",
			"linked" => "<div class='".Params::$errorStringClassName."'>Il record &egrave gi&agrave associato, non puoi associarlo un'altra volta</div>",
			"not-existing-fields" => "<div class='".Params::$errorStringClassName."'>Alcuni campi della tabella non sono esistenti</div>\n",
			"no-fields" => "<div class='".Params::$errorStringClassName."'>Non ci sono valori da inserire/aggiornare</div>\n",
		);

	}
	
}
