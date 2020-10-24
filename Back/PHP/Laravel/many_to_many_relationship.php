<?php

//relationship many to many customized
//params->(model, tabela_pivot, id_model_local, id_model_foreign)
return $this->belongsToMany('App\Models\Sys\TVenda', 'cartorio_venda_status', 'id_substatus', 'id_venda');


//Debuggar blade com phpstorm
<?php xdebug_break(); ?>