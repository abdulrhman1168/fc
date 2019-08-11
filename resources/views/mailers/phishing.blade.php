<!DOCTYPE html>
<html dir="rtl" lang="ar">
    <head>
    <meta charset="utf-8">
    </head>

    <body>
        <p style="direction: rtl;">
          أخي الموظف
          <br />

                تم رصد محاولات عديدة للدخول الي حسابكم . في حال نسيانكم كلمة المرور وقيامكم بهذه المحاولات فبإمكانكم استعادة كلمة المرور بالضغط علي

                <a href="{{$url}}">
                    نسيت كلمة المرور
                </a>
                <br/>
                في حال لم تقم بهذه المحاولات برجاء المسارعة بالضغط علي الرابط أدناه وتغير كلمة المرور

                <a href="{{$url}}">تغيير كلمة المرور</a>
                <br />
                مع تحيات الفريق الآمني
        </p>
        <br />
        <p style="direction: ltr;">
        We have noticed several attempts to access to your account. If you forget your password <a href="{{$url}}">click here</a>.

        If you did not do these attempts, please <a href="{{$url}}">contact us</a> immediately.
        <br/>
        Best Regards
        <br/>
        Security team.
        </p>
    </body>

</html>
