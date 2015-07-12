<?php

class World extends CI_controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->model('world_model', 'post');
		$this->load->library("pagination");
		$this->load->database();
	}
	
	public function world_index(){
		echo "world index";
	}
	
	public function index() {
		$data = array(
		// 'headerContent' => $this->load->view('header', array(), TRUE),
		//'mainContent' => $this->load->view('main', array(), TRUE),
		//'footerContent' => $this->load->view('footer', array(), TRUE),
		);
		//$this->custom_smarty->template_dir = '/application/views/template/,/application/views/pages/,/application/views/error/'; 
		//$this->custom_smarty->compile_id = $_SERVER['SCRIPT_NAME'];
		
		
		$this->custom_smarty->assign('body','application/views/pages/blog.tpl');
		$this->custom_smarty->assign('js', 'application/views/templates/base_js.tpl');
		$this->custom_smarty->assign('css', 'application/views/templates/blog_css.tpl');
		$this->custom_smarty->display('base_layout.tpl');
	} 


	public function continent_lookup($continent_name=null){
		if(isset($continent_name)){
			echo "{$continent_name} 's items lookup";
		}else{ //show continent list
			//echo "continent index";
			
			$this->load->model('world_model');
			$continents = $this->world_model->get_all_continent();
			
			if(is_array($continents) && count($continents)){
				$out = array();
				foreach($continents as $index => $cont){
					$out[$index]['key'] = strtolower($cont['continent']);
					$out[$index]['name'] = $cont['continent'];
				}
				$this->custom_smarty->assign('data',$out);
			}else{
				$this->custom_smarty->assign('data',FALSE);
			}
			
			$this->custom_smarty->assign('show_custom_head','TRUE');
			$this->custom_smarty->assign('page_custom_head','application/views/pages/head_custom_world.tpl');
			$this->custom_smarty->assign('main_title','List of continents');
			$this->custom_smarty->assign('last_update',date("Y/m/d"));
			$this->custom_smarty->assign('current_url',current_url());
			$this->custom_smarty->assign('body','application/views/pages/world_continent.tpl');
			$this->custom_smarty->assign('js', 'application/views/templates/base_js.tpl');
			$this->custom_smarty->assign('css', 'application/views/templates/blog_css.tpl');
			$this->custom_smarty->display('base_layout.tpl');

		}
	}
	
	public function continent_countries($continent_name,$pnum=null){
		//$this->load->database();
		
		$this->load->model('world_model');
		//var_dump($pnum);
		if(isset($pnum)){
			$page_num = filter_var($pnum, FILTER_SANITIZE_NUMBER_INT);
			$limit = 25;
			$start = ($page_num*$limit)-$limit;
			//var_dump($page_num);
			//var_dump($start);
			$continent_countries_data = $this->world_model->get_countries($continent_name,$start,$limit);
		}else{
			$continent_countries_data = $this->world_model->get_countries($continent_name);
		}
		
	
		
		if(isset($continent_countries_data) && count($continent_countries_data)){
			//var_dump($continent_countries_data);
			
			$data = array();
			
			$config['base_url'] 		= site_url('/world/continent/'.$continent_name);
			//$config['total_rows'] 	= $this->db->count_all('tbl_dept');
			$config['total_rows'] 		= $this->world_model->count_countires($continent_name);
			$config['per_page'] 		= "25";
			$config["uri_segment"] 		= 4;
			$choice 					= $config["total_rows"] / $config["per_page"];
			$config["num_links"] 		= floor($choice);
			$config['use_page_numbers'] = TRUE;
			
			//config for bootstrap pagination class integration
			$config['full_tag_open'] 	= '<ul class="pagination">';
			$config['full_tag_close'] 	= '</ul>';
			$config['first_link'] 		= false;
			$config['last_link'] 		= false;
			$config['first_tag_open'] 	= '<li>';
			$config['first_tag_close'] 	= '</li>';
			$config['prev_link'] 		= '&laquo';
			$config['prev_tag_open'] 	= '<li class="prev">';
			$config['prev_tag_close'] 	= '</li>';
			$config['next_link'] 		= '&raquo';
			$config['next_tag_open'] 	= '<li>';
			$config['next_tag_close'] 	= '</li>';
			$config['last_tag_open'] 	= '<li>';
			$config['last_tag_close'] 	= '</li>';
			$config['cur_tag_open'] 	= '<li class="active"><a href="#">';
			$config['cur_tag_close'] 	= '</a></li>';
			$config['num_tag_open'] 	= '<li>';
			$config['num_tag_close'] 	= '</li>';
			
			$this->pagination->initialize($config);
			$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$data['pagination'] = $this->pagination->create_links();
			
			//var_dump($data);
			
			
			$out = array();
			
			foreach($continent_countries_data as $index => $cont){
				$out[$index]['key'] = strtolower($cont['name']);
				$out[$index]['name'] = $cont['name'];
			}
			$this->custom_smarty->assign('data',$out);
			$this->custom_smarty->assign('pagination',$data['pagination']);
			
		}else{
			$this->custom_smarty->assign('data',FALSE);
			//echo "Parameter is not set";
		}
		
		$camelContinentName =  ucwords(strtolower($continent_name)); 
		$page_base_url = "/world/{$continent_name}"; 
		
		$this->custom_smarty->assign('show_custom_head','TRUE');
		$this->custom_smarty->assign('page_custom_head','application/views/pages/head_custom_world.tpl');
		$this->custom_smarty->assign('main_title','Countries of '.$camelContinentName);
		$this->custom_smarty->assign('last_update',date("Y/m/d"));
		//$this->custom_smarty->assign('current_url',current_url());
		$this->custom_smarty->assign('current_url',$page_base_url);
		$this->custom_smarty->assign('body','application/views/pages/world_countries.tpl');
		$this->custom_smarty->assign('js', 'application/views/templates/base_js.tpl');
		$this->custom_smarty->assign('css', 'application/views/templates/blog_css.tpl');
		$this->custom_smarty->display('base_layout.tpl');
		
	}
	
	public function country_search($query_name){
		if(isset($query_name)){
			echo "{$query_name} 's items search";
		}else{ //show continent list
			//echo "continent index";
				
			$this->load->model('world_model');
			$search_result = $this->world_model->search_countires($query_name);
				
			if(is_array($search_result) && count($search_result)){
				$out = array();
				foreach($continents as $index => $cont){
					$out[$index]['key'] 		= strtolower($cont['continent']);
					$out[$index]['name'] 		= $cont['name'];
					$out[$index]['continent'] 	= $cont['continent'];                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
					$out[$index]['region'] 		= $cont['region'];
				}
				$this->custom_smarty->assign('data',$out);
			}else{
				$this->custom_smarty->assign('data',FALSE);
			}
				
			$this->custom_smarty->assign('show_custom_head','TRUE');
			$this->custom_smarty->assign('page_custom_head','application/views/pages/head_custom_world.tpl');
			$this->custom_smarty->assign('main_title','Search Refult of '.$query_name);
			$this->custom_smarty->assign('last_update',date("Y/m/d"));
			$this->custom_smarty->assign('current_url',current_url());
			$this->custom_smarty->assign('body','application/views/pages/world_countries_search.tpl');
			$this->custom_smarty->assign('js', 'application/views/templates/base_js.tpl');
			$this->custom_smarty->assign('css', 'application/views/templates/blog_css.tpl');
			$this->custom_smarty->display('base_layout.tpl');
	
		}
	}
	
	public function world_lookup_country($country_name){
			$this->load->model('world_model');
			$country_result = $this->world_model->get_country($country_name);
			if(is_array($country_result) && count($country_result)){
				$this->custom_smarty->assign('data',$country_result[0]);
			}else{
				$this->custom_smarty->assign('data',FALSE);
			}
			
			$this->custom_smarty->assign('show_custom_head','TRUE');
			$this->custom_smarty->assign('page_custom_head','application/views/pages/head_custom_world.tpl');
			$this->custom_smarty->assign('main_title',$country_name);
			$this->custom_smarty->assign('current_url',current_url());
			$this->custom_smarty->assign('body','application/views/pages/world_country.tpl');
			$this->custom_smarty->assign('js', 'application/views/templates/base_js.tpl');
			$this->custom_smarty->assign('css', 'application/views/templates/blog_css.tpl');
			$this->custom_smarty->display('base_layout.tpl');
	}
	
		public function country_edit($country_name){
			
				$this->load->model('world_model');
			$country_result = $this->world_model->get_country($country_name);
			
			if(is_array($country_result) && count($country_result)){
				echo "country edit home";
				$this->custom_smarty->assign('data',$country_result[0]);
			}else{
				$this->custom_smarty->assign('data',FALSE);
			}
			
			/*$this->load->model('world_model');
			$country_result = $this->world_model->get_country($country_name);
			if(is_array($country_result) && count($country_result)){
				$this->custom_smarty->assign('data',$country_result[0]);
			}else{
				$this->custom_smarty->assign('data',FALSE);
			}
			*/
			$this->custom_smarty->assign('show_custom_head','TRUE');
			$this->custom_smarty->assign('page_custom_head','application/views/pages/head_custom_world.tpl');
			$this->custom_smarty->assign('main_title',$country_name);
			$this->custom_smarty->assign('current_url',current_url());
			$this->custom_smarty->assign('body','application/views/pages/world_country_edit.tpl');
			$this->custom_smarty->assign('js', 'application/views/templates/base_js.tpl');
			$this->custom_smarty->assign('css', 'application/views/templates/blog_css.tpl');
			$this->custom_smarty->display('base_layout.tpl');
	}

}

?>