<?php

namespace ManiaLivePlugins\eXpansion\Core;

class Config extends \ManiaLib\Utils\Singleton {

    public $debug = false;
    public $language = null;
    public $defaultLanguage = null;
    public $Colors_admin_error = '$f44';  // error message color for admin
    public $Colors_error = '$f00';   // general error message color
    public $Colors_admin_action = '$0ae'; // admin actions color
    public $Colors_variable = '$eee'; // generic variable color
    public $Colors_record = '$6EF'; // all other local records
    public $Colors_record_top = '$6f3'; // top5 local records
    public $Colors_rank = '$ff0'; // used in record messages for rank
    public $Colors_time = '$fff';
    public $Colors_rating = '$fb3'; // map ratings color
    public $Colors_queue = '$8af';  // map queue messages
    public $Colors_dedirecord = '$69C'; // dedimania records
    public $Colors_donate = '$a0f'; // donate
    public $Colors_personalmessage = '$0ff'; // personal messages
    public $Colors_admingroup_chat = '$f00'; // personal messages
    public $Colors_player = '$z$s$29f';  // used in joinleave-messages
    public $Colors_music = '$f0a';       // music box
    public $Colors_quiz = '$z$s$3e3';    // quiz
    public $Colors_question = '$z$s$o$fa0';  // quiz answer
    
    public $time_dynamic_max = '7:00';  // dynamic timelimit max time for /ta dynamic <x>
    public $time_dynamic_min = '4:00';  // dynamic timelimit min time for /ta dynamic <x>
    
    public $API_Version = '2011-10-06'; //ApiVersion can be 2011-10-06 for TM and 2013-04-16 for SM Add in config 
    
    public $enableRanksCalc = true;  // enable calculation of player ranks on checkpoints
    
}

?>