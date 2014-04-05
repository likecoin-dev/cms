{{-- */ if(!isset($page_id)) $page_id = 0; /* --}}

<div class="right-bar">

	<div class="right-body">

		<header>

			<h2>{{t('heading.file.bar_title')}}</h2>

		</header>

		<div class="dn paginate">

			<ol class="dn-list list">

				{{Load::fileList($page_id)}}

			</ol>

		</div>

	</div>

</div>