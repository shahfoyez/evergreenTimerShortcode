function timer_function( $atts ){
		$interval = $atts['interval'];
	?>
		<style>
			.foy-countdown .foy-time{
				font-size: 30px;
				margin-top: 0px;
				color: #ffffff;
				background: #424242;
				padding: 5px;
				margin: 0px;
			}
			.foy-countdown .foy-dot{
				font-size: 25px;
				margin-top: 0px;
				color: #ffffff;
				background: #424242;
				padding: 3px 0px 5px 0px;
				margin: 0px;
			}
			.foy-time-label{
				margin: 0px;
				font-size: 10px;
			}
			.foy-countdown .foy-countdown-items{
				display: flex;
				justify-content: center;
			}
			.foy-countdown .foy-days, .foy-hours, .foy-minutes, .foy-seconds{
				text-align: center;
				padding: 0px 5px 0px 5px;
				width: 20%;
			}
			.foy-countdown .foy-days p, .foy-hours p, .foy-minutes p, .foy-seconds p, .foy-divider p{
				line-height: 24px;
				text-transform: uppercase;
			}
		</style>
		<div class="foy-countdown">
			<div class="foy-countdown-items"> 
				<div class="foy-days">
					<p class="foy-time days" id="days"></p>
					<p class="foy-time-label"> Days</p>
				</div>
				<div class="foy-divider foy-days-divider">
					<p class="foy-dot">:</p>
					<p class="foy-time-label"></p>
				</div>
				<div class="foy-hours">
					<p class="foy-time hours" id="hours"></p>
					<p class="foy-time-label"> Hours</p>
				</div>
				<div class="foy-divider">
					<p class="foy-dot">:</p>
					<p class="foy-time-label"></p>
				</div>
				<div class="foy-minutes">
					<p class="foy-time mins" id="mins"></p>
					<p class="foy-time-label"> Minutes</p>
				</div>
				<div class="foy-divider">
					<p class="foy-dot">:</p>
					<p class="foy-time-label"></p>
				</div>
				<div class="foy-seconds">
					<p class="foy-time secs" id="secs"></p>
					<p class="foy-time-label"> Seconds</p>
				</div>
			</div>
		</div>
		<?php
			global $wpdb;
			$results = $wpdb->get_results("SELECT * FROM wp_timer WHERE id = 1");
			foreach ($results as $time){
				$end_time =  $time->end_time;
			} 
			date_default_timezone_set("Asia/Dhaka");
			$current_date =date('Y-m-d H:i:s');
		 	
			if ( $current_date <  $end_time ) { ?>
				<script>
				// Set the date we're counting down to
				var database_time = <?php echo json_encode($end_time, JSON_HEX_TAG); ?>;
				var countDownDate = new Date(database_time).getTime();
				
				// Update the count down every 1 second
				var x = setInterval(function() {
					// Get today's date and time
					var now = new Date().getTime();
						
					// Find the distance between now and the count down date
					var distance = countDownDate - now;
						
					// Time calculations for days, hours, minutes and seconds
					var days = Math.floor(distance / (1000 * 60 * 60 * 24));
					var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
					var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					var seconds = Math.floor((distance % (1000 * 60)) / 1000);
						
					// Result is output to the specific element
					days = ("0" + days).slice(-2)
					var elems = document.getElementsByClassName("days");
					for(var i = 0; i < elems.length; i++) {
						elems[i].innerHTML = days;
					}
					
					hours = ("0" + hours).slice(-2)
					var elems = document.getElementsByClassName("hours");
					for(var i = 0; i < elems.length; i++) {
						elems[i].innerHTML = hours ;
					}

					minutes = ("0" + minutes).slice(-2)
					var elems = document.getElementsByClassName("mins");
					for(var i = 0; i < elems.length; i++) {
						elems[i].innerHTML = minutes ;
					}
				 
					seconds = ("0" + seconds).slice(-2)
					var elems = document.getElementsByClassName("secs");
					for(var i = 0; i < elems.length; i++) {
						elems[i].innerHTML = seconds ;
					}
				 
						
					// If the count down is over
					if (distance < 0) {
						clearInterval(x);
						var elems = document.getElementsByClassName("days");
						for(var i = 0; i < elems.length; i++) {
							elems[i].innerHTML = '00';
						}
						var elems = document.getElementsByClassName("hours");
						for(var i = 0; i < elems.length; i++) {
							elems[i].innerHTML = '00';
						}
						var elems = document.getElementsByClassName("mins");
						for(var i = 0; i < elems.length; i++) {
							elems[i].innerHTML = '00';
						}
						var elems = document.getElementsByClassName("secs");
						for(var i = 0; i < elems.length; i++) {
							elems[i].innerHTML = '00';
						}
					}
				}, 1000);
				</script>
			<?php
			}else{
				$date = $end_time;
				$new_time = date('Y-m-d H:i:s', strtotime($date. ' + '.$interval.' hours'));
				$execute = $wpdb->query
				("
				UPDATE `wp_timer` 
				SET `end_time` = '$new_time'
				WHERE `wp_timer`.`id` = 1
				");
			}
	}
	add_shortcode( 'evergreen-timer', 'timer_function' );