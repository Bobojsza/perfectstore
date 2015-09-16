<header class="main-header">
	<nav class="navbar navbar-static-top">
	  	<div class="container">
			<div class="navbar-header">
			  	<a href="../../index2.html" class="navbar-brand"><b>PS</b> Automation</a>
			  	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<i class="fa fa-bars"></i>
			  	</button>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
			  	<ul class="nav navbar-nav">
					<!-- <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> -->
					<!-- <li><a href="#">Link</a></li> -->
					<li class="dropdown">
				  		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Audit <span class="caret"></span></a>
				  		<ul class="dropdown-menu" role="menu">
				  			<li>{!! link_to_route('audit.create','New Audit') !!}</li>
				  			<li>{!! link_to_route('audit.index','Audit List') !!}</li>
				  		</ul>
					</li>

					<li class="dropdown">
				  		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Maintenance <span class="caret"></span></a>
				  		<ul class="dropdown-menu" role="menu">
				  			<li>{!! link_to_route('audittemplate.index','Audit Templates') !!}</li>
				  			<li>{!! link_to_route('form.index','Forms') !!}</li>
				  			<li>{!! link_to_route('formcategory.index','Form Categories') !!}</li>
				  			<li>{!! link_to_route('formgroup.index','Form Groups') !!}</li>
							<li>{!! link_to_route('multiselect.index','Multi Selects') !!}</li>
							<li>{!! link_to_route('singleselect.index','Single Selects') !!}</li>
							<li>{!! link_to_route('account.index','Accounts') !!}</li>
							<li>{!! link_to_route('customer.index','Customers') !!}</li>
							<li>{!! link_to_route('area.index','Areas') !!}</li>
							<li>{!! link_to_route('region.index','Regions') !!}</li>
							<li>{!! link_to_route('distributor.index','Distributors') !!}</li>
							<li>{!! link_to_route('store.index','Stores') !!}</li>
				  		</ul>
					</li>
			  	</ul>
			</div><!-- /.navbar-collapse -->
	  	</div><!-- /.container-fluid -->
	</nav>
</header>