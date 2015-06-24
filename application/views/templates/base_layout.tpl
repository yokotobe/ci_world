
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	
    <title>Blog Template for Bootstrap</title>

	
	{include file="$css"}
	
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

	{include file="application/views/templates/base_nav.tpl"}

    <div class="container">

		{if $show_custom_head|default:FALSE}
			{include file=$page_custom_head}
		{else}
			{include file="application/views/templates/base_default_head.tpl"}
		{/if}

      <div class="row">

        <div class="col-sm-8 blog-main">

         {include file=$body}

        </div><!-- /.blog-main -->

      {include file="application/views/templates/base_sidebar.tpl"}
	  
	 
      </div><!-- /.row -->

    </div><!-- /.container -->


	{include file="application/views/templates/base_footer.tpl"}


    {include file="$js"}
		
  </body>
</html>