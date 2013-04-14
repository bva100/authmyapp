<?php defined('SYSPATH') or die('No direct script access.');
?>

<?php echo $header ?>

<div class='container' id='primary-container'>
	<div class='row'>
		
		<div class='span3'>
			<?php echo $sidebar ?>
		</div>
		
		<div class='span9'>
			
			<?php if (count($invoices) === 0): ?>
				
				<div class='well well-unit' style='text-align: center'>
					<h3>No Invoices Found</h3>
				</div><!-- .well well-unit -->
				
			<?php else: ?>
				
				<div class='well well-unit' style='text-align: center; padding: 24px'>
					<h3 style='padding: 0px; margin: 0px'>Account Payment History</h3>
				</div><!-- .well well-unit -->
				
				<table class='table table-striped table-bordered table-hover'>
					<thead>
						<tr>
							<th>Date</th>
							<th>Card (Last 4)</th>
							<th>Amount</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($invoices as $invoice): ?>
							<tr>
								<td><?php echo date('m/d/y \a\t g:ia', $invoice->date) ?></td>
								<td><?php echo $invoice->charge->card->type.' - '.$invoice->charge->card->last4 ?></td>
								<td><?php echo $invoice->charge->currency.' '.Num::format( ($invoice->charge->amount/100), 2, TRUE ) ?></td>
								<td>
									<?php if ($invoice->charge->refunded): ?>
										Refunded
									<?php elseif($invoice->paid): ?>
										Paid
									<?php else: ?>
										Not Paid
									<?php endif ?>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				
				<p class='pull-right'>
					Have an issue? Please <?php echo HTML::mailto("support@authmyapp.com", "contact us. ", array('target' => '_blank')) ?>
				</p>
				
			<?php endif ?>
			
		</div>
		
	</div><!-- .row -->
</div><!-- .container -->

<?php echo $footer ?>