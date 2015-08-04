<div class="blog-post">
<h2 class="blog-post-title">{$main_title|upper|replace:'-':' '}</h2>

<hr>
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
	
		{if !$data}
		
		{else}
		
		<form name="form_country_edit" method="post" action="{$current_url}">
			
			<input name="mode" type="hidden" value="confirm" />
			
			<table class='table table-hover table-condensed'>
				<tbody>
				<tr>
					<th>Country Code</th>
					<td><input name="code" class="form-control" id="" value="{$data.Code}" /></td>
				</tr>
				<tr>
					<th>Region</th>
					<td><input name="region" class="form-control" id="" value="{$data.Region}" /></td>
				</tr>
				<tr>
					<th>SurfaceArea</th>
					<td><input name="surfaceArea" class="form-control" id="" value="{$data.SurfaceArea|number_format:2:".":","}" /></td>
				</tr>
				<tr>
					<th>Population</th>
					<td><input name="population" class="form-control" id="" value="{$data.Population|number_format:2:".":","}" /></td>
				</tr>
				<tr>
					<th>Life Expectancy</th>
					<td><input name="lifeExpectancy" class="form-control" id="" value="{$data.LifeExpectancy}" /></td>
				</tr>
				<tr>
					<th>GNP</th>
					<td><input name="gnp" class="form-control" id="" value="{$data.GNP|number_format:2:".":","}" /></td>
				</tr>
				<tr>
					<th>Government Form</th>
					<td><input name="governmentForm" class="form-control" id="" value="{$data.GovernmentForm}" /></td>
				</tr>
				<tr>
					<th>Head of State</th>
					<td><input name="headOfState" class="form-control" id="" value="{$data.HeadOfState}" /></td>
				</tr>
				<tr>
					<th>Capital</th>
					<td><input name="capital" class="form-control" id="" value="{$data.Capital}" /></td>
				</tr>
				<tr>
					<td colspan="2"><button class="btn btn-primary btn-block" type="submit" value="1">Confirm</button></td>
				</tr>
			
		</tbody>
		</table>
	</form>
	{/if}
	</div>
	
	
</div><!-- /.country -->

</nav>