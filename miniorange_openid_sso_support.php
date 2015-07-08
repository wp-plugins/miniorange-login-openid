<?php

function mo_support(){
?>
	<div class="mosso_support_layout">
		<h3>Support</h3>
			<form name="f" method="post" action="">
				<div>Need any help? Just send us a query so we can help you. <br /><br /></div>
				<div>
					<table>
						<tr><td>
							<input type="email" class="mo2f_table_textbox" id="query_email" name="query_email" value="<?php echo get_option('mo2f_email'); ?>" placeholder="Enter your email" required="true" />
							</td>
						</tr>
						<tr><td>
							<input type="text" class="mo2f_table_textbox" name="query_phone" id="query_phone" value="<?php echo get_option('mo2f_phone'); ?>" placeholder="Enter your phone"/>
							</td>
						</tr>
						<tr>
							<td>
								<textarea id="query" name="query" style="border-radius:4px;" cols="52" rows="7" style="resize: vertical;" onkeyup="mo2f_valid(this)" onblur="mo2f_valid(this)" onkeypress="mo2f_valid(this)" placeholder="Write your query here"></textarea>
							</td>
						</tr>
					</table>
				</div>
				<input type="hidden" name="option" value="mo_2factor_send_query"/>
				<input type="submit" name="send_query" id="send_query" value="Submit Query" style="margin-bottom:3%;" class="button button-primary button-large" />
			</form>
			<br />
	</div>
	<script>
		jQuery("#query_phone").intlTelInput();
		function mo2f_valid(f) {
			!(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(/[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;
		}
	</script>
<?php
}
?>