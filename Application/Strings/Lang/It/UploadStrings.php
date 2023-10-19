<?php

// EasyGiant is a PHP framework for creating and managing dynamic content
//
// Copyright (C) 2009 - 2011  Antonio Gallo
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

class Lang_It_UploadStrings extends Lang_ResultStrings {

	public $string = array(
		"error" => "<div class='alert alert-danger'>Errore: verificare i permessi del file/directory</div>\n",
		"executed" => "<div class='alert alert-success'>Operazione eseguita!</div>\n",
		"not-child" => "<div class='alert alert-danger'>La cartella selezionata non è una sotto directory della directory base</div>\n",
		"not-dir" => "<div class='alert alert-danger'>La cartella selezionata non è una directory</div>\n",
		"not-empty" => "<div class='alert alert-danger'>La cartella selezionata non è vuota</div>\n",
		"no-folder-specified" => "<div class='alert alert-danger'>Non è stata specificata alcuna cartella</div>\n",
		"no-file-specified" => "<div class='alert v'>Non è stato specificato alcun file</div>\n",
		"not-writable" => "<div class='alert alert-danger'>La cartella non è scrivibile</div>\n",
		"not-writable-file" => "<div class='alert alert-danger'>Il file non è scrivibile</div>\n",
		"dir-exists" => "<div class='alert alert-danger'>Esiste gi&agrave una directory con lo stesso nome</div>\n",
		"no-upload-file" => "<div class='alert alert-danger'>Non c'è alcun file di cui fare l'upload</div>\n",
		"size-over" => "<div class='alert alert-danger'>La dimensione del file è troppo grande</div>\n",
		"not-allowed-ext" => "<div class='alert alert-danger'>L'estensione del file che vuoi caricare non è consentita</div>\n",
		"not-allowed-mime-type" => "<div class='alert alert-danger'>Il tipo MIME del file che vuoi caricare non è consentito</div>\n",
		"file-exists" => "<div class='alert alert-danger'>Esiste gi&agrave un file con lo stesso nome</div>\n",
	);
	
}
