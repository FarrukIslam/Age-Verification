<?php 

echo '
	<form name="sampleform" id="av_verify_form" action="' . esc_url( home_url( '/' ) ) . '" method="post">

	<script>
			function autotab(original,destination){
			if (original.getAttribute&&original.value.length==original.getAttribute("maxlength"))
			destination.focus()
			}
	  </script>
		<p><input type="text" name="av_verify_m" id="av_verify_m" maxlength="2" value="" placeholder="MM" onKeyup="autotab(this, document.sampleform.av_verify_d)"/>
		
		<input type="text" name="av_verify_d" id="av_verify_d" maxlength="2" value="" placeholder="DD" onKeyup="autotab(this, document.sampleform.av_verify_y)"/>
		
		
		<input type="number" name="av_verify_y" id="av_verify_y" maxlength="4" value="" placeholder="YYYY"  min="1900" onKeyup="autotab(this, document.sampleform.av_mail)"/>
		
		
		<input type="email" name="av_mail" id="av_mail" maxlength="50" value="" placeholder="exmal@gmail.com" /></p>
		
	</form>	
	';