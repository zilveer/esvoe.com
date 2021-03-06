<!-- main-section -->

<div class="container">
	<div class="row">
{{--
		<div class="visible-lg col-lg-2">
			{!! Theme::partial('home-leftbar',compact('trending_tags')) !!}
		</div>
--}}
		<div class="col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading no-bg panel-settings">
					<h3 class="panel-title">
						<a href="{{ url('/'.Auth::user()->username.'/album/show/'.$album->id) }}" class="btn btn-success pull-right">{{ trans('common.view_album') }}</a>
						{{ trans('common.edit_album') }}
					</h3>
				</div>
				<div class="panel-body nopadding">
					<div class="socialite-form">
						@include('flash::message') 
						<form id="albumEditForm" class="margin-right" method="POST" action="{{ url('/'.Auth::user()->username.'/album/'.$album->id.'/edit') }}" files="true" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div id="currentUrl" style="display: none;" data-current_url="{{ url()->current() }}"></div>

							<div class="row">
								<div class="col-md-6">
									<fieldset class="form-group required {{ $errors->has('name') ? ' has-error' : '' }}">
										{{ Form::label('name', trans('auth.name'), ['class' => 'control-label']) }}
										{{ Form::text('name', $album->name, ['class' => 'form-control', 'placeholder' => trans('common.name_of_the_album')]) }}
										@if ($errors->has('name'))
											<span class="help-block">
												{{ $errors->first('name') }}
											</span>
										@endif
									</fieldset>
								</div>
								<div class="col-md-6">
									<fieldset class="form-group required {{ $errors->has('privacy') ? ' has-error' : '' }}">
										{{ Form::label('privacy', trans('common.privacy_type'), ['class' => 'control-label']) }}
										{{ Form::select('privacy', array('' => trans('admin.please_select'), 'private' => trans('common.private'), 'public' => trans('common.public')), $album->privacy ,array('class' => 'form-control')) }}
										@if ($errors->has('privacy'))
											<span class="help-block">
												{{ $errors->first('privacy') }}
											</span>
										@endif
									</fieldset>
								</div>
							</div>

							<fieldset class="form-group">
								{{ Form::label('about', trans('common.about'), ['class' => 'control-label']) }}
								{{ Form::textarea('about', $album->about, ['class' => 'form-control', 'placeholder' => trans('messages.create_album_placeholder'), 'rows' => '4', 'cols' => '20']) }}
							</fieldset>

{{--							<fieldset class="form-group">
								{{ Form::label('album_photos[]', trans('common.add_more_photos'), ['class' => 'control-label']) }}
								{{ Form::file('album_photos[]', ['multiple' => 'multiple', 'accept' =>  'image/jpeg,image/png,image/gif']) }}
							</fieldset>--}}

							<div id="dropzone" class="dropzone"></div>


{{--
							<fieldset class="form-group">
								<div class="pull-right">
									<a href="#" class="add-youtube-input">{{ '+ '.trans('common.one_more') }}</a>
								</div>
								{{ Form::label('album_videos[]', trans('common.youtube_links'), ['class' => 'control-label']) }}
								<div class="youtube-videos">
								
								{{ Form::text('album_videos[]', null, ['class' => 'form-control youtube_link', 'placeholder' => trans('common.copy_paste_youtube_link')] ) }}
								</div>
							</fieldset>
--}}

							<fieldset class="form-group">
								<div class="pull-right">
									{{ Form::submit(trans('common.update_album'), ['class' => 'btn btn-success']) }}
								</div>
							</fieldset>

						</form>
						<progress id="progressbar" value="0" max="100" style="display: none;"></progress>
					</div><!-- /socialite-form -->
				</div>
			</div><!-- /panel -->
		</div>
	</div><!-- /row -->
</div>

<script type="text/javascript">
	/*$('#albumEditForm').on('submit', function(event) {
	    event.preventDefault();
		var $form = $(this),
            formData = new FormData(this),
			$progressBar = $('#progressbar');
		$.ajax({
			url: $form.attr('action'),
			type: $form.attr('method'),
            cache: false,
			contentType: false,
            processData: false,
			data: formData,
            dataType: 'html',
            beforeSend: function() {
                $progressBar.val(0).text('0%').css('display', 'block');
			},
			xhr: function() {
                var xhr = $.ajaxSettings.xhr();
                xhr.upload.addEventListener('progress', function(e) {
                        if(e.lengthComputable) {
                            var percentComplete = Math.ceil(e.loaded / e.total * 100);
                            $progressBar.val(percentComplete).text(percentComplete + '%');
                        }
                }, false);
                return xhr;
			},
			success: function(data, status, xhr) {
				var dom = $.parseHTML(xhr.responseText, true),
					content = '';
                for (i = 0; i < dom.length; i++) {
					if (dom[i].className === 'main-content') {
					    content = dom[i];
					    break;
					}
                }
                if (content) $('.main-content').replaceWith(content);
                try {
                    window.history.pushState(null, null, $('#currentUrl').attr('data-current_url'));
                } catch (e) {}
			},
			error: function(data) {
                $progressBar.val(0).text('0%, error upload');
			}
		});
    });*/

	$('.add-youtube-input').click(function(event) {
	    $('.youtube-videos').append('{{ Form::text('album_videos[]', null, ['class' => 'form-control youtube_link', 'placeholder' => trans('common.copy_paste_youtube_link')] ) }}');
	});
</script>
<link rel="stylesheet" href="/themes/default/assets/js/plugins/dropzone/dropzone.css">
<script src="/themes/default/assets/js/plugins/dropzone/dropzone.js"></script>
<script>
    $(function () {
        var dzone = new Dropzone("#dropzone", {
            url: "{{route('user.album.upload',Auth::user()->username)}}",
            dictDefaultMessage: 'Перетащите или выберите файлы',
            thumbnailWidth: 200,
            thumbnailHeight: 200,
            params: {
                _token: '{{csrf_token()}}'
            }
        });
    })
</script>
<!-- /main-section -->