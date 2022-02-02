<?php
//ModuleLang

require '../../../admin/header.php';


(new Request('hello'));

\devups\ModuleLang\ModuleLang::services(Request::get('path'));

