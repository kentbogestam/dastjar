<?php
	include_once('cumbari.php');
	header("Location: https://connect.stripe.com/oauth/authorize?response_type=code&client_id=" . $stripe_client_id . "&scope=read_write&redirect_uri=" . $base_url . "reDirectResponseEditCompany.php");
?>