<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>AppUI Email Template - Welcome</title>
<meta name="viewport" content="width=device-width" />
    <style type="text/css">
@media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
    body[yahoo] .buttonwrapper { background-color: transparent !important; }
    body[yahoo] .button { padding: 0 !important; }
    body[yahoo] .button a { background-color: #777777; padding: 15px 25px !important; }
}

@media only screen and (min-device-width: 601px) {
.content { width: 600px !important; }
.col387 { width: 387px !important; }
}
</style>
</head>
<body bgcolor="#ffffff" style="margin: 0; padding: 0;" yahoo="fix">
    <!--[if (gte mso 9)|(IE)]>
<table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
    <td>
    <![endif]-->
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;" class="content">
    <tr>
    <td align="center" style="padding: 20px 20px 20px 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
    {{ HTML::image('assets/admin/img/logo-inter.jpg', 'Barbershop MN', array('class' => 'img-responsive', 'style' => 'margin: 20px auto 0 auto;')) }}
</td>
</tr>
<tr>
<td align="center" bgcolor="#777777" style="padding: 25px 20px 20px 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 26px;">
    <b>Barbershop MN</b>
</td>
</tr>
<tr>
<td align="center" bgcolor="#ffffff" style="padding: 20px 20px 20px 20px; color: #ffffff;">

    </td>
    </tr>
    <tr>
    <td align="center" bgcolor="#f9f9f9" style="padding: 30px 20px 10px 20px; font-family: Arial, sans-serif;">
    <!--table bgcolor="#777777" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
    <tr>
    <td align="center" height="55" style=" padding: 0 35px 0 35px; font-family: Arial, sans-serif; font-size: 22px;" class="button">
    <a href="#" style="color: #ffffff; text-align: center; text-decoration: none;">Sign Up Now</a>
</td>
</tr>
</table-->
</td>
</tr>
<tr>
<td align="center" bgcolor="#f9f9f9" style="padding: 10px 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 18px; line-height: 30px;">
    <b>¡Hola {{ $appointment['title'] }}!</b> tu cita ha sido agendada.
</td>
</tr>
<tr>
<td align="center" bgcolor="#f9f9f9" style="padding: 10px 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 18px; line-height: 30px;">
    Información:
</td>
</tr>
<tr>
<td bgcolor="#ffffff" style="padding: 20px 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">
    <table width="100%">
    <thead>
    <tr>
    <th width="40%"></th>
    <th width="60%"></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td style="text-align: right;"><strong>Nombre:</strong></td>
<td>{{ $appointment['title'] }}</td>
</tr>
<tr>
<td style="text-align: right;"><strong>Fecha agendada:</strong></td>
<td>
{{ \Carbon\Carbon::createFromTimestamp($appointment['start'])->format('d/m/Y G:i A') }}
</td>
</tr>
<tr>
<td valign="top" style="text-align: right;"><strong>Servicios:</strong></td>
<td>
<ul style="padding-left: 0; margin-left: 10px;">
@foreach($appointment['services'] as $service)
<li>
{{ $service['name'] }}
</li>
@endforeach
</ul>
</td>
</tr>

</tbody>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9e9e9" style="padding: 12px 10px 12px 10px; color: #888888; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;">
    {{ date('Y') }} &copy; <a href="http://barbershopmn.com" style="color: #777777;">Barbershopmn.com</a>
    </td>
    </tr>
    <!--tr>
    <td style="padding: 15px 10px 15px 10px;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
    <td align="center" width="100%" style="color: #999999; font-family: Arial, sans-serif; font-size: 12px;">

    </td>
    </tr>
    </table>
    </td>
    </tr-->
    </table>
    <!--[if (gte mso 9)|(IE)]>
</td>
</tr>
</table>
<![endif]-->
</body>
</html>