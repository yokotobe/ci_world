<?

class World extends CI_controller {
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
  
  public function world_index(){
	  echo "world index";
  }
  public function continent_lookup($continent_name=null){
	  if(isset($continent_name)){
			echo "{$continent_name} 's items lookup";
	  }else{ //show continent list
			//echo "continent index";
			$data = array();
			
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
  public function world_lookup_country($category_name,$year){
	  $this->load->database();
	  if(isset($category_name) && is_numeric($year)){
			echo "{$category_name} category of {$year} items lookup";
	  }else{
			echo "Parameter is not set";
	  }
  }
  
}

?>