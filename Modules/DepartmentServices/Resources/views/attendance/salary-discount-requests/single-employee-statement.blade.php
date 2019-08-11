<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta content="ie=edge" http-equiv="X-UA-Compatible">
	<link href="style.css" rel="stylesheet">
    <title>Absence</title>
    {{ Html::style(mix('assets/css/statement-print.css')) }}
</head>
<body>
	<h1 class="inThe">بسم الله الرحمن الرحيم</h1>
	<div class="container">
		<div class="title">
			<p>المملكة العربية السعودية</p>
			<p>وزارة التعليم</p>
			<p>جامعة المجمعة</p>
			<p>الإدارة العامة للمتابعة</p>
		</div>
		<div class="logo"><img alt="logo" src="https://www.mu.edu.sa//sites/default/themes/majamaahenglish/images/v4/ar/mu_logo.png"></div>
		<div class="date">
			<p>التاريخ : <span>{{ todayHijriDate() }}</span></p>
            <p>الموافق : <span>{{ todayDate() }}</span></p>
            <p>إفادة لشهر : <span>{{ $month .'-' . $year }}</span></p>
		</div>
	</div>
	<h1 style="text-align:center;">طلب إفادة غياب وتأخر عن عمل</h1><br>
	<div class="userDetails">
		<table class="useTable">
			<tr>
				<th>الرقم الوظيفي</th>
				<th>اسم الموظف</th>
				<th>السجل المدني</th>
				<th>الجهة</th>
			</tr>
			<tr>
				<td>{{ $employee->emp_jobid}}</td>
                <td>{{ $employee->emp_name }}</td>
                <td>{{ $employee->natio_id }}</td>
				<td>{{ Auth::user()->employeeObject->department->name}}</td>
			</tr>
		</table>
	</div><br>
	<h2>السلام عليكم ورحمة الله وبركاته... وبعد :</h2>
	<p class="about">نأمل منكم إفادتنا عن سبب تغيبكم عن الدوام خلال الفترة من إلي حسب الموضح أدناه :</p><!-- start absens -->
	<h2>الغياب:</h2>
	<div class="userDetails">
		<table class="useTable">
			<tr>
				<th>اليوم</th>
				<th width="50%">السبب</th>
				<th>رأي المدير المباشر</th>
			</tr>
			@foreach(explode(',', $employee->all_absent_dates) as $day)
			<tr>
				<td>{{ $day }}</td>
				<td></td>
				<td>
						<input type="checkbox"> 
							<span class="select">
								لايوجد عذر
							</span> 
						<input type="checkbox"> 
						  <span class="select">
							   يوجد عذر
							</span><br>
				</td>
			</tr>
			@endforeach
		</table>
	</div><br>
	<div class="total">
		إجمالي ايام الغياب :<span> {{ $employee->numof_absentdays}}</span>
	</div><br>
	<!-- end absens -->
     <!-- start lat -->
     <h2>التأخير:</h2>
	<div class="total">
	إجمالي ساعات التأخير :<span> {{ str_replace(["days", "Minutes", "Hours"], [__('departmentservices::app.days'), __('departmentservices::app.minutes'), __('departmentservices::app.hours')],$employee->overall_late)}}</span>
	</div><!-- end lat -->
	<h2>افادة الموظف :</h2>.................................................................................................................................................................................................................................................................... .................................................................................................................................................................................................................................................................... ....................................................................................................................................................................................................................................................................
	
	<br/>
	<div class="signature">
		<h3>عميد/مدير</h3>........................................................<br>
		........................................................<br>
		........................................................
	</div>
</body>
</html>
