<div class="tab-pane" id="seo">
	
	{{ Form::open(array('route' => 'api.page.save.seo')) }}

		{{ Form::hidden('id', $page->id) }}
		{{ Form::hidden('lang', $page->lang) }}
		{{ Form::hidden('section', 'seo') }}

		<div class="form-group" rel="title">

			{{ Form::label('title', t('label.page.seo.title')) }}

			<span class="counter" data-bind="text: titleLen"></span>

			{{ Form::text('title', $page->title, array('class' => 'form-control', 'placeholder' => t('placeholder.page.seo.title'), 'data-bind' => 'value: pageTitle, valueUpdate: "afterkeydown"')) }}

		</div>
		
		<div class="form-group" rel="keyw">

			{{ Form::label('keyw', t('label.page.seo.keyw')) }}
			
			{{ Form::text('keyw', $page->keyw, array('class' => 'form-control', 'placeholder' => t('placeholder.page.seo.keyw'))) }}

		</div>

		<div class="form-group" rel="descr">
			
			{{ Form::label('descr', t('label.page.seo.descr')) }}

			<span class="counter" data-bind="text: descrLen"></span>
			
			{{ Form::textarea('descr', $page->descr, array('class' => 'form-control', 'placeholder' => t('placeholder.page.seo.descr'), 'cols' => 30, 'rows' => 3, 'data-bind' => 'value: pageDescr, valueUpdate: "afterkeydown"')) }}

		</div>

		<div class="form-group" rel="tag">

			{{ Form::label('tag', t('label.page.seo.tag')) }}
			
			{{ Form::text('tag', Tool::getTags($page->tag_array), array('class' => 'form-control pongo-selectize', 'placeholder' => t('placeholder.page.seo.tag'))) }}

		</div>

		<div class="form-submit">
			<button class="btn btn-success pongo-ajax-submit pongo-loading">{{t('form.button.save')}}</button>
		</div>
	
	{{ Form::close() }}

</div>