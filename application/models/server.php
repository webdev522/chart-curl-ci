<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Server extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

    //get server name list from selected url
	function getServerList()
	{
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://services.mysublime.net/st4ts/data/get/type/servers/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $output = curl_exec($ch);

        if ($output === FALSE) {
            $output = null;
        }

        curl_close($ch);

        if ($output != null) {
            $servernames = json_decode($output, true);
            $servernames_count = count($servernames);
            $serverlist = array();
            for ($idx = 0; $idx < $servernames_count; $idx++) {
                $serverlist[$idx] = $servernames[$idx]["s_system"];
            }
            return $serverlist;
        }
        return null;
	}

    //get server data from selected server's url
    function getServerData($servername)
	{
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://services.mysublime.net/st4ts/data/get/type/iq/server/' . $servername .'/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $output = curl_exec($ch);

        if ($output === FALSE) {
            $output = null;
        }

        curl_close($ch);

        if ($output != null) {
            return $output;
        }
        return null;
	}
}