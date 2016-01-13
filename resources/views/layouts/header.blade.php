<header class="main-header">
	<nav class="navbar navbar-static-top">
	  	<div class="container">
			<div class="navbar-header">
				{!! link_to_route('dashboard.index','Trade Check Report', array(), ['class' => 'navbar-brand']) !!}
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
				  		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Maintenance <span class="caret"></span></a>
				  		<ul class="dropdown-menu" role="menu">
				  			<li>{!! link_to_route('audittemplate.index','Audit Templates') !!}</li>
				  			<li>{!! link_to_route('sostag.index', 'SOS Tags') !!}</li>
				  			<li>{!! link_to_route('soslookup.index','SOS Category Lookup') !!}</li>
				  			<li>{!! link_to_route('secondarydisplay.index','Secondary Display') !!}</li>
				  			<li>{!! link_to_route('secondarylookup.index','Secondary Display Lookup') !!}</li>
				  			<li>{!! link_to_route('osalookup.index','OSA Category Lookup') !!}</li>

				  			<li>{!! link_to_route('formcategory.index','Form Categories') !!}</li>
				  			<li>{!! link_to_route('formgroup.index','Form Groups') !!}</li>
							<li>{!! link_to_route('multiselect.index','Multi Selects') !!}</li>
							<li>{!! link_to_route('singleselect.index','Single Selects') !!}</li>
				  			<li>{!! link_to_route('form.index','Forms') !!}</li>
				  			
							<li>{!! link_to_route('account.index','Accounts') !!}</li>
							<li>{!! link_to_route('customer.index','Customers') !!}</li>
							<li>{!! link_to_route('region.index','Regions') !!}</li>
							<li>{!! link_to_route('distributor.index','Distributors') !!}</li>
							<li>{!! link_to_route('store.index','Stores') !!}</li>
							<li>{!! link_to_route('gradematrix.index','Grading Matrix') !!}</li>
							<li>{!! link_to_route('role.index','Roles') !!}</li>
							<li>{!! link_to_route('user.index','Users') !!}</li>

							
				  		</ul>
					</li>

					<li class="dropdown">
				  		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <span class="caret"></span></a>
				  		<ul class="dropdown-menu" role="menu">
				  			<li>{!! link_to_route('auditreport.index','Audit Report') !!}</li>
				  		</ul>
					</li>
			  	</ul>
			</div><!-- /.navbar-collapse -->
	  	</div><!-- /.container-fluid -->
	</nav>
</header>