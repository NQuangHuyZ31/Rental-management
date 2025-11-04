<style>
	body {
		font-family: DejaVu Sans, sans-serif;
		font-size: 12px;
		color: #333;
		margin: 0;
		padding: 20px;
	}

	.invoice-card {
		background: #fff;
		border: 1px solid #ddd;
		border-radius: 6px;
		padding: 20px;
	}

	.invoice-header {
		margin-bottom: 10px;
	}

	.header-table {
		width: 100%;
		border-collapse: collapse;
	}

	.logo-box {
		width: 45px;
		height: 45px;
		background-color: #4f46e5;
		border-radius: 8px;
		display: inline-block;
		text-align: center;
		vertical-align: middle;
	}

	.logo-icon {
		width: 28px;
		height: 28px;
		margin-top: 8px;
	}

	.header-info {
		display: inline-block;
		margin-left: 8px;
		vertical-align: top;
	}

	.title {
		font-size: 14px;
		font-weight: 700;
	}

	.sub {
		font-size: 11px;
		color: #555;
	}

	.header-right {
		text-align: right;
	}

	.invoice-meta {
		font-size: 11px;
		color: #666;
	}

	.invoice-title {
		font-size: 16px;
		color: #4338ca;
		font-weight: 700;
		margin: 4px 0;
	}

	.invoice-details {
		font-size: 11px;
		color: #444;
		line-height: 1.4;
	}

	.section {
		margin-top: 20px;
	}

	.info-grid {
		display: flex;
		justify-content: space-between;
		gap: 20px;
	}

	.info-box {
		background: #f9fafb;
		padding: 10px;
		border-radius: 6px;
		width: 48%;
	}

	.info-box h3 {
		font-size: 12px;
		font-weight: bold;
		color: #444;
		margin-bottom: 6px;
	}

	.info-box p {
		margin: 3px 0;
		font-size: 12px;
	}

	.info-box span {
		font-weight: bold;
	}

	table {
		width: 100%;
		border-collapse: collapse;
		font-size: 12px;
		margin-top: 20px;
	}

	th,
	td {
		border: 1px solid #ddd;
		padding: 6px 8px;
	}

	th {
		background: #f3f4f6;
		text-align: left;
		font-weight: bold;
	}

	td.text-right,
	th.text-right {
		text-align: right;
	}

	tfoot td {
		background: #f9fafb;
		font-weight: bold;
	}

	.total {
		color: #4f46e5;
		font-size: 14px;
	}

	.red {
		color: #d00;
	}

	.payment-box {
		background: #f9fafb;
		padding: 10px;
		border-radius: 6px;
		width: 35%;
	}

	.payment-box .amount {
		color: #4f46e5;
		font-size: 18px;
		font-weight: bold;
	}

	.footer-note {
		font-size: 11px;
		color: #666;
		margin-top: 20px;
		font-style: italic;
	}

	hr {
		border: none;
		border-top: 1px solid #ddd;
		margin: 10px 0;
	}

	.text-right {
		text-align: right;
	}
</style>
</head>

<body>
	<div class="invoice-card">
		<div class="invoice-header">
			<table class="header-table">
				<tr>
					<td valign="top">
						<div class="header-info">
							<div class="title"><?= $house['house_name'] ?></div>
							<div class="sub">Địa chỉ: <?= $house['address'] ?>, <?= $house['ward'] ?>, <?= $house['province'] ?></div>
							<div class="sub">Hotline: <?= $owner['phone'] ?></div>
						</div>
					</td>
					<td align="right" valign="top">
						<div class="invoice-meta">Mẫu hóa đơn</div>
						<div class="invoice-title">HÓA ĐƠN TIỀN PHÒNG</div>
						<div class="invoice-details">
							<div><b>Số hóa đơn:</b> <?= $invoice['ref_code'] ?></div>
							<div><b>Ngày tạo:</b> <?= date('d-m-Y', strtotime($invoice['invoice_day'])) ?></div>
							<div><b>Hạn thanh toán:</b> <?= date('d-m-Y', strtotime($invoice['due_date'])) ?></div>
						</div>
					</td>
				</tr>
			</table>
		</div>

		<hr>

		<div class="section info-grid">
			<?php

			use Helpers\Format;

			foreach ($tenants as $tenant) { ?>
				<div class="info-box">
					<h3>Người thuê</h3>
					<p><span>Tên:</span> <?= $tenant['username'] ?></p>
					<p><span>SĐT:</span> <?= $tenant['phone'] ?></p>
					<p><span>Địa chỉ:</span> <?= $room['room_name'] . ', ' . $house['house_name'] ?></p>
				</div>
			<?php } ?>

			<div class="info-box">
				<h3>Thông tin phòng</h3>
				<p><span>Phòng:</span> <?= $room['room_name'] ?></p>
				<p><span>Kỳ:</span> Tháng <?= $invoice['invoice_month'] ?></p>
				<p><span>Người quản lý:</span> <?= $owner['username'] ?></p>
			</div>
		</div>

		<table>
			<thead>
				<tr>
					<th>Mô tả</th>
					<th>Số cũ</th>
					<th>Số mới</th>
					<th class="text-right">Số lượng</th>
					<th class="text-right">Đơn giá (VNĐ)</th>
					<th class="text-right">Thành tiền (VNĐ)</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Tiền phòng (Tháng)</td>
					<td></td>
					<td></td>
					<td class="text-right">1</td>
					<td class="text-right"><?= Format::forMatPrice($invoice['rental_amount']) ?></td>
					<td class="text-right"><?= Format::forMatPrice($invoice['rental_amount']) ?></td>
				</tr>
				<?php foreach ($services as $service) { ?>
					<tr>
						<td><?= $service['service_name'] ?> (<?= $service['usage_amount'] ?> <?= $service['unit'] ?> × <?= Format::forMatPrice($service['unit_price']) ?>)</td>
						<td><?= $service['old_value'] ?></td>
						<td><?= $service['new_value'] ?></td>
						<td class="text-right"><?= $service['usage_amount'] ?></td>
						<td class="text-right"><?= Format::forMatPrice($service['unit_price']) ?></td>
						<td class="text-right"><?= Format::forMatPrice($service['total_service']) ?></td>
					</tr>
				<?php } ?>
				<tr>
					<td colspan="5" class="text-right total">Tổng thanh toán</td>
					<td class="text-right total"><?= Format::forMatPrice($invoice['total']) ?></td>
				</tr>
				</tfoot>
		</table>

		<div class="section" style="display:flex;justify-content:space-between;align-items:flex-start;margin-top:20px;">
			<?php if ($invoice['invoice_status'] == 'pending') { ?>
				<div style="width:60%;">
					<h4 style="font-size:12px;font-weight:bold;margin-bottom:4px;">Hướng dẫn thanh toán</h4>
					<p>Chuyển khoản tới STK: <strong><?= $banking['bank_account_number'] ?> - <?= $banking['bank_account_name'] ?></strong> (Chủ TK: <?= $banking['user_bank_name'] ?>)</p>
					<p>Hoặc thanh toán trực tiếp trên Hosty <a href="<?= BASE_URL ?>/customer/bills">Tại đây</a>.</p>
				</div>
			<?php } ?>

			<div class="payment-box" style="display: flex;align-items: center;">
				<div style="margin-right: 20px;">
					<div class="label">Số tiền cần thanh toán</div>
					<div class="amount"><?= Format::forMatPrice($invoice['total']) ?> VNĐ</div>
				</div>
				<div>
					<div style="font-size: 15px; <?= $invoice['invoice_status'] != 'pending' ? 'color: white; width: 50%; padding: 5px 5px; border-radius: 4px; background-color: green;' : 'color: red;' ?>">
						<i class="fas fa-<?= $invoice['invoice_status'] != 'pending' ? 'check' : 'warning' ?>"></i><span style="margin-left: 5px;"><?= $invoice['invoice_status'] != 'pending' ? 'Đã thanh toán' : 'Chưa thanh toán' ?></span>
					</div>
					<?php if ($invoice['invoice_status'] != 'pending') { ?>
						<p style="font-weight: bold;font-size: 13px;">Ngày thanh toán: <?= date('d-m-Y', strtotime($invoice['pay_at'])) ?></p>
					<?php } ?>
				</div>
			</div>
		</div>

	</div>

	<div class="footer-note">
		Ghi chú: Hóa đơn này được lập theo thông tin do người thuê cung cấp. Mọi thắc mắc xin liên hệ <?= $owner['phone'] ?>.
	</div>
	</div>