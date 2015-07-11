<div class="blog-post">
<h2 class="blog-post-title">{$main_title}</h2>
<p class="blog-post-meta">Last update: {$last_update}</p>

<hr>
	<p>A continent is one of several very large landmasses on Earth. They are generally identified by convention rather than any strict criteria, with up to seven regions commonly regarded as continents</p>
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
	<ul>
	{section name=continent loop=$data}
			<li><a href="/world/country/{strip}{$data[continent].key|replace:' ':'-'}">{$data[continent].name}</a></li>
	{/section}
	</ul>
	</div>
	<div>{$pagination}</div>
	
	
</div><!-- /.blog-post -->

</nav>