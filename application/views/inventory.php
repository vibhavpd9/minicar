<?php
    require_once 'includes/header.php';
?>
<!-- Add jQuery library -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="<?=base_url()?>assets/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

<link rel="stylesheet" href="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
	function openReceipt(ele){
		var myWindow = window.open(ele, "", "width=380, height=550");
	}	
</script>




<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Inventory</h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
					<?php
                        if (!empty($alert_msg)) {
                            $flash_status = $alert_msg[0];
                            $flash_header = $alert_msg[1];
                            $flash_desc = $alert_msg[2];

                            if ($flash_status == 'failure') {
                                ?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-warning" role="alert">
										<i class="icono-exclamationCircle" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
					<?php	
                            }
                            if ($flash_status == 'success') {
                                ?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-success" role="alert">
										<i class="icono-check" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
					<?php

                            }
                        }
                    ?>
					
				
					
					
					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							
						<div class="table-responsive">
							<table class="table">
							    <thead>
							    	<tr>
								    	<th width="10%">Serial No</th>
								    	<th width="20%">Manufacturer Name</th>
								    	<th width="10%">Model Name</th>
								    	<th width="15%">Count</th>
								    	<th width="10%">Sold Button</th>
								    
									</tr>
							    </thead>
								<tbody>
								<?php
                                    if (count($results) > 0) {
                                    	$i=1;
                                        foreach ($results as $data) {
                                            $id = $data->id;
                                          
                                            $name = $data->fullname;
                                          
                                            $cat_id = $data->manufacturer;
                                      /*      $cost = $data->purchase_price;
                                            $price = $data->retail_price;
                                            $thumbnail = $data->thumbnail;
                                            $status = $data->status;*/
                                              
                                            $category_name = '-';
                                            $categoryData = $this->Constant_model->getDataOneColumn('manufacturer', 'id', $cat_id);
                                            if (count($categoryData) > 0) {
                                                $category_name = $categoryData[0]->fullname;
                                            }

                                            $large_file_path = ''; ?>
											<tr>
												<td><?php echo $i++; ?></td>

												
												<td><?php echo $category_name; ?></td>
												<td><?php echo $name; ?></td>

												<td>
													2
												</td>
												<td>	
													<form action="<?=base_url()?>models/deleteModels" method="post" onsubmit="return confirm('Do you want to Sold this Models?')">
								<input type="hidden" name="id" value="<?php echo $id; ?>" />
								<input type="hidden" name="mod_fn" value="<?php echo $name; ?>" />
									<input type="hidden" name="mod_man" value="<?php echo $cat_id; ?>" />
								<button type="submit" class="btn btn-primary" style="border: 0px; background-color: #c72a25;">
									Sold
								</button>
							</form>
						</td>
												
												
											</tr>
								<?php
                                            unset($id);
                                            unset($code);
                                            unset($name);
                                            unset($cat_id);
                                            unset($cost);
                                            unset($price);
                                            unset($thumbnail);
                                            unset($status);
                                        }
                                    } else {
                                        ?>
										<tr class="no-records-found">
											<td colspan="3"><?php echo $lang_no_match_found; ?></td>
										</tr>
								<?php

                                    }
                                ?>
								</tbody>
							</table>
						</div>
							
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6" style="float: left; padding-top: 10px;">
							<?php echo $displayshowingentries; ?>
						</div>
						<div class="col-md-6" style="text-align: right;">
							<?php echo $links; ?>
						</div>
					</div>
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once 'includes/footer.php';
?>