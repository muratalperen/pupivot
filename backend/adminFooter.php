		</main>
		<footer>
      <a href="https://github.com/muratalperen/pupivot" target="_blank"><?php echo _w('poweredByText'); ?></a>
			<br><br>
			<a href="#" style="text-decoration:underline;"><?php echo _w('goToTop'); ?></a>
    </footer>

		<?php
	  if (isset($_GET['result']))
	  {
	    echo '
			<script type="text/javascript">
				window.onload = function (){
					alert("' . _w( ($_GET['result'] === 'true') ? 'procSuccess' : ( ($_GET['result'] === 'false') ? 'procError' : htmlspecialchars($_GET['result']) ) ) . '");
				}
			</script>
			';
	  }
	  ?>

  </body>
</html>
