<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Automatic Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin:0; padding:10px 0 0 0;" bgcolor="#F8F8F8">
    <div class="invoice">
        <div class="mail_header" style="background: #4CAF50;padding:10px; color:#fff; margin-bottom:20px; width:90%;">
            <h5 style="padding: 0; margin: 0;">Payment Invoice</h5>
            <h3 style="padding: 0; margin: 0;">'.$this->settings['site_name'].'</h3>
        </div>
        <div class="" style="margin-bottom: 10px; overflow:hidden;">
                <table class="table" style="width: 45%;float: left;">
                    <tbody>
                        <tr><td><strong style="width: 150px; display: inline-block;">Name:</strong> '.$user_info['username'].'</td></tr>
                        <tr><td><strong style="width: 150px; display: inline-block;">Email:</strong>'.$user_info['email'].'</td></tr>
                        <tr><td><strong style="width: 150px; display: inline-block;">paid via:</strong>'.$payment_via.'</td></tr>
                    </tbody>
                </table>
                <table class="table" style="width: 55%;float: left;">
                    <tbody>
                        <tr><td><strong style="width: 150px; display: inline-block;">Date:</strong> '.full_time(d_time()).'</td></tr>
                        <tr><td><strong style="width: 150px; display: inline-block;">Transaction ID:</strong> '.$data['txn_id'].'</td></tr>
                        <tr><td><strong style="width: 150px; display: inline-block;">From:</strong>'.$this->settings['site_name'].'</td></tr>
                    </tbody>
                </table>
        </div>
        
        <div class="row mail_content" style="border:1px solid #d6d6d6; background-color:#f3f3f3; padding:10px;">
            <div class="col-md-12">
                <div class="mail_template">
                    <table>
                        <tr>
                            <td><em>Account Expire reminder from </em> <b>'.$setting['site_name'].'</b></td>
                        </tr>
                        <tr>
                            <td>Name: </td>
                            <td> <b>'.{username}.'</b></td>
                        </tr>
                        <tr>
                            <td>Email: </td>
                            <td> <b>'.{email}.'</b></td>
                        </tr>

                        <tr>
                            <td>End Date: </td>
                            <td> <b>'.full_time(end_date).'</b></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td> <b>'.{day_left}.'</b></td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

