<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sys_Controller extends CI_Controller {


	function __construct()  
	{
		parent::__construct();

	}


	protected function sys_render($view, $data = array(), $datah = array(), $dataf = array()){
		

		$data_header = array();
        // $data_header['sidebar']        = @$_COOKIE['sidebar'];
		$data_header = array_merge($data_header, $datah);

		// $data_header['menu'] = $this->get_menu($data_header['obj_usuario']['idusuario']);

		$data_footer = array();
		$data_footer = array_merge($data_footer, $dataf);

		$this->load->view('header', $data_header);
		$this->load->view($view, $data);
		$this->load->view('footer', $data_footer);
	}

	protected function json_output($arr = array())
	{
		header('Content-Type: application/json');
		echo json_encode( $arr );
	}


}