<?

class Blog extends CI_controller {
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
  
  public function category_index(){
	  echo "category index";
  }
  public function category_lookup($category_name=null){
	  if(isset($category_name)){
			echo "{$category_name} category's items lookup";
	  }else{
			echo "Parameter is not set";
	  }
  }
  public function category_lookup_date($category_name,$year){
	  $this->load->database();
	  if(isset($category_name) && is_numeric($year)){
			echo "{$category_name} category of {$year} items lookup";
	  }else{
			echo "Parameter is not set";
	  }
  }
  
}

?>