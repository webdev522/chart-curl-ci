<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

    //get server name list
	public function index()
	{
        $this->load->model('server');
		$data['serverlist'] = $this->server->getServerList();
        $this->load->view('data', $data);
	}

    //get data from selected server by request
    public function serverdata($servername)
    {
        $this->load->model('server');
		$data['serverdata'] = $this->server->getServerData($servername);
        echo $data['serverdata'];
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */