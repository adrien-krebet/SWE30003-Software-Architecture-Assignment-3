<?php
	interface InfoFormat {
		public function customerLayout();  //access level 1
		public function shipperLayout();  //access level 2
		public function adminLayout();  //access level 3 (ADMIN)
	}
?>