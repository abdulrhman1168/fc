<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta content="ie=edge" http-equiv="X-UA-Compatible">
	<title>تفاصيل طلب بدل سكن</title>
	<style>
	body {
		direction: rtl;
	}
	.inThe {
		text-align: center;
		margin: 4px 0;
	}
	.container {
		width: 100%;
		margin: 0 auto;
	}
	.title {
		display: inline-block;
		width: 33%;
		text-align: right;
	}
	.logo {
		display: inline-block;
		width: 33%;
		text-align: center;
	}
	.title p {
		font-size: 18px;
		font-weight: 600;
		margin: 5px;
	}
	.date {
		display: inline-block;
		width: 33%;
		/* text-align: justify; */
		position: absolute;
		left: -15%;
	}
	.date p {
		font-size: 18px;
		font-weight: 600;
		margin: 5px;
	}
	.title2 {
		width: 100%;
		background: #d9d7d7;
		border: 1px solid #c0bebe;
		padding: 5px;
		text-align: center;
		font-size: 20px;
		font-weight: 600;
		margin: 0;
	}
	.main {
		padding: 10px;
		font-size: 20px;
		font-weight: 600;
	}
	.main p {
	  width: 44%;
	  display: inline-block;
	  border: 1px solid #d3d1d1;
	  padding: 2px 11px;
	  margin: 2px;
	}
	.main span {
		font-size: 19px;
		margin-right: 10px;
		font-weight: 500;
    }
    body
    {
        -webkit-transform: scale(0.85);  /* Saf3.1+, Chrome */
                -moz-transform: scale(0.85);  /* FF3.5+ */
                -ms-transform: scale(0.85);  /* IE9 */
                -o-transform: scale(0.85);  /* Opera 10.5+ */
                    transform: scale(0.85);
            margin: -50px -73px 0;  /* big hack to reposition the page top the top and left of the viewer control */
    }
	</style>
</head>
<body>
	<h1 class="inThe">بسم الله الرحمن الرحيم</h1>
	<div class="container">
		<div class="title">
			<p>المملكة العربية السعودية</p>
			<p>وزارة التعليم</p>
			<p>جامعة المجمعة</p>
			<p>عمادة شؤون أعضاء</p>
			<p>هيئة التدريس والموظفين</p>
			<p>إدارة الرواتب والبدلات</p>
		</div>
		<div class="logo"><img alt="logo" src="https://www.mu.edu.sa//sites/default/themes/majamaahenglish/images/v4/ar/mu_logo.png"></div>
		<div class="date">
			<p>تاريخ الطلب: <span>{{ $request->created_hijri_date }}</span></p>
		</div>
	</div>
	<h1 style="text-align:center;">تفاصيل طلب بدل سكن</h1>
	<div class="userDetails">
		<!-- start container -->
		<p class="title2">بيانات المتقدم</p>
		<div class="main">
			<p>تاريخ الطلب هجري : <span>{{ $request->created_hijri_date }}</span></p>
			<p>اسم المتقدم: <span>{{ $request->applicant->arabic_name }}</span></p>
			<p>الرقم الوظيفي : <span>{{ $request->applicant->employee_id }}</span></p>
			<p>رقم الاقامة : <span>{{ $request->applicant->national_id }}</span></p>
			<p>الوظيفة : <span>{{ $request->applicant->job_info }}</span></p>
			<p>جهة العمل : <span>{{ $request->applicant->actual_dept_code_desc }}</span></p>
			<p>الجنس: <span>{{ $request->applicant->gender_desc }}</span></p>
			<p>العام الدراسي : <span>{{ $request->schoolYear->name }}</span></p>
			<p>الزوج / الزوجة : <span>{{ $request->husband_wife_work_status_name }}</span></p>
			<p>إسم الزوج / الزوجة : <span>{{ $request->husband_or_wife_name }}</span></p>
			<p>رقم إقامة الزوج / الزوجة : <span>{{ $request->husband_or_wife_national_id }}</span></p>
			<p>رقم إقامة الزوج / الزوجة : <span>{{ $request->husband_or_wife_place_of_work }}</span></span></p>
			<p>مكان عمل الزوج / الزوجة : <span>{{ $request->companions_no }}</span></p>
			<p>عدد المرافقين : <span>{{ $request->status_name }}</span></p>
			<p style="width:90%">نعم : <span>اقر بصحة بياناتي وفي حال تبين خلاف ذلك فاءنني أكون مسئول عن أي التزامات مالية أو عينية تقرها إدارة الجامعة</span></p><!-- end container -->
        </div><!-- start container -->
        
        @if($request->current_step > 2)

		<p class="title2">عمادة شئون أعضاء هيئة التدريس والموظفين / إدارة شئون أعضاء هيئة التدريس والموظفين</p>
		<div class="main">
			<p>تاريخ التوقيع بالهجري : <span>{{ $request->step_3_approval_date }}</span></p>
			<p>إسم الموظف المختص : <span>{{ $request->step3Approval->arabic_name }}</span></p>
			<p>التاريخ الهجري لبداية عقده : <span>{{ $request->step_4_contract_start_date }}</span></p>
			<p>هل صرف له بدل سكن في العقود السابقة ؟ : <span>{{ $request->step_4_is_get_allowance_prev == 1 ? 'نعم' : 'لا' }}</span></p>
        </div><!-- start container -->

        @endif
        
        @if($request->current_step > 3)
            <p class="title2">عمادة شئون أعضاء هيئة التدريس والموظفين / إدارة الخدمات المساندة</p>
            <div class="main">
                <p>تاريخ التوقيع بالهجري : <span>{{ $request->step_4_approval_date }}</span></p>
                <p>إسم الموظف المختص : <span>{{ $request->step4Approval->arabic_name }}</span></p>
                <p>عدد التابعين : <span>{{ $request->step_5_companions_no }}</span></p>
                <p>اسم الزوج / الزوجة : <span>{{ $request->step_5_husband_wife_name }}</span></p>
                <p>رقم إقامة الزوج / الزوجة : <span>{{ $request->step_5_husband_national_id }}</span></p>
                <p>التاريخ الهجري لأخر إستقدام : <span>{{ $request->step_5_last_recruitment_date }}</span></p>
                <p>هل تم صرف أوامر ركاب لعائلته ؟ : <span>{{ $request->step_5_is_get_trav_for_family == 1? 'نعم' : 'لا' }}</span></p>
                <p>سبق للمذكور استقدام عائلته ؟ : <span>{{ $request->step_5_is_recruitment_before == 1? 'نعم' : 'لا' }}</span></p>
            </div><!-- start container -->
        @endif

        @if($request->current_step > 4)
            <p class="title2">الإدارة العامة للمرافق والإسكان / إدارة الإسكان</p>
            <div class="main">
                <p>تاريخ التوقيع بالهجري : <span>{{ $request->step_5_approval_date }}</span></p>
                <p>إسم الموظف المختص : <span>{{ $request->step5Approval->arabic_name }}</span></p>
                <p>إستحقاقه لبدل السكن : <span>{{ $request->housing_allowance_status_name }}</span></p>
            </div><!-- start container -->
        @endif
        
        @if($request->current_step > 5)
            <p class="title2">عمادة شئون أعضاء هيئة التدريس والموظفين / إدارة الرواتب</p>
            <div class="main">
                <p>تاريخ التوقيع بالهجري : <span>{{ $request->step_6_approval_date }}</span></p>
                <p>إسم الموظف المختص : <span>{{ $request->step6Approval->arabic_name }}</span></p>
            </div>
        @endif
    </div>
    
    <script>
       window.print();
    </script>
</body>
</html>
