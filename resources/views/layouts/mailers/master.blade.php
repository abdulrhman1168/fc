<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta name="x-apple-disable-message-reformatting">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="telephone=no" name="format-detection">
	<title></title><!--[if (mso 16)]>
    <style type="text/css">
    a {text-decoration: none;}
    </style>
    <![endif]-->
	<!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
	<!--[if !mso]><!== -->
	<link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet"><!--<![endif]-->

    @include('layouts.mailers.css')
    
</head>
<body>
	<div class="es-wrapper-color">
		<!--[if gte mso 9]>
            <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                <v:fill type="tile" color="#ffffff"></v:fill>
            </v:background>
        <![endif]-->
		<table cellpadding="0" cellspacing="0" class="es-wrapper" width="100%">
			<tbody>
				<tr>
					<td class="esd-email-paddings" valign="top">
						<table align="center" cellpadding="0" cellspacing="0" class="es-header">
							<tbody>
								<tr>
									<td class="esd-stripe esd-checked" style=" background: url({{env('APP_URL')}}/assets/img/emailheader.png) center center ; background-size: cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-position: 0px 40%;     height: 150px;">
										<table align="center" cellpadding="0" cellspacing="0" class="es-header-body" width="640">
											<tbody>
												<tr>
													<td align="left" class="esd-structure es-p10t es-p20r es-p20l">
														<table cellpadding="0" cellspacing="0" width="100%">
															<tbody>
																<tr>
																	<td align="center" class="esd-container-frame" valign="top" width="600">
																		<table cellpadding="0" cellspacing="0" width="100%">
																			<tbody>
																				<tr>
																					<td align="center" class="esd-block-text es-p20b" style=" padding-top: 15px;"><!-- <h1 style="color: rgb(255, 255, 255);">رسالة اللجان والمجالس</h1> --></td>
																				</tr>
																				<tr>
																					<td align="center" class="esd-block-button es-p5t es-p40b"><!-- <span class="es-button-border">
                                                                                       <a href="https://maj-dev.mu.edu.sa/ozakaria/sec/index.html" class="es-button" target="_blank">رابط </a> </span> 
                                                                                       --></td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
						<table align="center" cellpadding="0" cellspacing="0" class="es-content">
							<tbody>
								<tr>
									<td align="center" class="esd-stripe">
										<br>
										<br>
										<table align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="es-content-body" width="640">
											<tbody>
												<tr>
													<td align="left" class="esd-structure es-p20r es-p20l">
														<table cellpadding="0" cellspacing="0" width="100%">
															<tbody>
																<tr>
																	<td></td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													@yield('page')
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>