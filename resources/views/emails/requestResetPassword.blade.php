<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Document</title>
</head>

<body>
<table style="width: 768px; border-collapse: collapse; background: #FFF">
  <tbody>
    <tr>
      <td style="padding: 0 20px 0 0; background: #2F3847;">
        <img src="https://networkresource.s3.ap-southeast-1.amazonaws.com/file9brqnl24hl7vq9rnfh6pr03fa8" style="height:64px;">
      </td>
    </tr>
    <tr>
      <td style="padding: 0 20px; height: 60px; line-height: 60px;">
        <span style="font-size: 18px">Dear</span>
        <span style="color: #0099E8; font-size: 18px;">{{$email ?? ''}}</span>
        <span style="font-size: 18px">user:</span>
      </td>
    </tr>
    <tr>
      <td style="padding: 0 20px 20px 20px; color: #777;">
        You have selected retrive by email selection to retrive you password.Please click the following link to reset you password
      </td>
    </tr>
    <tr>
      <td>
        <div style="display: inline-block; font-size: 18px; color: #0099E8; background: #E7F5FC; padding: 20px 15px; margin: 0 20px;">
          <a style="color: #0099E8; text-decoration: none;" href="{{$jump_url}}" target="_blank">{{$jump_url}}</a>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding: 20px; color: #777;">This link is valid for 2hours,please reset your password within the period,your access to retrive password for each day are not allowed more than 5 times. Thanks for your support and wish you all the best!</td>
    </tr>
    <tr>
      <td style="background: #FAFAFA; font-size: 14px; padding: 20px 20px 0 20px; color: #777;">If you have any question, please contact us through emial <span style="color: #0099E8;">support@idvert.com</span></td>
    </tr>
    <tr>
      <td style="background: #FAFAFA; font-size: 14px; padding: 0 20px 0 20px; color: #777;">We'll get it back to you as soon as possible. </td>
    </tr>
    <tr>
      <td style="background: #FAFAFA; font-size: 14px; padding: 0 20px 20px 20px; color: #777;">This email is automatically sent by Idvert system. Please do not directly reply this email.</td>
    </tr>
  </tbody>
</table>
</body>
</html>
