<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/amplitudejs/app.min.css"/>

<div class="product-audio-preview">
	<div id="single-song-player">
		<img data-amplitude-song-info="cover_art_url"/>
		<div class="bottom-container">
			<progress class="amplitude-song-played-progress" id="song-played-progress"></progress>
			<div class="time-container">
						  <span class="current-time">
								<span class="amplitude-current-minutes"></span>:<span class="amplitude-current-seconds"></span>
						  </span>
				<span class="duration">
            				<span class="amplitude-duration-minutes"></span>:<span class="amplitude-duration-seconds"></span>
						</span>
			</div>
		</div>
	</div>
	<div class="player-control-container">
		<button class="btn btn-secondary btn-backward" onclick="skip_backward();"><i class="icon-backward m-r-5"></i><?php echo trans("backward"); ?></button>
		<button class="btn btn-secondary btn-play-pause amplitude-play-pause"><i class="icon-play m-r-5"></i><?php echo trans("play"); ?>&nbsp;/&nbsp;<i class="icon-pause m-r-5"></i><?php echo trans("pause"); ?></button>
		<button class="btn btn-secondary btn-forward" onclick="skip_forward();"><i class="icon-forward m-r-5"></i><?php echo trans("forward"); ?></button>
	</div>
</div>


<script src="<?php echo base_url(); ?>assets/vendor/amplitudejs/amplitude.min.js"></script>
<script>
    Amplitude.init({
        "songs": [
            {
                "name": "",
                "artist": "",
                "album": "",
                "url": "<?php echo get_product_audio_url($audio); ?>",
                "cover_art_url": "<?php echo get_product_image($product->id, 'image_big'); ?>"
            }
        ]
    });
    window.onkeydown = function (e) {
        return !(e.keyCode == 32);
    };
    document.getElementById('song-played-progress').addEventListener('click', function (e) {
        var offset = this.getBoundingClientRect();
        var x = e.pageX - offset.left;
        Amplitude.setSongPlayedPercentage((parseFloat(x) / parseFloat(this.offsetWidth)) * 100);
    });
    function skip_backward() {
        var progress = $('#song-played-progress').val();
        var progress = progress * 100;
        var new_progress = progress - 5;
        Amplitude.setSongPlayedPercentage(new_progress);
    }
    function skip_forward() {
        var progress = $('#song-played-progress').val();
        var progress = progress * 100;
        var new_progress = progress + 5;
        Amplitude.setSongPlayedPercentage(new_progress);
    }
</script>

