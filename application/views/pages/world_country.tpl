<div class="blog-post">
<h2 class="blog-post-title">{$main_title|upper|replace:'-':' '}</h2>

<hr>
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
	
		{if !$data}
		
		{else}
		<table class='table table-hover table-condensed'>
			<tbody>
			<tr>
				<th>Country Code</th>
				<td>{$data.Code}</td>
			</tr>
			<tr>
				<th>Region</th>
				<td>{$data.Region}</td>
			</tr>
			<tr>
				<th>SurfaceArea</th>
				<td>{$data.SurfaceArea|number_format:2:".":","}</td>
			</tr>
			<tr>
				<th>Population</th>
				<td>{$data.Population|number_format:2:".":","}</td>
			</tr>
			<tr>
				<th>Life Expectancy</th>
				<td>{$data.LifeExpectancy}</td>
			</tr>
			<tr>
				<th>GNP</th>
				<td>{$data.GNP|number_format:2:".":","}</td>
			</tr>
			<tr>
				<th>Government Form</th>
				<td>{$data.GovernmentForm}</td>
			</tr>
			<tr>
				<th>Head of State</th>
				<td>{$data.HeadOfState}</td>
			</tr>
			<tr>
				<th>Capital</th>
				<td>{$data.Capital}</td>
			</tr>
			<tr>
				<td colspan="2"><a href="{$current_url}/edit/" class="btn btn-primary btn-block">Edit</a></td>
			</tr>

	</tbody>
	</table>
	{/if}
	</div>
	
	
</div><!-- /.country -->

</nav>