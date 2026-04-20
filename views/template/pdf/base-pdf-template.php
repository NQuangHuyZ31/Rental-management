<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= isset($title) ? 'HOSTY - ' . htmlspecialchars($title) : 'HOSTY' ?></title>
	<link rel="icon" href="<?= BASE_URL ?>/Public/images/favicon.ico">
	<!-- FontAwesome CDN -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<!-- App.css -->
	<link rel="stylesheet" href="<?= BASE_URL ?>/Public/css/app.css?v=<?= rand() ?>">
	<!-- Toastr -->
	<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
	<!-- Empty States CSS -->
	<link rel="stylesheet" href="<?= BASE_URL ?>/Public/css/empty-states.css">
	<!-- Pagination CSS -->
	<link rel="stylesheet" href="<?= BASE_URL ?>/Public/css/pagination.css">
	<!-- Fix Scrollbar CSS -->
	<link rel="stylesheet" href="<?= BASE_URL ?>/Public/css/fix-scrollbar.css">
	<!-- Payment Modal CSS -->
	<link rel="stylesheet" href="<?= BASE_URL ?>/Public/css/payment-modal.css">
	<!-- Bootstrap Datepicker -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
	<main>
		<?= $content ?>
	</main>
</body>

</html>