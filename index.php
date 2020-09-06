<?php 
/*
Website created with php. Includes API for chatting (client: https://github.com/winzmcman/fartuh-chat)
Copyright (C) 2020 Nikita Pavlov
This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
You should have received a copy of the GNU Affero General Public License along with this program. If not, see http://www.gnu.org/licenses/.
Author's email: nikitafartuh@ukr.net
*/

if(!isset($_GET['page']))
    $_GET['page'] = 'index';

define('PAGE', trim($_GET['page']));

$path = __DIR__ . '/pages/' . PAGE . '.php';

if(file_exists($path))
    require($path);
else
    require(__DIR__ . '/pages/404.php');
